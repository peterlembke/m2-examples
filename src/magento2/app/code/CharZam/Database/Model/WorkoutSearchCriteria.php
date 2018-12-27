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

class WorkoutSearchCriteria extends \Magento\Framework\Api\SearchCriteria
{
    protected $filterFactory = null;
    protected $filterGroupFactory = null;
    protected $sortOrderFactory = null;

    protected function _construct(
        \Magento\Framework\Api\FilterFactory $filterFactory,
        \Magento\Framework\Api\Search\FilterGroupFactory $filterGroupFactory,
        \Magento\Framework\Api\SortOrderFactory $sortOrderFactory
    )
    {
        $this->filterFactory = $filterFactory;
        $this->filterGroupFactory = $filterGroupFactory;
        $this->sortOrderFactory = $sortOrderFactory;
    }

    public function createFilter() {
        return $this->filterFactory->create();
    }

    public function createFilterGroup() {
        return $this->filterGroupFactory->create();
    }

    public function createSortOrder() {
        return $this->sortOrderFactory->create();
    }

}
