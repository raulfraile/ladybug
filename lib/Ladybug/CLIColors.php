<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * CLI Colors class
 *
 * @author Raúl Fraile Beneyto <raulfraile@gmail.com> || @raulfraile
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug;

class CLIColors
{
    private static $foreground = array(
        'black' => '0;30',
        'dark_gray' => '1;30',
        'blue' => '0;34',
        'light_blue' => '1;34',
        'green' => '0;32',
        'light_green' => '1;32',
        'cyan' => '0;36',
        'light_cyan' => '1;36',
        'red' => '0;31',
        'light_red' => '1;31',
        'purple' => '0;35',
        'light_purple' => '1;35',
        'brown' => '0;33',
        'yellow' => '1;33',
        'light_gray' => '0;37',
        'white' => '1;37'
    );
    private static $background = array(
        'black' => '40',
        'red' => '41',
        'green' => '42',
        'yellow' => '43',
        'blue' => '44',
        'magenta' => '45',
        'cyan' => '46',
        'light_gray' => '47'
    );

    /**
     * Returns colored string
     *
     * @param  string $str        String to be colorized
     * @param  string $foreground Foreground color
     * @param  string $background Background color
     * @return string Colorized string
     */
    public static function getColoredString($str, $foreground = null, $background = null)
    {
        $str_start = "\033[";
        $str_middle = "m";
        $str_end = "\033[0m";
        $colored_string = '';

        if (isset(self::$foreground[$foreground])) {
            $colored_string .= $str_start . self::$foreground[$foreground] . $str_middle;
        }

        if (isset(self::$background[$background])) {
            $colored_string .= $str_start . self::$background[$background] . $str_middle;
        }

        $colored_string .=  $str . $str_end;

        return $colored_string;
    }

}
