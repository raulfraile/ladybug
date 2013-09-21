<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Renderer;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Ladybug\Theme\ThemeResolver;
use Ladybug\Format\ConsoleFormat;
use Ladybug\Renderer\Twig\Extension\ConsoleExtension;

/**
 * ConsoleRenderer renders a collection of nodes in CLI
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class ConsoleRenderer extends AbstractTemplatingRenderer
{

    /** @var ConsoleOutputInterface $console */
    protected $console;

    protected $tags = array(
        'intro' => PHP_EOL,
        'tab' => '  ',
        'space' => ' '
    );

    public function __construct(ThemeResolver $themeResolver, ConsoleOutputInterface $console = null)
    {
        $this->console = is_null($console) ? new ConsoleOutput() : $console;

        parent::__construct($themeResolver);
    }

    protected function loadTemplatingEngine()
    {
        if (!$this->isLoaded) {
            parent::loadTemplatingEngine();

            // load styles
            foreach ($this->theme->getCliStyles() as $key => $item) {
                if (is_array($item)) {
                    $style = new OutputFormatterStyle($item[0], $item[1]);
                } else {
                    $style = new OutputFormatterStyle($item);
                }

                $this->console->getFormatter()->setStyle($key, $style);
            }
        }
    }

    public function render(array $nodes, array $extraData = array())
    {
        $this->loadTemplatingEngine();

        $result = $this->templatingEngine->render('layout.console.twig', array_merge(
            array(
                'nodes' => $nodes
            ), $extraData
        ));

        $result = preg_replace('/\s/', '', $result);

        $tags = array_merge($this->tags, $this->theme->getCliTags());
        foreach ($tags as $tag => $replacement) {
            $result = str_replace(sprintf('<%s>', $tag), $replacement, $result);
        }

        // @todo: clean
        $result = str_replace('<t_>', '', $result);
        $result = str_replace('</t_>', '', $result);

        return $this->console->writeln($result);
    }

    public function getFormat()
    {
        return ConsoleFormat::FORMAT_NAME;
    }

    public function getExtension()
    {
        return new ConsoleExtension();
    }

}
