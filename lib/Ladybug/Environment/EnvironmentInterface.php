<?php

namespace Ladybug\Environment;

interface EnvironmentInterface
{
    public function getName();

    public function isActive();

    public function getDefaultFormat();
}
