<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Processor / Standard Object
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Processor;

class StandardObject {
    
    public static $phpprefix = 'http://php.net/manual/en/';
    public static $objects = array(
        // DOM
        'DOMDocument' => 'class.domdocument.php',
        'DOMAttr' => 'class.domattr.php',
        'DOMCdataSection' => 'class.domcdatasection.php',
        'DOMCharacterData' => 'class.domcharacterdata.php',
        'DOMComment' => 'class.domcomment.php',
        'DOMDocumentFragment' => 'class.domdocumentfragment.php',
        'DOMDocumentType' => 'class.domdocumenttype.php',
        'DOMElement' => 'class.domelement.php',
        'DOMEntity' => 'class.domentity.php',
        'DOMEntityReference' => 'class.domentityreference.php',
        'DOMException' => 'class.domexception.php',
        'DOMImplementation' => 'class.domimplementation.php',
        'DOMNamedNodeMap' => 'class.domnamednodemap.php',
        'DOMNode' => 'class.domnode.php',
        'DOMNodeList' => 'class.domnodelist.php',
        'DOMNotation' => 'class.domnotation.php',
        'DOMProcessingInstruction' => 'class.domprocessinginstruction.php',
        'DOMText' => 'class.domtext.php',
        'DOMXPath' => 'class.domxpath.php',
        
        // DateTime
        'DateTime' => 'class.datetime.php',
        
        // Interfaces
        'Serializable' => 'class.serializable.php',
        'Traversable' => 'class.traversable.php',
        'Iterator' => 'class.iterator.php',
        'IteratorAggregate' => 'class.iteratoraggregate.php',
        'ArrayAccess' => 'class.arrayaccess.php',
        'Closure' => 'class.closure.php',
        'Countable' => 'class.countable.php',
        'OuterIterator' => 'class.outeriterator.php',
        'RecursiveIterator' => 'class.recursiveiterator.php',
        'SeekableIterator' => 'class.seekableiterator.php'
    );
    
    public function process($str) {
        
    
        $result = $str;
        
        foreach (self::$objects as $name => $url) {
            $result = preg_replace_callback('/[\s\W]('.$name.')[\s\W]/', 'Ladybug\\Processor\\StandardObject::linkify', $result);
        }
        
        return $result;
    }
    
    public static function linkify($matches) {
        return str_replace($matches[1], '<a href="'.self::$phpprefix.self::$objects[$matches[1]].'" class="external php" target="_blank" title="' . $matches[1] . '"></a>'.$matches[1], $matches[0]);
    }
    
}