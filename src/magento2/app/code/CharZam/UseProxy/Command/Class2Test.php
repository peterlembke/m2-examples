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
namespace CharZam\UseProxy\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Class Class2Test
 * @package CharZam\UseProxy\Command
 * In this test I am injecting three classes. Two of them are awfully slow in their construct function
 * but since I am using a proxy then the construct will not be called until I actually use the class.
 * RUN:
 * magento charzam:useproxy:class2test
 * RESULT:
 * function_foo=""; class_foo="class2 foo"; class_name="CharZam\UseProxy\Model\Class2"; time="1.0048677921295";
 * Here you see that the 1 second slow initialization process for Class2 shows when we use the function.
 */
class Class2Test extends Command
{
    protected $class1;
    protected $class2;
    protected $class3;

    public function __construct(
        \CharZam\UseProxy\Api\Class1Interface $class1,
        \CharZam\UseProxy\Api\Class2Interface $class2,
        \CharZam\UseProxy\Api\Class3Interface $class3,
        $name = null
    )
    {
        $this->class1 = $class1;
        $this->class2 = $class2;
        $this->class3 = $class3;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('charzam:useproxy:class2test');
        $this->setDescription('Test use of proxy');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);
        $result = $this->class2->sayHiLater();
        $result['time'] = microtime(true) - $startTime;

        $out = $this->makeRow($result);
        $output->writeln($out);
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