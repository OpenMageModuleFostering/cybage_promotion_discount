<?php
/**
 * Cybage Promotion Discount Plugin 
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is available on the World Wide Web at:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to access it on the World Wide Web, please send an email
 * To: Support_Magento@cybage.com.  We will send you a copy of the source file.
 *
 * @category   Promotion Discount Plugin
 * @package    Cybage
 * @copyright  Copyright (c) 2014 Cybage Software Pvt. Ltd., India
 *             http://www.cybage.com/pages/centers-of-excellence/ecommerce/ecommerce.aspx
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Cybage Software Pvt. Ltd. <Support_Magento@cybage.com>
 */

$installer = $this;
$installer->startSetup();
/* Include code from mysql4-upgrade-0.9.38-0.9.39.php */
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote'),
    'coupon_discount', 'decimal(12,4) default 0.00 AFTER `is_persistent`');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote'),
    'promotional_discount', 'decimal(12,4) default 0.00 AFTER `is_persistent`');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_quote'),
    'promo_lable', 'text default null AFTER `is_persistent`');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_order'),
    'coupon_discount', 'decimal(12,4) default 0.00 AFTER `coupon_rule_name`');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_order'),
    'promotional_discount', 'decimal(12,4) default 0.00 AFTER `coupon_rule_name`');
$installer->getConnection()->addColumn($installer->getTable('sales_flat_order'),
    'promo_lable', 'text default null AFTER `coupon_rule_name`');
$installer->endSetup();