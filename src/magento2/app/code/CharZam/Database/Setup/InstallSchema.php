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
namespace CharZam\Database\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema  implements InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context): void
    {
        $setup->startSetup();
        $tableName = \CharZam\Database\Model\ResourceModel\Workout::TABLE_NAME;
        if(!$setup->tableExists($tableName)) {
            $table = $setup->getConnection()->newTable($tableName);
            $table
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    11,
                    [
                        'unsigned' => true,
                        'identity' => true,
                        'primary' => true,
                        'nullable' => false
                    ]
                )
                ->addColumn(
                    'material',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => true
                    ]
                )
                ->addColumn(
                    'plant',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => true
                    ]
                )
                ->addColumn(
                    'po',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => true
                    ]
                )
                ->addColumn(
                    'item_number',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => true
                    ]
                )
                ->addColumn(
                    'release_date',
                    Table::TYPE_DATE,
                    null,
                    [
                        'nullable' => true
                    ]
                )
                ->addColumn(
                    'planned_del_date',
                    Table::TYPE_DATE,
                    null,
                    [
                        'nullable' => true
                    ]
                )
                ->addColumn(
                    'open_qty',
                    Table::TYPE_INTEGER,
                    11,
                    [
                        'nullable' => true
                    ]
                )
            ;
            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }

    /**
     * Add an index
     * @param $setup
     * @param string $tableName
     * @param array $fields
     * @param bool|false $unique
     */
    protected function addIndex($setup, $tableName = '', $fields = array(), $unique = false)
    {
        $indexType = \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX;
        if ($unique === true) {
            $indexType = \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE; // !! yes UNIQUE!!
        }

        $indexName = $setup->getConnection()->getIndexName($tableName, $fields, $indexType);
        $setup->getConnection()->addIndex($tableName, $indexName, $fields, $indexType, $schemaName = null);
    }

}
