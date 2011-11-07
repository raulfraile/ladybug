<?php

//namespace Ladybug\Extension;

//require_once __DIR__.'/Ladybug.php';

class Ladybug_Extension {
    
    protected $ladybug;
    
    public function __construct(Ladybug_Dumper $l) {
        $this->ladybug = $l;
    }
}