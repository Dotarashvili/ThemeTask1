<?php

namespace Alliance\Linkedin\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $quote = $setup->getTable('quote');
        $salesOrder = $setup->getTable('sales_order');

        if(version_compare($context->getVersion(), '1.3.0', '<')) {
            $setup->getConnection()->addColumn(
                $quote,
                'linkedin_profile',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Linkedin Profile'
                ]
            );


            $setup->getConnection()->addColumn(
                $salesOrder,
                'linkedin_profile',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' => 'Linkedin Profile'
                ]
            );
        }

        $setup->endSetup();
    }
}
