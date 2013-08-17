<?php

namespace Ladybug\Render\Twig\Extension;

use Twig_Extension;
use Twig_Environment;
use Ladybug\Type\RenderizableTypeInterface;

class LadybugExtension extends Twig_Extension
{

    protected $format;

    public function getName()
    {
        return 'ladybug';
    }

    public function getFunctions()
    {
        return array(
            'include_file' => new \Twig_Function_Method(
                $this,
                'includeFileFunction',
                array('is_safe' => array('html'))
            ),
            'render_type' => new \Twig_Function_Method(
                $this,
                'renderTypeFunction',
                array('needs_environment' => true, 'is_safe' => array('html'))
            ),
            'minify_css' => new \Twig_Function_Method(
                $this,
                'minifyCssFunction',
                array('is_safe' => array('html'))
            ),
            'spaces_level' => new \Twig_Function_Method(
                $this,
                'getSpacesByLevel',
                array()
            ),

        );
    }

    public function getFilters()
    {
        return array(
            'tags' => new \Twig_Filter_Method(
                $this,
                'getTags',
                array()
            ),
            'repeat' => new \Twig_Filter_Method(
                $this,
                'getRepeat',
                array()
            ),
            'pad' => new \Twig_Filter_Method(
                $this,
                'getPad',
                array()
            ),
        );
    }

    public function includeFileFunction($filename)
    {
        $filename = preg_replace('/^@([A-Za-z]+)Theme\//', __DIR__ . '/../../../Theme/\\1/Resources/', $filename);

        return file_get_contents($filename);
    }

    public function renderTypeFunction(Twig_Environment $environment, RenderizableTypeInterface $var, $key = null, $visibility = null)
    {
        $parameters = array(
            'var' => $var,
            'level' => $var->getLevel(),
            'key' => $key,
            'visibility' => $visibility
        );

        $code = $environment->render($var->getTemplateName().'.'.$this->format.'.twig', $parameters);

        $code = str_replace(array('<script>', '</script>'), array('<ladybug_script>', '</ladybug_script>'), $code);

        return $code;
    }

    public function getSpacesByLevel($level)
    {
        return str_repeat('<space><space><space><space>', $level);
    }

    public function getTags($text)
    {
        $textTags = str_replace(' ', '<space>', $text);

        return $textTags;
    }

    public function getRepeat($text, $times)
    {
        return str_repeat($text, $times);
    }

    public function getPad($text, $length)
    {
        return str_pad($text, $length);
    }

    public function minifyCssFunction($filename)
    {
        $filename = preg_replace('/^@([A-Za-z]+)Theme\//', __DIR__ . '/../../../Theme/\\1/Resources/', $filename);

        $folder = pathinfo($filename, \PATHINFO_DIRNAME);

        $content = file_get_contents($filename);

        //$content = $oCss->__toString();

        // comments
        $content = preg_replace('!/\*.*?\*/!s','', $content);
        $content = preg_replace('/\n\s*\n/',"\n", $content);

// minify
        $content = preg_replace('/[\n\r \t]/',' ', $content);
        $content = preg_replace('/ +/',' ', $content);
        $content = preg_replace('/ ?([,:;{}]) ?/','$1',$content);

// trailing semicolon
        $content = preg_replace('/;}/','}',$content);

// replace images with data:uri
        $urls = array();
        preg_match_all('/url\(([^\)]+)\)/', $content, $urls);

        foreach ($urls[1] as $url) {

            // clean quotes
            $url = preg_replace('/^\"|\'/', '', $url);
            $url = preg_replace('/\"|\'$/', '', $url);

            $data_uri = 'data:image/png;base64,' . base64_encode(file_get_contents($folder.'/'.$url));
            $content = str_replace($url, $data_uri, $content);
        }

        $content = trim($content);

        return $content;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }
}
