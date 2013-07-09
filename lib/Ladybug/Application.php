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
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use Ladybug\Format;
use Ladybug\DependencyInjection;

class Application
{

    /** @var ContainerBuilder $container */
    public $container;

    public function build()
    {
        $this->container = new ContainerBuilder();

        $this->container->addCompilerPass(new DependencyInjection\EnvironmentCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\TypeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\ThemeCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\FormatCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\RenderCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\InspectorCompilerPass());
        $this->container->addCompilerPass(new DependencyInjection\MetadataCompilerPass());

        $loader = new XmlFileLoader($this->container, new FileLocator(__DIR__.'/Config'));
        $loader->load('container.xml');

        $this->container->compile();




        //var_dump($this->container->getParameter('format'));
        //var_dump($this->container->get('render_html'));

    }

}