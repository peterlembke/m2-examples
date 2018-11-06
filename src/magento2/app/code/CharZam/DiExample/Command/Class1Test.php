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
namespace CharZam\DiExample\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Class Class1Test
 * @package CharZam\DiExample\Command
 * In this test I am using Class1 and MyObject1. See di.xml
 * RUN:
 * magento charzam:class2test
 * RESULT:
 * function_foo="original text is all lower case"; class_foo="New DI foo 1"; class_name="CharZam\DiExample\Model\Class1";
 * start_value="58"; my_object_class="CharZam\DiExample\Model\MyObject1";
 */
class Class1Test extends Command
{
    protected $class1;

    public function __construct(
        \CharZam\DiExample\Api\Class1Interface $class1,
        $name = null
    )
    {
        $this->class1 = $class1;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('charzam:class1test');
        $this->setDescription('Test dependency injection');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Returns an array: 'function_foo' => $foo,'class_foo' => $this->foo,'class_name' => $className
        // The original text are returned unchanged.
        $result = $this->class1->myPublicFunction('original text is all lower case');
        $out = $this->makeRow($result);
        $output->writeln($out);
        // function_foo="original text is all lower case"; class_foo="New DI foo 1"; class_name="CharZam\DiExample\Model\Class1";

        // Start value 50 + MyObject1 brings 8 from di.xml = 58
        $result = $this->class1->myPublic2(50);
        $out = $this->makeRow($result);
        $output->writeln($out);
        // start_value="58"; my_object_class="CharZam\DiExample\Model\MyObject1";
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