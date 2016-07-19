<?php
/**
 * Created by PhpStorm.
 * User: manuele
 * Date: 29/10/15
 * Time: 11:03
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer
    ->getConnection()
    ->addColumn(
        $installer->getTable('sales/quote'),
        'invoice_request',
        array(
            'TYPE' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'NULLABLE' => false,
            'DEFAULT' => 0,
            'COMMENT' => 'Invoice Request Flag'
        )
    )
;
$installer
    ->getConnection()
    ->addColumn(
        $installer->getTable('sales/order'),
        'invoice_request',
        array(
            'TYPE' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'NULLABLE' => false,
            'DEFAULT' => 0,
            'COMMENT' => 'Invoice Request Flag'
        )
    )
;

$installer->endSetup();
