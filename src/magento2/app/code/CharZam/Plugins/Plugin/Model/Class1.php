<?php
/**
 * CharZam_Plugins
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Plugins is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Plugins is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_UseProxy.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Plugins
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\Plugins\Plugin\Model;
class Class1
{
    const VALUE = 'function_foo';

    public function beforeMyPublicFunction($subject, $foo=0)
    {
        echo "Calling " . __METHOD__ . " IN=" . $foo . "\n";

        $foo++;

        return array($foo);
    }

    public function afterMyPublicFunction($subject, $result)
    {

        echo "Calling " . __METHOD__ . " IN=" . $result[self::VALUE] . "\n";

        $result[self::VALUE]++;

        return $result;
    }

    public function aroundMyPublicFunction($subject, $procede, $foo=0)
    {
        echo 'Calling' . __METHOD__ . ' -- before' . " IN=" . $foo . "\n";

        $foo++;

        $result = $procede($foo);

        /*
        $result = array(
            'function_foo' => $foo,
            'class_foo' => '',
            'class_name' => ''
        );
        */

        echo 'Calling' . __METHOD__ . ' -- after' . " IN=" . $result[self::VALUE] . "\n";

        $result[self::VALUE]++;

        return $result;
    }
}