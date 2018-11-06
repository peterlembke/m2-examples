<?php
declare(strict_types=1);
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
namespace CharZam\DiExample\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use CharZam\DiExample\Model\Class4;

/**
 * Class Class4Test
 * @package CharZam\DiExample\Command
 * In this test I am using Class4 and the virtual class MyObject4 based on MyObject3. See di.xml
 * RUN:
 * magento charzam:class4test
 * RESULT:
 * function_foo="esac rewol lla si txet lanigiro"; class_foo="New DI foo 4"; class_name="CharZam\DiExample\Model\Class4";
 * start_value="11080"; my_object_class="CharZam\DiExample\Model\MyObject3";
 */
class Class4Test extends Command
{
    protected $class4;

    public function __construct(
        Class4 $class4,
        $name = null
    )
    {
        $this->class4 = $class4;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('charzam:di:class4test');
        $this->setDescription('Test argument replacement');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Returns an array: 'function_foo' => $foo,'class_foo' => $this->foo,'class_name' => $className
        // The original text are converted with ucwords (Camel case)
        $result = $this->class4->myPublicFunction('original text is all lower case');
        $out = $this->makeRow($result);
        $output->writeln($out);
        // function_foo="esac rewol lla si txet lanigiro"; class_foo="New DI foo 4"; class_name="CharZam\DiExample\Model\Class4";

        // Start value 80 + myPublic2 (MyObject3) adds another 1000, MyObject4 brings 10000 from di.xml = 11080
        $result = $this->class4->myPublic2(80);
        $out = $this->makeRow($result);
        $output->writeln($out);
        // start_value="11080"; my_object_class="CharZam\DiExample\Model\MyObject3";
    }

    protected function makeRow(array $in = array())
    {
        $out = '';
        foreach ($in as $key => $data) {
            $row = $key .'="'.$data.'"; ';
            $out = $out . $row;
        }
        return $out;
    }
}