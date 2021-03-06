<?php

namespace Codelegacy\Faq\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Codelegacy\Faq\Helper\Constants;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $this->_createCategoryTable($setup);
        $this->_createQuestionTable($setup);
        $setup->endSetup();
    }

    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    private function _createCategoryTable(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable(Constants::DB_PREFIX . 'faq_category');

        if ($setup->tableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()->newTable($tableName);
        $this->_addPrimaryIdColumn($table, 'category_id');
        $this->_addTitleColumn($table);
        $this->_addStatusColumn($table);
        $this->_addStoreIdsColumn($table);
        $this->_addSortOrderColumn($table);
        $this->_addTimeColumns($table);
        $this->_addIndexes($table, $setup);
        $table->setComment('FAQ Category');
        $setup->getConnection()->createTable($table);
    }

    /**
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    private function _createQuestionTable(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable(Constants::DB_PREFIX . 'faq_question');
        $categoryTable = $setup->getTable(Constants::DB_PREFIX . 'faq_category');

        if ($setup->tableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()->newTable($tableName);
        $this->_addPrimaryIdColumn($table, 'question_id');
        $table->addColumn(
            'category_id', Table::TYPE_INTEGER, null,
            ['nullable' => false, 'unsigned' => true], 'Category ID'
        );
        $this->_addTitleColumn($table);
        $this->_addStatusColumn($table);
        $this->_addStoreIdsColumn($table);
        $this->_addSortOrderColumn($table);
        $table->addColumn(
            'content',
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Content'
        )
            ->addColumn(
                'useful',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0', 'unsigned' => true],
                'Useful'
            )
            ->addColumn(
                'useless',
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'default' => '0', 'unsigned' => true],
                'Useless'
            );
        $this->_addForeignKey($table, $setup, 'category_id', $categoryTable, 'category_id');
        $this->_addTimeColumns($table);
        $this->_addIndexes($table, $setup);
        $table->setComment('FAQ Questions');
        $setup->getConnection()->createTable($table);
    }

    /**
     * @param Table $table
     * @throws \Zend_Db_Exception
     */
    private function _addStatusColumn(Table &$table)
    {
        $table->addColumn(
            'status',
            Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false, 'default' => 0],
            'Is enabled'
        );
    }

    /**
     * @param Table $table
     * @throws \Zend_Db_Exception
     */
    private function _addTimeColumns(Table &$table)
    {
        $table->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Creation Time'
        )
            ->addColumn(
                'update_time',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false,
                 'default'  => Table::TIMESTAMP_INIT_UPDATE],
                'Modification Time'
            );
    }

    /**
     * @param Table $table
     * @param int $length
     * @throws \Zend_Db_Exception
     */
    private function _addTitleColumn(Table &$table, $length = 255)
    {
        $table->addColumn('title', Table::TYPE_TEXT, $length, ['nullable' => false], 'Title');
    }

    /**
     * @param Table $table
     * @throws \Zend_Db_Exception
     */
    private function _addSortOrderColumn(Table &$table)
    {
        $table->addColumn(
            'sort_order',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '0', 'unsigned' => true],
            'Sort Order'
        );
    }

    /**
     * @param Table $table
     * @param int $length
     * @throws \Zend_Db_Exception
     */
    private function _addStoreIdsColumn(Table &$table, int $length = 255)
    {
        $table->addColumn(
            'store_ids', Table::TYPE_TEXT, $length,
            ['nullable' => false, 'default' => '0'], 'Store Ids'
        );
    }

    /**
     * @param Table $table
     * @param string $title
     * @throws \Zend_Db_Exception
     */
    private function _addPrimaryIdColumn(Table &$table, string $title)
    {
        $table->addColumn(
            $title, Table::TYPE_INTEGER, null,
            [
                'identity' => true,
                'nullable' => false,
                'primary'  => true,
                'unsigned' => true,
            ], 'ID'
        );
    }

    /**
     * @param Table $table
     * @param SchemaSetupInterface $setup
     * @param string $column
     * @param string $refTable
     * @param string $refColumn
     * @throws \Zend_Db_Exception
     */
    private function _addForeignKey(
        Table &$table,
        SchemaSetupInterface $setup,
        string $column,
        string $refTable,
        string $refColumn
    ) {
        $fkName = $setup->getFkName($table->getName(), $column, $refTable, $refColumn);
        $table->addForeignKey(
            $fkName,
            $column,
            $refTable,
            $refColumn,
            Table::ACTION_CASCADE
        );
    }

    /**
     * @param Table $table
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    private function _addIndexes(Table &$table, SchemaSetupInterface $setup)
    {
        $this->_addIndex($table, $setup, ['sort_order']);
        $this->_addIndex($table, $setup, ['status']);
        $this->_addIndex($table, $setup, ['store_ids']);
    }

    /**
     * @param Table $table
     * @param SchemaSetupInterface $setup
     * @param array $fields
     * @throws \Zend_Db_Exception
     */
    private function _addIndex(Table &$table, SchemaSetupInterface $setup, array $fields)
    {
        $table->addIndex($setup->getIdxName($table->getName(), $fields), $fields);
    }
}