<?php


namespace Ladybug\Environment;

interface EnvironmentInterface
{

    function getName();

    function isActive();

    function getDefaultFormat();
}
