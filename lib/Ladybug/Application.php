<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Ladybug\DependencyInjection;
use Ladybug\Plugin\PluginInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Application container
 *
 * @author Raul Fraile <raulfraile@gmail.com>
 */
class Application
{

    /** @var ContainerBuilder $container */
    public $container;

    /**
     * Build container
     * @param array $parameters
     * @param array $plugins
     */
    public function build($parameters = array(), $plugins = array())
    {
        $this->initializeContainer();
        $this->loadServices();
        $this->loadPlugins($plugins);
        $this->setParameters($parameters);
        $this->container->compile();
    }

    /**
     * Initialize container
     */
    protected function initializeContainer()
    {
        $this->container = new ContainerBuilder();

        $this->container->addCompilerPass(new DependencyInjection\EnvironmentCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\TypeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\ThemeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\FormatCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\RenderCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\InspectorCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\MetadataCompilerPass());

        $finder = new Finder();
        $finder->in(__DIR__.'/../../data/themes/Ladybug/Theme')->files()->depth(1)->name('*Theme.php');

        foreach ($finder as $file) {
            /** @var SplFileInfo $file */
            $themeName = preg_replace('/Theme\.php$/', '', $file->getFilename());
            $themeClass = sprintf('Ladybug\\Theme\\%s\\%sTheme', $themeName, $themeName);
            $themePath = dirname($file->getRealPath());

            $this->container->register('theme_'.$themeName, $themeClass)
                ->addArgument($themePath)
                ->addTag('ladybug.theme');
        }

    }

    /**
     * Load services
     */
    protected function loadServices()
    {
        $loader = new Loader\XmlFileLoader($this->container, new FileLocator(__DIR__.'/Config'));
        $loader->load('container.xml');

    }

    /**
     * Load plugins
     * @param array $plugins
     * @throws \Exception
     */
    protected function loadPlugins(array $plugins = array())
    {
        foreach ($plugins as $plugin) {
            /** @var PluginInterface $plugin */
            $file = $plugin->getConfigFile();
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $dir = pathinfo($file, PATHINFO_DIRNAME);
            $filename = pathinfo($file, PATHINFO_FILENAME);

            switch ($extension) {
                case 'xml':
                    $loader = new Loader\XmlFileLoader($this->container, new FileLocator($dir));
                    break;
                case 'yml':
                    $loader = new Loader\YamlFileLoader($this->container, new FileLocator($dir));
                    break;
                case 'php':
                    $loader = new Loader\PhpFileLoader($this->container, new FileLocator($dir));
                    break;
                case 'ini':
                    $loader = new Loader\IniFileLoader($this->container, new FileLocator($dir));
                    break;
                default:
                    throw new \Exception('Invalid config file');
            }

            $loader->load($filename . '.' . $extension);
        }
    }

    /**
     * Set parameters
     * @param array $parameters
     */
    protected function setParameters(array $parameters = array())
    {
        foreach ($parameters as $parameterKey => $parameterValue) {
            $this->container->setParameter($parameterKey, $parameterValue);
        }
    }

}
