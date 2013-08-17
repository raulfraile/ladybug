<?php
    /*
    * Ladybug: Simple and Extensible PHP Dumper
    *
    * Application container
    *
    * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
    *
    * For the full copyright and license information, please view the LICENSE
    * file that was distributed with this source code.
    */

namespace Ladybug;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

use Ladybug\DependencyInjection;
use Ladybug\Extension\PluginInterface;

class Application
{

    /** @var ContainerBuilder $container */
    public $container;

    public function build($parameters = array(), $plugins = array())
    {
        $this->container = new ContainerBuilder();

        $this->container->addCompilerPass(new DependencyInjection\EnvironmentCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\TypeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\ThemeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\FormatCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\RenderCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\InspectorCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\MetadataCompilerPass());

        $loader = new Loader\XmlFileLoader($this->container, new FileLocator(__DIR__.'/Config'));
        $loader->load('container.xml');

        // load plugins
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

        // override parameters
        foreach ($parameters as $parameterKey => $parameterValue) {
            $this->container->setParameter($parameterKey, $parameterValue);
        }

        $this->container->compile();
    }

}
