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
use CharZam\DiExample\Model\Class3;

/**
 * Class Class3Test
 * @package CharZam\DiExample\Command
 * In this test I am using Class3 and MyObject3. See di.xml
 * RUN:
 * magento charzam:class3test
 * RESULT:
 * function_foo="Original Text Is All Lower Case"; class_foo="New DI foo 3"; class_name="CharZam\DiExample\Model\Class3";
 * start_value="1102"; my_object_class="CharZam\DiExample\Model\MyObject3";
 */
class Class3Test extends Command
{
    protected $class3;

    public function __construct(
        Class3 $class3,
        $name = null
    )
    {
        $this->class3 = $class3;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('charzam:di:class3test');
        $this->setDescription('Test argument replacement');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Returns an array: 'function_foo' => $foo,'class_foo' => $this->foo,'class_name' => $className
        // The original text are converted with ucwords (Camel case)
        $result = $this->class3->myPublicFunction('original text is all lower case');
        $out = $this->makeRow($result);
        $output->writeln($out);
        // function_foo="Original Text Is All Lower Case"; class_foo="New DI foo 3"; class_name="CharZam\DiExample\Model\Class3";

        // Start value 70 + myPublic2 adds another 1000, MyObject3 brings 32 from di.xml = 1102
        $result = $this->class3->myPublic2(70);
        $out = $this->makeRow($result);
        $output->writeln($out);
        // start_value="1102"; my_object_class="CharZam\DiExample\Model\MyObject3";
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