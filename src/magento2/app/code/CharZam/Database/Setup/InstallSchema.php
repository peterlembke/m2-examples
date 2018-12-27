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
use \Magento\Framework\DB\Ddl\Table;
use \CharZam\Database\Model\ResourceModel\Workout;


class InstallSchema  implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $setup->startSetup();

        $tables = array(
            Workout::TABLE_NAME
        );

        foreach ($tables as $tableName) {
            $tableFields = $this->getTableFields($tableName);
            $this->createTable($setup, $tableName, $tableFields);
            $tableIndexes = $this->getTableIndexes($tableName);
            $this->addIndexes($setup, $tableName, $tableIndexes);
        }

        $setup->endSetup();
    }

    protected function getTableFields($tableName) {
        $data = array(
            Workout::TABLE_NAME => array(
                'entity_id' => array(
                    'type' => Table::TYPE_INTEGER,
                    'length' => 11,
                    'flags' => array(
                        'unsigned' => true,
                        'identity' => true,
                        'primary' => true,
                        'nullable' => false
                    )
                ),
                'date' => array(
                    'type' => Table::TYPE_DATE,
                    'length' => 0,
                    'flags' => array(
                        'nullable' => false
                    )
                ),
                'time' => array(
                    'type' => Table::TYPE_TEXT,
                    'length' => 8,
                    'flags' => array(
                        'nullable' => true
                    )
                ),
                'distance' => array(
                    'type' => Table::TYPE_INTEGER,
                    'length' => 10,
                    'flags' => array(
                        'nullable' => true
                    )
                ),
                'note' => array(
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'flags' => array(
                        'nullable' => true
                    )
                ),
                'where' => array(
                    'type' => Table::TYPE_TEXT,
                    'length' => 120,
                    'flags' => array(
                        'nullable' => true
                    )
                ),
                'indoor' => array(
                    'type' => Table::TYPE_BOOLEAN,
                    'length' => 1,
                    'flags' => array(
                        'nullable' => true
                    )
                ),
                'competition' => array(
                    'type' => Table::TYPE_BOOLEAN,
                    'length' => 1,
                    'flags' => array(
                        'nullable' => true
                    )
                ),
            )
        );
        if (isset($data[$tableName]) === true) {
            return $data[$tableName];
        }
        return array();
    }

    protected function getTableIndexes($tableName = '') {
        $data = array(
            Workout::TABLE_NAME => array(
                'date' => array('unique' => false, 'fields' => array('date')),
                'time' => array('unique' => false, 'fields' => array('time')),
                'distance' => array('unique' => false, 'fields' => array('distance')),
                'note' => array('unique' => false, 'fields' => array('note')),
                'where' => array('unique' => false, 'fields' => array('where')),
                'indoor' => array('unique' => false, 'fields' => array('indoor')),
                'competition' => array('unique' => false, 'fields' => array('competition'))
            )
        );
        if (isset($data[$tableName]) === true) {
            return $data[$tableName];
        }
        return array();
    }

    /**
     * Create a table
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param string $tableName
     * @param array $tableFields
     */
    protected function createTable($setup, $tableName = '', $tableFields = array())
    {
        if($setup->tableExists($tableName) === false) {
            return;
        }
        $table = $setup->getConnection()->newTable($tableName);
        foreach ($tableFields as $fieldName => $fieldData) {
            $table->addColumn($fieldName, $fieldData['type'], $fieldData['length'], $fieldData['flags']);
        }
        $setup->getConnection()->createTable($table);
    }

    /**
     * Create all indexes
     * @param $setup
     * @param string $tableName
     * @param array $tableIndexes
     */
    protected function addIndexes($setup, $tableName = '', $tableIndexes = array()) {
        foreach ($tableIndexes as $tableIndex) {
            $this->addIndex($setup, $tableName, $tableIndex['fields'], $tableIndex['unique']);
        }
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
