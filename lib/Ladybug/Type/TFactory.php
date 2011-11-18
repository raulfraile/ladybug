<?php

namespace Ladybug\Type;

use Ladybug\Type;
use Ladybug\Options;

class TFactory {
    
    public static function factory($var, $level, Options $options) {
        
        if($var === null) $result = new TNull($level, $options);
        elseif(is_bool($var)) $result = new TBool($var, $level, $options);
        elseif(is_string($var)) $result = new TString($var, $level, $options);
        elseif(is_int($var)) $result = new TInt($var, $level, $options);
        elseif(is_float($var)) $result = new TFloat($var, $level, $options);
        elseif(is_array($var)) $result = new TArray($var, $level, $options);
        elseif (is_object($var)) $result = new TObject($var, $level, $options);
        else if(is_resource($var)) $result = new TResource($var, $level, $options);
        else $result = NULL;
        
        return $result;
    }
}