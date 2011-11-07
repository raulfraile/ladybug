<?php

namespace Ladybug;

class Extension {
    
    protected $ladybug;
    
    public function __construct(Dumper $l) {
        $this->ladybug = $l;
    }
}