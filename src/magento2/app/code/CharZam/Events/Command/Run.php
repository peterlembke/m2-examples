<?php
declare(strict_types=1);
/**
 * CharZam_Events
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Events is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Events is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_Events.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Events
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\Events\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Class Run
 * @package CharZam\Events\Command
 * Demonstrate the use of events. How to trigger them and how to listen to them.
 * RUN:
 * magento charzam:events:run
 * RESULT:
 * Before writing Done
 * Done
 * After writing Done
 */
class Run extends Command
{
    protected $eventManager;

    public function __construct(
        \Magento\Framework\EntityManager\EventManager $eventManager,
        $name = null
    )
    {
        $this->eventManager = $eventManager;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('charzam:events:run');
        $this->setDescription('Test use of events');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventManager->dispatch('charzam_events_done_before', array(
            'message' => 'I will soon write Done in the console',
            'output_interface' => $output
        ));

        $output->writeln('Done');

        $this->eventManager->dispatch('charzam_events_done_after', array(
            'message' => 'I have written Done in the console',
            'output_interface' => $output
        ));

    }

}