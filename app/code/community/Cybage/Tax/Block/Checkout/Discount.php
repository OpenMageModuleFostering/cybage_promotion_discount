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

class Cybage_Tax_Block_Checkout_Discount extends Mage_Tax_Block_Checkout_Discount
{
    //template changed to show bifurcated discounts for Extended checkout
    protected $_template = 'cybage_tax/checkout/discount.phtml';

    public function displayBoth()
    {
        return Mage::getSingleton('tax/config')->displayCartSubtotalBoth();
    }

    public function getCustomDiscountRenderer()
    {
        if($this->getQuote()->getCouponDiscount() || $this->getQuote()->getPromotionalDiscount())
        {
            return true;
        }
    }
    public function getDiscountTitle($title){
        switch($title){
            case "coupon":
                $description = $this->getQuote()->getCouponCode();
                $title = Mage::helper('sales')->__('Coupon Discount (%s)', $description);
                break;
             case "promotional":
                 $title = $this->getQuote()->getPromoLable();
                 break;
        }
        return $title;
    }
}
