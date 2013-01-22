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

class StandardObject implements ProcessorInterface
{

    public static $phpprefix = 'http://php.net/manual/en/';

    public static $objects = array(
        // DOM
        'DOMDocument'                       => 'class.domdocument.php',
        'DOMAttr'                           => 'class.domattr.php',
        'DOMCdataSection'                   => 'class.domcdatasection.php',
        'DOMCharacterData'                  => 'class.domcharacterdata.php',
        'DOMComment'                        => 'class.domcomment.php',
        'DOMDocumentFragment'               => 'class.domdocumentfragment.php',
        'DOMDocumentType'                   => 'class.domdocumenttype.php',
        'DOMElement'                        => 'class.domelement.php',
        'DOMEntity'                         => 'class.domentity.php',
        'DOMEntityReference'                => 'class.domentityreference.php',
        'DOMException'                      => 'class.domexception.php',
        'DOMImplementation'                 => 'class.domimplementation.php',
        'DOMNamedNodeMap'                   => 'class.domnamednodemap.php',
        'DOMNode'                           => 'class.domnode.php',
        'DOMNodeList'                       => 'class.domnodelist.php',
        'DOMNotation'                       => 'class.domnotation.php',
        'DOMProcessingInstruction'          => 'class.domprocessinginstruction.php',
        'DOMText'                           => 'class.domtext.php',
        'DOMXPath'                          => 'class.domxpath.php',

        // DateTime
        'DateTime'                          => 'class.datetime.php',

        // Interfaces
        'Serializable'                      => 'class.serializable.php',
        'Traversable'                       => 'class.traversable.php',
        'Iterator'                          => 'class.iterator.php',
        'IteratorAggregate'                 => 'class.iteratoraggregate.php',
        'ArrayAccess'                       => 'class.arrayaccess.php',
        'Closure'                           => 'class.closure.php',
        'Countable'                         => 'class.countable.php',
        'OuterIterator'                     => 'class.outeriterator.php',
        'RecursiveIterator'                 => 'class.recursiveiterator.php',
        'SeekableIterator'                  => 'class.seekableiterator.php',
        'Reflector'                         => 'class.reflector.php',

        // Reflection
        'ReflectionClass'                   => 'class.reflectionclass.php',
        'ReflectionExtension'               => 'class.reflectionextension.php',
        'ReflectionFunction'                => 'class.reflectionfunction.php',
        'ReflectionFunctionAbstract'        => 'class.reflectionfunctionabstract.php',
        'ReflectionMethod'                  => 'class.reflectionmethod.php',
        'ReflectionObject'                  => 'class.reflectionobject.php',
        'ReflectionParameter'               => 'class.reflectionparameter.php',
        'ReflectionProperty'                => 'class.reflectionproperty.php',
        'ReflectionException'               => 'class.reflectionexception.php',

        // QuickHash
        'QuickHashIntSet'                    => 'class.quickhashintset.php',
        'QuickHashIntHash'                   => 'class.quickhashinthash.php',
        'QuickHashStringIntHash'             => 'class.quickhashstringinthash.php',
        'QuickHashIntStringHash'             => 'class.quickhashintstringhash.php',

        // Zip
        'ZipArchive'                         => 'class.ziparchive.php',

        // Varnish
        'VarnishAdmin'                       => 'class.varnishadmin.php',
        'VarnishStat'                        => 'class.varnishstat.php',
        'VarnishLog'                         => 'class.varnishlog.php',

        // Memcache
        'Memcache'                           => 'class.memcache.php',

        // Windows only
        'COM'                                => 'class.com.php',
        'DOTNET'                             => 'class.dotnet.php',
        'VARIANT'                            => 'class.variant.php',

        // KTaglib
        'KTagLib_MPEG_File'                  => 'class.ktaglib-mpeg-file.php',
        'KTaglib_MPEG_AudioProperties'       => 'class.ktaglib-mpeg-audioproperties.php',
        'KTaglib_Tag'                        => 'class.ktaglib-tag.php',
        'KTagLib_ID3v2_Tag'                  => 'class.ktaglib-id3v2-tag.php',
        'KTagLib_ID3v2_Frame'                => 'class.ktaglib-id3v2-frame.php',
        'KTaglib_ID3v2_AttachedPictureFrame' => 'class.ktaglib-id3v2-attachedpictureframe.php',

        // Phar
        'Phar'                               => 'class.Phar.php',
        'PharData'                           => 'class.PharData.php',
        'PharFileInfo'                       => 'class.PharFileInfo.php',
        'PharException'                      => 'class.PharException.php',

        // Rar
        'RarArchive'                         => 'class.rararchive.php',
        'RarEntry'                           => 'class.rarentry.php',
        'RarException'                       => 'class.rarexception.php',

        // Weakref
        'Weakref'                            => 'class.weakref.php',

        // SPL
        'SplDoublyLinkedList'                => 'class.spldoublylinkedlist.php',
        'SplStack'                           => 'class.splstack.php',
        'SplQueue'                           => 'class.splqueue.php',
        'SplHeap'                            => 'class.splheap.php',
        'SplMaxHeap'                         => 'class.splmaxheap.php',
        'SplMinHeap'                         => 'class.splminheap.php',
        'SplPriorityQueue'                   => 'class.splpriorityqueue.php',
        'SplFixedArray'                      => 'class.splfixedarray.php',
        'SplObjectStorage'                   => 'class.splobjectstorage.php'
    );

    public function isProcessable($str)
    {
        return true;
    }

    public function process($str)
    {
        $result = $str;

        foreach (self::$objects as $name => $url) {
            $result = preg_replace_callback('/[\s\W]('.$name.')[\s\W]/', 'Ladybug\\Processor\\StandardObject::linkify', $result);
        }

        return $result;
    }

    public static function linkify($matches)
    {
        return str_replace($matches[1], '<a href="'.self::$phpprefix.self::$objects[$matches[1]].'" class="doc php" target="_blank" title="' . $matches[1] . '"></a>'.$matches[1], $matches[0]);
    }

}
