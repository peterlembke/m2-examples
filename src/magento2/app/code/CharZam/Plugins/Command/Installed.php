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
namespace CharZam\Plugins\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class Installed extends Command
{

    public function __construct(
        $name = null
    )
    {
        parent::__construct($name);
    }


    protected function configure()
    {
        $this->setName('charzam:plugins:installed');
        $this->setDescription('Test if the module are installed');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Module are installed and works");
    }
}