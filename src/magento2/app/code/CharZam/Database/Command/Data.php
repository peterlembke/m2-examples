<?php
declare(strict_types=1);
/**
 * CharZam_Database
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) 2018  Improove
 *
 * CharZam_Database is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * CharZam_Database is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with CharZam_UseProxy.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category    CharZam
 * @package     CharZam_Database
 * @copyright   Copyright (C) 2018 Improove (http://www.improove.se/)
 * @license     http://www.gnu.org/licenses/agpl-3.0.html
 * @author      Peter Lembke <peter.lembke@improove.se>
 */
namespace CharZam\Database\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use CharZam\Database\Api\Data\WorkoutInterface;
use CharZam\Database\Api\WorkoutRepositoryInterface;

/**
 * Class Data
 * @package CharZam\Database\Command
 * Craetes the test data in the table
 * RUN:
 * magento charzam:database:data
 * RESULT:
 * The table charzam_database_workout should get some test data
 */
class Data extends Command
{
    protected $workout;
    protected $workoutRepository;

    public function __construct(
        WorkoutInterface $workoutInterface,
        WorkoutRepositoryInterface $workoutRepositoryInterface,
        $name = null
    )
    {
        $this->workout = $workoutInterface;
        $this->workoutRepository = $workoutRepositoryInterface;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('charzam:database:data');
        $this->setDescription('Write test data to the table charzam_database_workout');
        parent::configure();
    }

    /**
     * Write example data to the table.
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = array(
            array(
                'date' => '2019-01-04',
                'time' => '03:55:15',
                'note' => 'First in db, middle in sorted search'
            ),
            array(
                'date' => '2019-01-03',
                'time' => '04:15:55',
                'note' => 'Second in db, first in sorted search'
            ),
            array(
                'date' => '2019-01-05',
                'time' => '04:05:00',
                'note' => 'Last in db, last in sorted search'
            ),
        );

        foreach ($data as $item) {
            $workout = $this->workoutRepository->create();
            $workout->setDate($item['date']);
            $workout->setTime($item['time']);
            $workout->setNote($item['note']);
            $workout->setDistance(42195);
            $workout->setCompetition(true);
            $this->workoutRepository->save($workout);
        }

        $output->writeln('--Done');
    }

}