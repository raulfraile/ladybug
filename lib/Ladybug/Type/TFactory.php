<?php

namespace Ladybug\Type;

use Ladybug\Type;

class TFactory {
    
    public static function factory($var, $level = 0) {
        
        if($var === null) $result = new TNull($level);
        elseif(is_bool($var)) $result = new TBool($var, $level);
        elseif(is_string($var)) $result = new TString($var, $level);
        elseif(is_int($var)) $result = new TInt($var, $level);
        elseif(is_float($var)) $result = new TFloat($var, $level);
        elseif(is_array($var)) $result = new TArray($var, $level);
        elseif (is_object($var)) $result = new TObject($var, $level);
        else if(is_resource($var)) $result = new TResource($var, $level);
        else $result = NULL;
        
        return $result;
    }
}