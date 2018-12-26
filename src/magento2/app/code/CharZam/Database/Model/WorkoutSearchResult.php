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
use CharZam\Database\Api\Data\WorkoutSearchResultInterface;
use CharZam\Database\Model\ResourceModel\Workout\Collection;

class WorkoutSearchResult extends \Magento\Framework\Model\AbstractModel implements WorkoutSearchResultInterface
{
    protected $_collection = null;
    protected $_searchCriteria = null;

    protected function _construct()
    {
        $resourceModelName = \CharZam\Database\Model\ResourceModel\Workout::class;
        $this->_init($resourceModelName);
    }

    /**
     * @return Collection
     */
    public function getCollection() {
        return $this->_collection;
    }

    /**
     * @param Collection $collection
     * @return $this
     */
    public function setCollection(Collection $collection) {
        $this->_collection = $collection;
        return $this;
    }

    /**
     * Get items list.
     *
     * @return \Magento\Framework\Api\ExtensibleDataInterface[]
     */
    public function getItems() {
        return $this->_collection->getItems();
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     */
    public function setItems(array $items) {
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface
     */
    public function getSearchCriteria() {
        return $this->_searchCriteria;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria) {
        $this->_searchCriteria = $searchCriteria;
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount() {
        return $this->_collection->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount) {
        return $this;
    }
}
