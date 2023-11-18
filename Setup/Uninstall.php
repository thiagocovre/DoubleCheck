<?php
namespace DigitalHub\DoubleCheck\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        // Remova a tabela do banco de dados, se existir
        if ($installer->tableExists('digitalhub_doublecheck_changes')) {
            $installer->getConnection()->dropTable('digitalhub_doublecheck_changes');
        }

        $installer->endSetup();
    }
}
