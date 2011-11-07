<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 * 
 * Oject/DomDocument dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Ladybug_Extension_Object_Domdocument extends Ladybug_Extension {
    
    public function dump($var) {
        $var->formatOutput = true;
        $xml = htmlentities($var->saveXML());
        
        // indentation
        $lines = explode(Ladybug_Dumper::CHAR_NEWLINE, $xml);
        $result = '';
        foreach ($lines as $line) {
            
            if (strlen(trim($line)) > 0) {
                $result .= $this->ladybug->writeDepth() . $line . Ladybug_Dumper::CHAR_NEWLINE;
            }
        }
        
        return $result;
    }
    
}

// in progress
class MyDOMDocument extends DOMDocument
{
    private function isEmptyTextNode(DOMNode $oDomNode) {
        $value = trim($oDomNode->nodeValue);
        if (empty($value)) return true;
        else return false;
    }
    
    public function toArray(DOMNode $oDomNode = null)
    {
        // return empty array if dom is blank
        if (is_null($oDomNode) && !$this->hasChildNodes()) {
            return array();
        }
        $oDomNode = (is_null($oDomNode)) ? $this->documentElement : $oDomNode;
        if (!$oDomNode->hasChildNodes()) {
            if ($this->isEmptyTextNode($oDomNode)) $mResult = NULL;
            else $mResult = '_'.$oDomNode->nodeValue.'_';
        } else {
            $mResult = array();
            foreach ($oDomNode->childNodes as $oChildNode) {
                // how many of these child nodes do we have?
                // this will give us a clue as to what the result structure should be
                $oChildNodeList = $oDomNode->getElementsByTagName($oChildNode->nodeName);  
                $iChildCount = 0;
                // there are x number of childs in this node that have the same tag name
                // however, we are only interested in the # of siblings with the same tag name
                foreach ($oChildNodeList as $oNode) {
                    if ($oNode->parentNode->isSameNode($oChildNode->parentNode)) {
                        $iChildCount++;
                    }
                }
                $mValue = $this->toArray($oChildNode);
                $sKey   = ($oChildNode->nodeName{0} == '#') ? '0' : $oChildNode->nodeName;
                $mValue = is_array($mValue) ? $mValue[$oChildNode->nodeName] : $mValue;
                
                // how many of thse child nodes do we have?
                if ($iChildCount > 1) {  // more than 1 child - make numeric array
                    $mResult[$sKey][] = $mValue;
                } else {
                    if (!is_null($mValue)) $mResult[$sKey] = $mValue;
                }
                
            }
            // if the child is <foo>bar</foo>, the result will be array(bar)
            // make the result just 'bar'
            if (count($mResult) == 1 && isset($mResult[0]) && !is_array($mResult[0])) {
                $mResult = $mResult[0];
            }
        }
        
        // get our attributes if we have any
        $arAttributes = array();
        if ($oDomNode->hasAttributes()) {
            foreach ($oDomNode->attributes as $sAttrName=>$oAttrNode) {
                // retain namespace prefixes
                $arAttributes["@{$oAttrNode->nodeName}"] = $oAttrNode->nodeValue;
            }
        }
        // check for namespace attribute - Namespaces will not show up in the attributes list
        if ($oDomNode instanceof DOMElement && $oDomNode->getAttribute('xmlns')) {
            $arAttributes["@xmlns"] = $oDomNode->getAttribute('xmlns');
        }
        if (count($arAttributes)) {
            if (!is_array($mResult)) {
                $mResult = (trim($mResult)) ? array($mResult) : array();
            }
            $mResult = array_merge($mResult, $arAttributes);
        }
        
        $arResult = array($oDomNode->nodeName => $mResult);
        
        return $arResult;
    }
    
    public function cleanArray() {
        
    }
}