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
namespace CharZam\Database\Model;

use CharZam\Database\Api\Data\WorkoutInterface;
use CharZam\Database\Api\WorkoutRepositoryInterface;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\InputException;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use CharZam\Database\Api\Data\WorkoutSearchResultInterfaceFactory as SearchResultFactory;
use CharZam\Database\Model\WorkoutSearchCriteriaFactory;
use \Magento\Framework\Api\SearchCriteriaInterface;


class WorkoutRepository implements WorkoutRepositoryInterface
{
    /**
     * @var \CharZam\Database\Model\WorkoutFactory
     */
    protected $workoutFactory;

    /**
     * @var \CharZam\Database\Model\ResourceModel\Workout
     */
    protected $resource;

    /**
     * @var \CharZam\Database\Model\ResourceModel\Workout\CollectionFactory
     */
    protected $collectionFactory;

    protected $resourceConnection;

    /**
     * @var SearchResultFactory
     */
    protected $searchResultFactory = null;

    protected $searchCriteriaFactory = null;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @param WorkoutFactory $workoutFactory
     * @param ResourceModel\Workout $resource
     * @param ResourceModel\Workout\CollectionFactory $collectionFactory
     * @param SearchResultFactory $searchResultFactory
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        \CharZam\Database\Model\WorkoutFactory $workoutFactory,
        \CharZam\Database\Model\ResourceModel\Workout $resource,
        \CharZam\Database\Model\ResourceModel\Workout\CollectionFactory $collectionFactory,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        SearchResultFactory $searchResultFactory,
        WorkoutSearchCriteriaFactory $workoutSearchCriteriaFactory,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->workoutFactory = $workoutFactory;
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;

        $this->resourceConnection = $resourceConnection;

        $this->searchResultFactory = $searchResultFactory;
        $this->searchCriteriaFactory = $workoutSearchCriteriaFactory;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Create a new empty workout object
     * @return WorkoutInterface
     */
    public function create()
    {
        $workout = $this->workoutFactory->create();
        return $workout;
    }

    /**
     * Create a new empty searchCriteria object
     * @return \CharZam\Database\Model\WorkoutSearchCriteria
     */
    public function createSearchCriteria()
    {
        $searchCriteria = $this->searchCriteriaFactory->create();
        return $searchCriteria;
    }

