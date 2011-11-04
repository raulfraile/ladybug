<?php
require_once __DIR__.'/Ladybug.php';

class LadybugExtension {
    
    protected $ladybug;
    
    public function __construct(Ladybug $l) {
        $this->ladybug = $l;
    }
}