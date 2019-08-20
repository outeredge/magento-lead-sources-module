<?php

namespace OuterEdge\LeadSources\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
   
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        
        //Leads table
        $table = $installer->getConnection()->newTable(
            $installer->getTable('leads')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true, 'default' => null],
            'Template Code'
        )->addColumn(
            'active',
            Table::TYPE_BOOLEAN,
            255,
            ['nullable' => false, 'default' => '0'],
            'Template Code'
        )->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Sort Order'
        )->setComment(
            'Leads Table'
        );
        $installer->getConnection()->createTable($table);
    
        //Add lead column to quote table
        $table = $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'lead',
            [
                'type'     => Table::TYPE_TEXT,
                'unsigned' => true,
                'nullable' => true,
                'default'  => null,
                'comment'  => 'Lead'
            ]
        );
        
        //Add lead column to sales_order table
        $table = $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'lead',
            [
                'type'     => Table::TYPE_TEXT,
                'unsigned' => true,
                'nullable' => true,
                'default'  => null,
                'comment'  => 'Lead'
            ]
        );

        $setup->endSetup();
    }
}
