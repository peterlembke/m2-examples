<?php
/**
 * Improove_Module
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * Improove_Module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Improove_Module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Improove_Module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    Improove
 * @package     Improove_Module
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\DiExample\Model;
use CharZam\DiExample\Api\Class1Interface;
use CharZam\DiExample\Api\MyObjectInterface;

class Class1 implements Class1Interface
{
    protected $foo;
    protected $myObject;

    public function __construct(
        $foo = 'class1 foo',
        MyObjectInterface $myObject
    ) {
        $this->foo = $foo;
        $this->myObject = $myObject;
    }

    public function myPublicFunction($foo = '') {

        $className = get_class($this);

        return array(
            'function_foo' => $foo,
            'class_foo' => $this->foo,
            'class_name' => $className
        );
    }

    public function myPublic2($myVar = 0)
    {
        $result = $this->myObject->getStartValue($myVar);

        $className = get_class($this->myObject);

        return array(
            'start_value' => $result,
            'my_object_class' => $className
        );
    }
}