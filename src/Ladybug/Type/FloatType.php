<?php

/*
 * This file is part of the Ladybug package.
 *
 * (c) Raul Fraile <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Type;

use Ladybug\Type\Exception\InvalidVariableTypeException;

/**
 * Float is an abstraction of a primitive variable of type 'float'
 */
class FloatType extends AbstractType
{

    const TYPE_ID = 'float';

    protected $decimals = 0;

    /** @var boolean $nan Whether the variable is NaN or not */
    protected $nan = false;

    /** @var boolean $infinite Whether the variable is infinite or not */
    protected $infinite = false;

    /** @var string $mathConstant Mathematical constant name */
    protected $mathConstant = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->type = self::TYPE_ID;
    }

    /**
     * @inheritdoc
     */
    public function load($var, $level = 1)
    {
        if (!is_float($var)) {
            throw new InvalidVariableTypeException();
        }

        parent::load($var, $level);

        $this->decimals = strlen(substr(strrchr($var, "."), 1));
        $this->infinite = is_infinite($var);
        $this->nan = is_nan($var);
        $this->mathConstant = $this->detectMathConstant($var, $this->decimals);
    }

    /**
     * Checks whether the variable is NaN.
     *
     * @return bool
     */
    public function isNan()
    {
        return $this->nan;
    }

    /**
     * Checks whether the variable is infinite.
     *
     * @return bool
     */
    public function isInfinite()
    {
        return $this->infinite;
    }

    /**
     * Gets the mathematical constant name, if any.
     *
     * @return string
     */
    public function getMathConstant()
    {
        return $this->mathConstant;
    }

    public function detectMathConstant($var, $precision)
    {
        $constants = array(
            'pi' => array(
                'value' => M_PI,
                'min_precision' => 4
            ),
            'e' => array(
                'value' => M_E,
                'min_precision' => 4
            ),
            'euler_mascheroni' => array(
                'value' => M_EULER,
                'min_precision' => 4
            ),
            'conway' => array(
                'value' => 1.303577269,
                'min_precision' => 4
            )
        );

        foreach ($constants as $name => $item) {
            if (extension_loaded('bcmath')) {
                if (0 === bccomp($var, $item['value'], max($precision - 1, $item['min_precision']))) {
                    return $name;
                }
            } else {
                $p = max($precision - 1, $item['min_precision']);
                if (number_format($var, $p) === number_format($item['value'], $p)) {
                    return $name;
                }
            }
        }

        return null;
    }

    public function getDecimals()
    {
        return $this->decimals;
    }

}
