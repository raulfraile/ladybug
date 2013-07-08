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
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use Ladybug\Format;

class ContainerBak extends Pimple
{

    public function load()
    {
        // set default parameters
        $this->setDefaultParameters();

        // load classes
        $this->loadTypes();
        $this->loadEnvironments();
        $this->loadFormats();
        $this->loadInspectors();
        $this->loadThemes();
        $this->loadMetadata();
        $this->loadRenders();
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

    public function getAttribute($key, $default = null)
    {
        $attr = sprintf('attribute.%s', $key);

        return $this->offsetExists($attr) ? $this->offsetGet($attr) : $default;
    }

    public function get($key)
    {
        return $this->offsetGet($key);
    }

    public function has($key)
    {
        return $this->offsetExists($key);
    }


    /**
     * Load types
     */
    protected function loadTypes()
    {
        // types
        $this->values['ladybug.type.int'] = function ($c) {
            return new \Ladybug\Type\IntType();
        };
        $this->values['ladybug.type.float'] = function ($c) {
            return new \Ladybug\Type\FloatType();
        };
        $this->values['ladybug.type.bool'] = function ($c) {
            return new \Ladybug\Type\BoolType();
        };
        $this->values['ladybug.type.null'] = function ($c) {
            return new \Ladybug\Type\NullType();
        };
        $this->values['ladybug.type.string'] = function ($c) {
            return new \Ladybug\Type\StringType();
        };
        $this->values['ladybug.type.array'] = function (Container $c) {
            return new \Ladybug\Type\ArrayType($c->getParameter('array.max_nesting_level'), $c->get('ladybug.type.__factory'));
        };
        $this->values['ladybug.type.object'] = function (Container $c) {
            return new \Ladybug\Type\ObjectType($c['ladybug.level'], $c->getParameter('object.max_nesting_level'), $c->get('ladybug.type.__factory'), $c->get('metadata.resolver'));
        };
        $this->values['ladybug.type.resource'] = function (Container $c) {
            return new \Ladybug\Type\ResourceType($c->get('ladybug.type.__factory'));
        };

        $this->setShared('ladybug.type.__factory', function ($c) {
            return new \Ladybug\Type\FactoryType($c);
        });

        // extended
        $this->values['ladybug.extension.type.collection'] = function (Container $c) {
            return new \Ladybug\Type\Extended\CollectionType($c->get('ladybug.type.__factory'));
        };
        $this->values['ladybug.extension.type.code'] = function (Container $c) {
            return new \Ladybug\Type\Extended\CodeType($c->get('ladybug.type.__factory'));
        };

    }

    protected function loadEnvironments()
    {
        // environments
        $this->setShared('environment.ajax', function ($c) {
            return new \Ladybug\Environment\AjaxEnvironment();
        });
        $this->setShared('environment.cli', function ($c) {
            return new \Ladybug\Environment\CliEnvironment();
        });
        $this->setShared('environment.browser', function ($c) {
            return new \Ladybug\Environment\BrowserEnvironment();
        });
        $this->setShared('environment.resolver', function ($c) {
            return new \Ladybug\Environment\EnvironmentResolver(array(
                $c->get('environment.browser'),
                $c->get('environment.ajax'),
                $c->get('environment.cli')
            ));
        });
    }

    protected function loadFormats()
    {
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
    }


    /**
     * Check themes directories and load found themes
     */
    protected function loadThemes()
    {
        $themesFinder = new Finder();
        $themesFinder->directories();

        foreach ($this->getParameter('theme.directories') as $item) {
            $themesFinder->in($item);
        }

        foreach ($themesFinder as $directory) {
            /** @var $directory SplFileInfo */

            $themeFile = $directory->getRealPath() . '/' . $directory->getFilename() . 'Theme.php';
            $themeName = strtolower($directory->getFilename());
            $themeClass = sprintf('\Ladybug\Theme\%s\%sTheme', $directory->getFilename(), $directory->getFilename());

            if (!file_exists($themeFile)) {
                continue;
            }

            $this->setShared(sprintf('theme.%s', $themeName), function ($c) use ($themeClass) {
                return new $themeClass($c);
            });
        }

    }

    /**
     * Check extensions directories and load found extensions
     */
    protected function loadInspectors()
    {
        $inspectorsFinder = new Finder();
        $inspectorsFinder->files();

        foreach ($this->getParameter('inspector.directories') as $item) {
            $inspectorsFinder->in($item);
        }

        $inspectorsFinder->name('*.php')->depth('<10')->depth('>0');


        foreach ($inspectorsFinder as $inspectorFile) {
            /** @var $inspectorFile SplFileInfo */

            $inspectorParts = explode('/', $inspectorFile->getRelativePath() . '/' . str_replace('.php', '', $inspectorFile->getFilename()));

            $inspectorName = strtolower(implode('.', $inspectorParts));
            $inspectorClass = sprintf('\Ladybug\Inspector\%s', implode('\\', $inspectorParts));

            if (!file_exists($inspectorFile)) {
                continue;
            }

            $this->setShared(sprintf('inspector.%s', $inspectorName), function ($c) use ($inspectorClass) {
                return new $inspectorClass($c);
            });
        }

    }

    protected function loadMetadata()
    {
        $metadataFinder = new Finder();
        $metadataFinder->files();

        foreach ($this->getParameter('metadata.directories') as $item) {
            $metadataFinder->in($item);
        }

        $metadataFinder->name('*Metadata.php');

        foreach ($metadataFinder as $metadataFile) {
            /** @var $metadataFile SplFileInfo */

            $metadataParts = explode('/', $metadataFile->getRelativePath() . '/' . str_replace('.php', '', $metadataFile->getFilename()));

            $metadataName = strtolower(implode('.', $metadataParts));
            $metadataClass = sprintf('\Ladybug\Metadata\%s', implode('\\', $metadataParts));

            if (!file_exists($metadataFile)) {
                continue;
            }

            $this->setShared(sprintf('metadata.%s', $metadataName), function ($c) use ($metadataClass) {
                return new $metadataClass($c);
            });
        }

    }

    protected function loadRenders()
    {
        $this->set('render.html', $this->share(function (Container $c) {
            return new \Ladybug\Render\HtmlRender($c->get(sprintf('theme.%s', $c->getParameter('theme'))), $c->get(sprintf('format.%s', $c->getParameter('format'))));
        }));

        $this->set('render.console', $this->share(function (Container $c) {
            return new \Ladybug\Render\ConsoleRender($c->get(sprintf('theme.%s', $c->getParameter('theme'))), $c->get(sprintf('format.%s', $c->getParameter('format'))));
        }));

        $this->set('render.text', $this->share(function (Container $c) {
            return new \Ladybug\Render\TextRender($c->get(sprintf('theme.%s', $c->getParameter('theme'))), $c->get(sprintf('format.%s', $c->getParameter('format'))));
        }));
    }

    protected function setDefaultParameters()
    {
        $this->setParameter('theme', 'base');
        $this->setParameter('format', Format\HtmlFormat::FORMAT_NAME);

        $this->setParameter('array.max_nesting_level', 8);
        $this->setParameter('object.max_nesting_level', 3);

        $this->setParameter('environment.directories', array(__DIR__ . '/Environment'));
        $this->setParameter('theme.directories', array(__DIR__ . '/Theme'));
        $this->setParameter('format.directories', array(__DIR__ . '/Format'));
        $this->setParameter('metadata.directories', array(__DIR__ . '/Metadata'));
        $this->setParameter('inspector.directories', array(__DIR__ . '/Inspector'));
        $this->setParameter('render.services', array(
            'render.html' =>
        ));

        $this->setParameter('_ladybug.assets.loaded', false);
        $this->setParameter('_ladybug.level', 0);
    }



    public function restoreDefaults()
    {
        $this->setDefaultParameters();
    }
}
