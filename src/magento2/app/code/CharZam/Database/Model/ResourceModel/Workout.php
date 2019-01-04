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
namespace CharZam\Database\Model\ResourceModel;

class Workout extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const TABLE_NAME = 'charzam_database_workout';

    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, 'entity_id');
    }

    public function deleteAll()
    {
        $this->getConnection()->truncateTable(self::TABLE_NAME);
    }

}
