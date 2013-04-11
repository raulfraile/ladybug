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

use Pimple;

class Container extends Pimple
{

    public function load()
    {

        // parameters
        $this->setParameter('theme', 'modern');
        $this->setParameter('array.max_nesting_level', 8);
        $this->setParameter('object.max_nesting_level', 3);

        $this->values['ladybug.level'] = 1;

        // types

        $this->setShared('ladybug.type.__factory', function ($c) {
            return new \Ladybug\Type\FactoryType();
        });



        // environments
        $this->setShared('environment.ajax', function ($c) {
            return new \Ladybug\Environment\AjaxEnvironment($c);
        });
        $this->setShared('environment.cli', function ($c) {
            return new \Ladybug\Environment\CliEnvironment($c);
        });
        $this->setShared('environment.browser', function ($c) {
            return new \Ladybug\Environment\BrowserEnvironment($c);
        });
        $this->setShared('environment.resolver', function ($c) {
            return new \Ladybug\Environment\EnvironmentResolver($c);
        });


        // format
        $this->setShared('format.console', function ($c) {
            return new \Ladybug\Format\ConsoleFormat();
        });
        $this->setShared('format.html', function ($c) {
            return new \Ladybug\Format\HtmlFormat();
        });
        $this->setShared('format.text', function ($c) {
            return new \Ladybug\Format\TextFormat();
        });
        $this->setShared('format.xml', function ($c) {
            return new \Ladybug\Format\XmlFormat();
        });

        // themes
        $this->setShared('theme.simple', function ($c) {
            return new \Ladybug\Theme\Simple\SimpleTheme($c);
        });
        $this->setShared('theme.classic', function ($c) {
            return new \Ladybug\Theme\Classic\ClassicTheme($c);
        });
        $this->setShared('theme.modern', function ($c) {
            return new \Ladybug\Theme\Modern\ModernTheme($c);
        });

        $environmentResolver = $this->get('environment.resolver');

        $environment = $environmentResolver->resolve();

        
        $this->setAttribute('format', $environment->getDefaultFormat());



        $this->setShared('theme.resolver', function (Container $c) {
            $formatAttribute = $c->getAttribute('format');

            return new \Ladybug\Theme\ThemeResolver($c, $c->get('format.' . $formatAttribute));
        });


        $this->values['__theme'] = $this->get('theme.resolver')->resolve();







        // render
        $this->values['render.html'] = $this->share(function (Container $c) {
            return new \Ladybug\Render\HtmlRender($c->get(sprintf('theme.%s', $c->getAttribute('theme'))), $c->get(sprintf('format.%s', $c->getAttribute('format'))));
        });
        $this->values['render.console'] = $this->share(function (Container $c) {
            return new \Ladybug\Render\ConsoleRender($c->get(sprintf('theme.%s', $c->getAttribute('theme'))), $c->get(sprintf('format.%s', $c->getAttribute('format'))));
        });
        $this->values['render.text'] = $this->share(function (Container $c) {
            return new \Ladybug\Render\TextRender($c->get(sprintf('theme.%s', $c->getAttribute('theme'))), $c->get(sprintf('format.%s', $c->getAttribute('format'))));
        });






        //$this->setAttribute('render', $this->values['render.' . $this->values['__format']->getName()];
    }


    public function set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    public function setShared($key, $value)
    {
        $this->offsetSet($key, $this->share($value));
    }

    public function setParameter($key, $value)
    {
        $this->offsetSet(sprintf('parameter.%s', $key), $value);
    }

    public function getParameter($key)
    {
        return $this->offsetGet(sprintf('parameter.%s', $key));
    }

    public function setAttribute($key, $value)
    {
        $this->offsetSet(sprintf('attribute.%s', $key), $value);
    }

    public function getAttribute($key)
    {
        return $this->offsetGet(sprintf('attribute.%s', $key));
    }

    public function get($key)
    {
        return $this->offsetGet($key);
    }
}
