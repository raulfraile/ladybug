<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Type/TResource variable type
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Options;
use Ladybug\CLIColors;

class TResource extends TBase
{

    const TYPE_ID = 'resource';

    protected $resource_type;
    protected $resource_custom_data;

    public function __construct($var, $level, Options $options)
    {
        parent::__construct(self::TYPE_ID, $var, $level, $options);

        $this->resource_type = get_resource_type($var);

        if ($this->resource_type == 'stream') {
            $stream_vars = stream_get_meta_data($var);

            // prevent unix sistems getting stream in files
            if (isset($stream_vars['stream_type']) && $stream_vars['stream_type'] == 'STDIO') $this->resource_type = 'file';

        }

        // is there a class to show the resource info?
        $include_class = $this->getIncludeClass($this->resource_type, 'resource');
        if (class_exists($include_class)) {
            $custom_dumper = new $include_class($var);
            $this->resource_custom_data = $custom_dumper->dump($var);
            unset($custom_dumper); $custom_dumper = NULL;
        }
    }

    public function _renderHTML($array_key = NULL, $escape = false)
    {
        $label = $this->type . '('.$this->resource_type . ')';
        $result = $this->renderTreeSwitcher($label, $array_key) . '<ol>';

        if (!empty($this->resource_custom_data)) {

            if (is_array($this->resource_custom_data)) {
                foreach ($this->resource_custom_data as $k=>$v) {
                    if (is_array($v)) {

                        $result .= '<li>' . $this->renderTreeSwitcher($k) . '<ol>';

                        foreach ($v as $sub_k=>$sub_v) {
                            if ($this->isEmbeddedImage($sub_v))
                                $sub_v = '<br/><img style="border:1px solid #ccc; padding:1px" src="' . $sub_v . '" />';

                            $result .= '<li>'.$sub_k.': '.$sub_v.'</li>';
                        }
                        $result .= '</ol></li>';
                    } else $result .= '<li>'.$k.': '.$v.'</li>';
                }
            } else $result .= '<li>'.$this->resource_custom_data.'</li>';

        }

        $result .= '</ol>';

        return $result;
    }

    public function _renderCLI($array_key = NULL)
    {
        $label = $this->type . '('.$this->resource_type . ')';
        $result = $this->renderArrayKey($array_key) . CLIColors::getColoredString($label, 'yellow') . "\n";

        if (!empty($this->resource_custom_data)) {

            if (is_array($this->resource_custom_data)) {
                foreach ($this->resource_custom_data as $k=>$v) {
                    if (is_array($v)) {
                        $result .= $this->indentCLI() . $k . "\n";
                        foreach ($v as $sub_k=>$sub_v) {
                            $stripped = strip_tags($sub_v);
                            if (strlen($stripped) > 0) $result .= $this->indentCLI(1) . $sub_k . ': ' . $stripped . "\n";
                        }

                    } else $result .= $this->indentCLI() . $k . ': ' . strip_tags($v) . "\n";
                }
            } else $result .= $this->indentCLI() . $this->resource_custom_data . "\n";
        }

        return $result;
    }

    public function _renderTXT($array_key = NULL)
    {
        $label = $this->type . '('.$this->resource_type . ')';
        $result = $this->renderArrayKey($array_key) . $label . "\n";

        if (!empty($this->resource_custom_data)) {

            if (is_array($this->resource_custom_data)) {
                foreach ($this->resource_custom_data as $k=>$v) {
                    if (is_array($v)) {
                        $result .= $this->indentTXT() . $k . "\n";
                        foreach ($v as $sub_k=>$sub_v) {
                            $stripped = strip_tags($sub_v);
                            if (strlen($stripped) > 0) $result .= $this->indentTXT(1) . $sub_k . ': ' . $stripped . "\n";
                        }

                    } else $result .= $this->indentTXT() . $k . ': ' . strip_tags($v) . "\n";
                }
            } else $result .= $this->indentTXT() . $this->resource_custom_data . "\n";
        }

        return $result;
    }

    public function export()
    {
        $value = array();

        if (!empty($this->resource_custom_data)) {

            if (is_array($this->resource_custom_data)) {
                foreach ($this->resource_custom_data as $k=>$v) {
                    if (is_array($v)) {
                        $value[$k] = array();
                        foreach ($v as $sub_k=>$sub_v) {
                            $stripped = strip_tags($sub_v);
                            if (strlen($stripped) > 0) $value[$k][$sub_k] = $stripped;
                        }

                    } else $value[$k] = strip_tags($v);
                }
            } else $value[$k] = $this->resource_custom_data;
        }

        return array(
            'type' => $this->type . '(' . $this->resource_type . ')',
            'value' => $value
        );
    }

    private function isEmbeddedImage($value)
    {
        return (substr($value, 0, 11) == 'data:image/');
    }
}
