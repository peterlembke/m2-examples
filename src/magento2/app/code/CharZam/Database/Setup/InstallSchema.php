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
                    ),
                    'comment' => 'Unique ID'
                ),
                'date' => array(
                    'type' => Table::TYPE_DATE,
                    'length' => 0,
                    'flags' => array(
                        'nullable' => false,
                        'default' => '2019-01-01'
                    ),
                    'comment' => 'Date for the workout YYYY-MM-DD'
                ),
                'time' => array(
                    'type' => Table::TYPE_TEXT,
                    'length' => 8,
                    'flags' => array(
                        'nullable' => true,
                        'default' => '00:00:00'
                    ),
                    'comment' => 'The amount of time you worked out HH:MM:SS'
                ),
                'distance' => array(
                    'type' => Table::TYPE_INTEGER,
                    'length' => 10,
                    'flags' => array(
                        'nullable' => true,
                        'default' => 0
                    ),
                    'comment' => 'The distance in meter.'
                ),
                'note' => array(
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'flags' => array(
                        'nullable' => true
                    ),
                    'comment' => 'Any note you have about the workout'
                ),
                'where' => array(
                    'type' => Table::TYPE_TEXT,
                    'length' => 120,
                    'flags' => array(
                        'nullable' => true,
                        'default' => 'Stockholm, Sweden'
                    ),
                    'comment' => 'City, Country'
                ),
                'indoor' => array(
                    'type' => Table::TYPE_BOOLEAN,
                    'length' => 1,
                    'flags' => array(
                        'nullable' => true,
                        'default' => 0
                    ),
                    'comment' => 'Was the workout indoor?'
                ),
                'competition' => array(
                    'type' => Table::TYPE_BOOLEAN,
                    'length' => 1,
                    'flags' => array(
                        'nullable' => true,
                        'default' => 0
                    ),
                    'comment' => 'Was the workout a competition?'
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
        if ($setup->tableExists($tableName) === true) {
            return;
        }
        $table = $setup->getConnection()->newTable($tableName);

        $default = array(
            'type' => '',
            'length' => 0,
            'flags' => array(),
            'comment' => ''
        );

        foreach ($tableFields as $fieldName => $fieldData) {
            $fieldData = $this->_Default($default, $fieldData);
            $table->addColumn($fieldName, $fieldData['type'], $fieldData['length'], $fieldData['flags'], $fieldData['comment']);
        }
        $setup->getConnection()->createTable($table);
    }

    /**
     * Create all indexes
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param string $tableName
     * @param array $tableIndexes
     */
    protected function addIndexes($setup, $tableName = '', $tableIndexes = array()) {
        if ($setup->tableExists($tableName) === false) {
            return;
        }

        $default = array(
            'unique' => false,
            'fields' => array()
        );

        foreach ($tableIndexes as $tableIndex) {
            $tableIndex = $this->_Default($default, $tableIndex);
            $this->addIndex($setup, $tableName, $tableIndex['fields'], $tableIndex['unique']);
        }
    }

    /**
     * Add an index
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
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

    /**
     * Make sure you get all variables you expect, at least with default values, and the right data type.
     * Used by: EVERY function.
     * The $default variables, You can only use: array, string, integer, float, null
     * The $in variables, You can only use: array, string, integer, float
     * @example: $in = _Default($default,$in);
     * @version 2016-01-25
     * @since   2013-09-05
     * @author  Peter Lembke
     * @param $default
     * @param $in
     * @return array
     */
    final protected function _Default(array $default = array(), array $in = array())
    {
        // On this level: Remove all variables that are not in default. Add all variables that are only in default.
        $answer = array_intersect_key(array_merge($default, $in), $default);

        // Check the data types
        foreach ($default as $key => $data) {
            if (gettype($answer[$key]) !== gettype($default[$key])) {
                if (is_null($default[$key]) === false) {
                    $answer[$key] = $default[$key];
                }
                continue;
            }
            if (is_null($default[$key]) === true and is_null($answer[$key]) === true) {
                $answer[$key] = '';
                continue;
            }
            if (is_array($default[$key]) === false) {
                continue;
            }
            if (count($default[$key]) === 0) {
                continue;
            }
            $answer[$key] = $this->_Default($default[$key], $answer[$key]);
        }

        return $answer;
    }
}
