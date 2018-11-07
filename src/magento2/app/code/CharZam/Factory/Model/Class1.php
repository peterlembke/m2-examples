<?php
declare(strict_types=1);
/**
 * CharZam_Factory
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Factory is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Factory is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_Factory.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Factory
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\Factory\Model;
use CharZam\Factory\Api\Class1Interface;

class Class1 implements Class1Interface
{
    protected $foo;

    public function __construct(
        $foo = 'class1 foo'
    ) {
        $this->foo = $foo;
    }

    public function myPublicFunction($foo = 0): array
    {

        $className = get_class($this);

        return array(
            'function_foo' => $foo,
            'class_foo' => $this->foo,
            'class_name' => $className
        );
    }
}