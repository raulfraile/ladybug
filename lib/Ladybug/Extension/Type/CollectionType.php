<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * ExtensionBase class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Type;

class CollectionType extends BaseType
{

    const TYPE_ID = 'collection';

    protected $processedData;

    protected $title;

    public function setProcessedData($processedData)
    {
        $this->processedData = $processedData;
    }

    public function getProcessedData()
    {
        return $this->processedData;
    }

    public function getTemplateName()
    {
        return 'collection';
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function loadFromArray(array $data, $useKeys = true)
    {
        $this->data = array();

        foreach ($data as $key => $item) {
            $this->data[] = $item;

        }
    }

    public function load($var, $key = null)
    {
        $this->data = array();

        foreach ($var as $key => $item) {
            $this->data[] = $item;
        }
    }

    public function add($value)
    {
        $this->data[] = $value;
    }

    public static function create(array $var, $key = null)
    {
        $object = new static();
        $object->load($var, $key);

        return $object;
    }

}
