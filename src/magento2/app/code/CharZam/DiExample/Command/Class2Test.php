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

/**
 * Class Class2Test
 * @package CharZam\DiExample\Command
 * In this test I am using Class2 and MyObject2. See di.xml
 * RUN:
 * magento charzam:class2test
 * RESULT:
 * function_foo="ORIGINAL TEXT IS ALL LOWER CASE"; class_foo="New DI foo 2"; class_name="CharZam\DiExample\Model\Class2";
 * start_value="176"; my_object_class="CharZam\DiExample\Model\MyObject2";
 */
class Class2Test extends Command
{
    protected $class2;

    public function __construct(
        \CharZam\DiExample\Model\Class2 $class2,
        $name = null
    )
    {
        $this->class2 = $class2;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('charzam:di:class2test');
        $this->setDescription('Test argument replacement');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Returns an array: 'function_foo' => $foo,'class_foo' => $this->foo,'class_name' => $className
        // The original text are converted with strtoupper
        $result = $this->class2->myPublicFunction('original text is all lower case');
        $out = $this->makeRow($result);
        $output->writeln($out);
        // function_foo="ORIGINAL TEXT IS ALL LOWER CASE"; class_foo="New DI foo 2"; class_name="CharZam\DiExample\Model\Class2";

        // Start value 60 + myPublic2 adds another 100, MyObject1 brings 16 from di.xml = 176
        $result = $this->class2->myPublic2(60);
        $out = $this->makeRow($result);
        $output->writeln($out);
        // start_value="176"; my_object_class="CharZam\DiExample\Model\MyObject2";
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