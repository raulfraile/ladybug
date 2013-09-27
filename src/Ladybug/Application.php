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
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Ladybug\DependencyInjection;

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
     * Builds the container.
     * @param array $parameters
     */
    public function build($parameters = array())
    {
        // sort array by key to generate the container name
        ksort($parameters);

        // needed for new packages installed
        $composerClass = array_filter(get_declared_classes(), function ($item) {
            if (0 === strpos($item, 'ComposerAutoloaderInit')) return true;
        });
        $composerClass = array_pop($composerClass);

        // generate hash
        $parametersHash = md5(serialize($parameters) . $composerClass);

        $containerClass = 'Container' . $parametersHash;

        $isDebug = true;

        $file = sprintf('%s/ladybug_cache/%s.php', sys_get_temp_dir(), $parametersHash);
        $containerConfigCache = new ConfigCache($file, $isDebug);

        if (!$containerConfigCache->isFresh()) {
            $this->initializeContainer();
            $this->loadServices();
            $this->loadThemes();
            $this->loadPlugins();
            $this->setParameters($parameters);

            $this->container->compile();

            $dumper = new PhpDumper($this->container);
            $containerConfigCache->write(
                $dumper->dump(array('class' => $containerClass)),
                $this->container->getResources()
            );
        } else {
            require_once $file;

            $this->container = new $containerClass();
        }

    }

    /**
     * Initializes the container.
     */
    protected function initializeContainer()
    {
        $this->container = new ContainerBuilder();

        $this->container->addCompilerPass(new DependencyInjection\EnvironmentCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\TypeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\ThemeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\FormatCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\RendererCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\InspectorCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\MetadataCompilerPass());

        $this->container->setParameter('root_dir', __DIR__);
        $this->container->setParameter('helpers', array(
            'Ladybug\Dumper:dump'
        ));
    }

    /**
     * Loads services from the config file.
     */
    protected function loadServices()
    {
        $loader = new Loader\XmlFileLoader($this->container, new FileLocator(__DIR__.'/Config'));
        $loader->load(__DIR__ . '/Resources/container/container.xml');
    }

    /**
     * Loads third-party themes.
     */
    protected function loadThemes()
    {
        $themesDirs = array(
            __DIR__.'/../../data/themes/Ladybug/Theme',
            __DIR__.'/../../../ladybug-themes/Ladybug/Theme'
        );

        foreach ($themesDirs as $dir) {
            if (is_dir($dir)) {
                $finder = new Finder();
                $finder->in($dir)->files()->depth(1)->name('*Theme.php');

                foreach ($finder as $file) {
                    /** @var SplFileInfo $file */
                    $this->registerTheme($file);
                }
            }
        }
    }

    /**
     * Registers a new theme from a directory.
     * @param \Symfony\Component\Finder\SplFileInfo $themeClassPath
     */
    protected function registerTheme(SplFileInfo $themeClassPath)
    {
        $themeName = preg_replace('/Theme\.php$/', '', $themeClassPath->getFilename());
        $themeClass = sprintf('Ladybug\\Theme\\%s\\%sTheme', $themeName, $themeName);
        $themePath = dirname($themeClassPath->getRealPath());

        $this->container->register('theme_'.$themeName, $themeClass)
            ->addArgument($themePath)
            ->addTag('ladybug.theme');
    }

    /**
     * Registers a new plugin from a directory.
     * @param  \Symfony\Component\Finder\SplFileInfo $pluginClassPath
     * @throws \Exception
     */
    protected function registerPlugin(SplFileInfo $pluginClassPath)
    {
        $pluginName = preg_replace('/Plugin\.php$/', '', $pluginClassPath->getFilename());
        $pluginClass = sprintf('Ladybug\\Plugin\\%s\\%sPlugin', $pluginName, $pluginName);

        $file = $pluginClass::getConfigFile();
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

        // helpers
        $this->container->setParameter('helpers', array_merge(
            $this->container->getParameter('helpers'),
            $pluginClass::registerHelpers()
        ));
    }

    /**
     * Loads third-party plugins.
     * @throws \Exception
     */
    protected function loadPlugins()
    {
        $pluginsDirs = array(
            __DIR__.'/../../data/plugins/Ladybug/Plugin',
            __DIR__.'/../../../ladybug-plugins/Ladybug/Plugin',
            __DIR__.'/../../../ladybug-themes/Ladybug/Plugin'
        );

        foreach ($pluginsDirs as $dir) {
            if (is_dir($dir)) {
                $finder = new Finder();
                $finder->in($dir)->files()->depth(1)->name('*Plugin.php');

                foreach ($finder as $file) {
                    /** @var SplFileInfo $file */
                    $this->registerPlugin($file);
                }
            }
        }
    }

    /**
     * Sets parameters.
     * @param array $parameters
     */
    protected function setParameters(array $parameters = array())
    {
        foreach ($parameters as $parameterKey => $parameterValue) {
            $this->container->setParameter($parameterKey, $parameterValue);
        }
    }

}