    /**
     * Save a workout
     * @param WorkoutInterface $workout
     * @return WorkoutInterface
     * @throws CouldNotSaveException
     */
    public function save(WorkoutInterface $workout)
    {
        try {
            $this->resource->save($workout);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $workout;
    }

    /**
     * Load a workout by its entity_id
     * @param int $entityId
     * @return WorkoutInterface
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function loadById($entityId = 0)
    {
        if (!$entityId) {
            throw new InputException(__('Id required'));
        }

        $workout = $this->create();

        try {
            $this->resource->load($workout, $entityId, 'entity_id');
        } catch (\Exception $e) {
            throw new NoSuchEntityException(__($e->getMessage()));
        }

        return $workout;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \CharZam\Database\Api\Data\WorkoutInterface[]
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $workoutInterfaceClassName = \CharZam\Database\Api\Data\WorkoutInterface::class;
        $this->extensionAttributesJoinProcessor->process($collection, $workoutInterfaceClassName);

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setCollection($collection);
        return $searchResults;
    }

    /**
     * Delete a workout
     * @param WorkoutInterface $workout
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(WorkoutInterface $workout)
    {
        try {
            $this->resource->delete($workout);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * Delete a row in the table by its entity_id
     * @param int $entityId
     * @return bool
     * @throws InputException
     * @throws CouldNotDeleteException
     */
    public function deleteById($entityId = 0)
    {
        if (!$entityId) {
            throw new InputException(__('Id required'));
        }

        try {
            $workout = $this->loadById($entityId);
            $this->delete($workout);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }

    /**
     * Truncate the table. That will delete all table contents
     * @throws CouldNotDeleteException
     */
    public function deleteAll()
    {
        try {
            $this->resource->deleteAll();
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
    }

    /**
     * Get all workouts for a specific distance that are marked as competition = true
     * I do not like using trow new but that is how Magento 2 is built.
     * Using a direct SQL query to get the result.
     * This is discouraged. I use this sometimes for saving development time and execution time.
     * @param integer $distance
     * @return array
     * @throws InputException
     */
    public function getItemsArrayByDistanceAndCompetition($distance = 0)
    {
        if (!$distance) {
            throw new InputException(__('Distance in meter required'));
        }

        $sql = 'select * from charzam_database_workout where distance=' . (int) $distance . ' and competition=true order by date asc';
        $result = $this->sqlRead($sql);
        return $result;
    }

    /**
     * Get all workouts for a specific distance that are marked as competition = true
     * I do not like using trow new but that is how Magento 2 is built.
     * The collection code is inherited from Magento 1.
     * @param integer $distance
     * @return \CharZam\Database\Model\ResourceModel\Workout\Collection
     * @throws InputException
     */
    public function getCollectionByDistanceAndCompetition($distance = 0)
    {
        if (!$distance) {
            throw new InputException(__('Distance in meter required'));
        }

        /** @var \CharZam\Database\Model\ResourceModel\Workout\Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('distance', $distance);
        $collection->addFieldToFilter('competition', true);
        $collection->addOrder('date', \CharZam\Database\Model\ResourceModel\Workout\Collection::SORT_ORDER_ASC);
        // Use addFieldToFilter when it is a table field
        // Use addAttributeToFilter when it is an EAV attribute
        return $collection;
    }

    /**
     * Get all workouts for a specific distance that are marked as competition = true
     * I do not like using trow new but that is how Magento 2 is built.
     * This is the new Magento 2 way of searching. You get the same data as with the other two functions above.
     * https://devdocs.magento.com/guides/v2.2/extension-dev-guide/searching-with-repositories.html
     * @param integer $distance
     * @return \CharZam\Database\Api\Data\WorkoutSearchResultInterface
     * @throws InputException
     */
    public function getSearchResultByDistanceAndCompetition($distance = 0)
    {
        if (!$distance) {
            throw new InputException(__('Distance in meter required'));
        }

        $searchCriteria = $this->createSearchCriteria();

        /** @var \Magento\Framework\Api\Filter $distanceFilter */
        $distanceFilter = $searchCriteria->createFilter();

        /** @var \Magento\Framework\Api\Search\FilterGroup $distanceFilterGroup */
        $distanceFilterGroup = $searchCriteria->createFilterGroup();

        /** @var \Magento\Framework\Api\Filter $competitionFilter */
        $competitionFilter = $searchCriteria->createFilter();

        /** @var \Magento\Framework\Api\Search\FilterGroup $competitionFilterGroup */
        $competitionFilterGroup = $searchCriteria->createFilterGroup();

        $distanceFilter->setField('distance')->setValue($distance)->setConditionType('eq');
        $distanceFilterGroup->setFilters(array($distanceFilter));

        $competitionFilter->setField('competition')->setValue(true)->setConditionType('eq');
        $competitionFilterGroup->setFilters(array($competitionFilter));

        $searchCriteria->setFilterGroups(array($distanceFilterGroup, $competitionFilterGroup));

        /** @var \Magento\Framework\Api\SortOrder $sortOrderDateAscending */
        $sortOrderDateAscending = $searchCriteria->createSortOrder();
        $sortOrderDateAscending->setField('date')->setDirection(\Magento\Framework\Api\SortOrder::SORT_ASC);

        $searchCriteria->setSortOrders(array($sortOrderDateAscending));

        /** @var \CharZam\Database\Api\Data\WorkoutSearchResultInterface $searchResult */
        $searchResult = $this->getList($searchCriteria);

        return $searchResult;
    }

    /**
     * Direct SQL query read.
     * We should not use SQL, there are almost always another solution,
     * But sometimes a one line SQL query is both quick and saves time.
     * @param string $sql
     * @return array
     */
    protected function sqlRead($sql = '') {
        $connection = $this->resourceConnection->getConnection();
        $data = $connection->fetchAll($sql);
        return $data;
    }

    /**
     * Direct SQL query write.
     * We should not use SQL, there are almost always another solution,
     * But sometimes a one line SQL query is both quick and saves time.
     * @param string $sql
     * @return array
     */
    protected function sqlWrite($sql = '') {
        $connection = $this->resourceConnection->getConnection();
        $data = $connection->query($sql);
        return $data;
    }

}
