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
namespace CharZam\Factory\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use CharZam\Factory\Api\Class1Interface;

/**
 * Class Run
 * @package CharZam\Factory\Command
 * In this test I am instantiating a new class1, see di.xml shared="false"
 * I also instantiate a factory of the customer class. The factory can then create new empty customer objects.
 * RUN:
 * magento charzam:factory:run
 * RESULT:
 * customer factory="Magento\Customer\Api\Data\CustomerInterfaceFactory"; customer object="Magento\Customer\Model\Data\Customer"; class1 object="CharZam\Factory\Model\Class1";
 */
class Run extends Command
{
    protected $class1;
    protected $customerFactory;

    public function __construct(
        Class1Interface $class1,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerFactory,
        $name = null
    )
    {
        $this->class1 = $class1;
        $this->customerFactory = $customerFactory;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('charzam:factory:run');
        $this->setDescription('Test factory and shared');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $newCustomerObject = $this->customerFactory->create();

        $result = array(
            'customer factory' => get_class($this->customerFactory),
            'customer object' => get_class($newCustomerObject),
            'class1 object' => get_class($this->class1)
        );
        $out = $this->makeRow($result);
        $output->writeln($out);
    }

    protected function makeRow(array $in = array()): string
    {
        $out = '';
        foreach ($in as $key => $data) {
            $row = $key .'="'.$data.'"; ';
            $out = $out . $row;
        }
        return $out;
    }

}