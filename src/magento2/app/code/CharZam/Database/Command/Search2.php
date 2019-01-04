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
 * Class Set
 * @package CharZam\Database\Command
 * Set a value in the resource model we created in this module
 * RUN:
 * magento charzam:database:set keyname value
 * RESULT:
 * Shows if it was a success or not
 */
class Search2 extends Command
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
        $this->setName('charzam:database:search2');
        $this->setDescription('Search for workouts by distance (using searchCriteriaBuilder)');
        parent::configure();
    }

    /**
     * Search for all distance = 42195 and competition = 1, sorted by date ascending
     * The search function uses the search criteria builder to handle the filters and filter groups.
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \CharZam\Database\Api\Data\WorkoutSearchResultInterface $searchResult */
        $searchResult = $this->workoutRepository->getSearchResultByDistanceAndCompetition2($distance = 42195);

        /** @var \CharZam\Database\Model\ResourceModel\Workout\Collection $collection */
        $collection = $searchResult->getCollection();

        $items = $collection->getItems();

        $output->writeln('Items found:');
        foreach ($items as $item) {
            $itemDataArray = $item->getData();
            $row = $this->makeRow($itemDataArray);
            $output->writeln($row);
        }
        $output->writeln('--DONE');
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