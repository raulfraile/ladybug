<?php
/*
 * Ladybug: Simple and Extensible PHP Dumper
 *
 * Mysql/Link dumper
 *
 * (c) Raúl Fraile Beneyto <raulfraile@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ladybug\Extension\Resource;

use Ladybug\Dumper;
use Ladybug\Extension\ExtensionBase;
use Ladybug\Extension\Type;

class MysqlLink extends ExtensionBase
{
    public function getData($var)
    {
        $collection = Type\CollectionType::create(array(
            Type\TextType::create(mysql_get_host_info($var), 'Host info'),
            Type\TextType::create(mysql_get_proto_info($var), 'Protocol version'),
            Type\TextType::create(mysql_get_server_info($var), 'Server version')
        ));

        $collection->setTitle('MySQL connection');

        return $collection;
    }
}
