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
namespace CharZam\Database\Api;

use CharZam\Database\Api\Data\WorkoutInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface WorkoutRepositoryInterface
{
    /**
     * Create a new empty workout object
     */
    public function create();

    /**
     * @param \CharZam\Database\Api\Data\WorkoutInterface $workout
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(WorkoutInterface $workout);

    /**
     * @param int $entityId
     * @return \CharZam\Database\Api\Data\WorkoutInterface
     */
    public function loadById($entityId = 0);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param \CharZam\Database\Api\Data\WorkoutInterface $workout
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(WorkoutInterface $workout);

    /**
     * @param int $entityId
     * @return mixed
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($entityId = 0);

    /**
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteAll();

    /**
     * Search with a direct SQL query. This is the no way. But I use it sometimes to save time.
     * @param int $distance
     * @return mixed
     */
    public function getItemsArrayByDistanceAndCompetition($distance = 0);

    /**
     * Search with the old collection methods. Inherited from Magento 1.
     * @param int $distance
     * @return mixed
     */
    public function getCollectionByDistanceAndCompetition($distance = 0);

    /**
     * Search with the new searchCriteria methods. Magento 2 way.
     * @param int $distance
     * @return mixed
     */
    public function getSearchResultByDistanceAndCompetition($distance = 0);

    /**
     * Search with the new criteria builder that is a wrapper for the searchCriteria methods. Magento 2 way.
     * @param int $distance
     * @return mixed
     */
    public function getSearchResultByDistanceAndCompetition2($distance = 0);
}
