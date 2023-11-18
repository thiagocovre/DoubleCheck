<?php
namespace DigitalHub\DoubleCheck\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('digitalhub_doublecheck_changes')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'user_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Nome do usuário solicitante'
        )->addColumn(
            'sku',
            Table::TYPE_TEXT,
            64,
            ['nullable' => false],
            'SKU do produto'
        )->addColumn(
            'request_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Data e hora da solicitação de alteração'
        )->addColumn(
            'attribute_name',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Nome do atributo'
        )->addColumn(
            'previous_value',
            Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false],
            'Valor anterior'
        )->addColumn(
            'pending_value',
            Table::TYPE_DECIMAL,
            '12,4',
            ['nullable' => false],
            'Valor pendente de aprovação'
        )->addColumn(
            'approval_status',
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false, 'default' => '0'],
            'Status de aprovação'
        )->setComment(
            'DigitalHub DoubleCheck Changes Table'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
