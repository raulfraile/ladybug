<?php

namespace Ladybug\Type;

use Ladybug\Type;

class TFactory {
    
    public static function factory($var, $level = 0) {
        
        if($var === null) $result = new TNull($var);
        elseif(is_bool($var)) $result = new TBool($var);
        elseif(is_string($var)) $result = new TString($var);
        elseif(is_int($var)) $result = new TInt($var);
        elseif(is_float($var)) $result = new TFloat($var);
        elseif(is_array($var)) $result = new TArray($var, $level);
        elseif (is_object($var)) $result = new TObject($var, $level);
        else if(is_resource($var)) $result = new TResource($var);
        else $result = NULL;
        
        return $result;
    }
}