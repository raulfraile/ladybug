<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Render;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Ladybug\Theme\ThemeResolver;
use Ladybug\Format\ConsoleFormat;

class ConsoleRender extends AbstractTemplatingRender
{

    protected $console;

    public function __construct(ThemeResolver $themeResolver, ConsoleOutputInterface $console = null)
    {
        if (!is_null($console)) {
            $this->console = $console;
        } else {
            $this->console = new ConsoleOutput();
        }

        parent::__construct($themeResolver);
    }

    protected function loadTemplatingEngine()
    {
        if (!$this->isLoaded) {
            parent::loadTemplatingEngine();

            // load styles
            foreach ($this->theme->getCliColors() as $key => $item) {
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
        $result = str_replace('<intro>', PHP_EOL, $result);
        $result = str_replace('<tab>', '<f_tab> · </f_tab>', $result);
        $result = str_replace('<space>', ' ', $result);
        $result = str_replace('<t_>', '', $result);
        $result = str_replace('</t_>', '', $result);

        return $this->console->writeln($result);
    }

    public function getFormat()
    {
        return ConsoleFormat::FORMAT_NAME;
    }

}
