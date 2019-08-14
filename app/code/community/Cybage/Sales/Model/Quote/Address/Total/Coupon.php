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

class Cybage_Sales_Model_Quote_Address_Total_Coupon extends Mage_Sales_Model_Quote_Address_Total_Abstract
{   
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
 
        $this->_setAmount(0);
        $this->_setBaseAmount(0);
 
        $items = $this->_getAddressItems($address);
        if (!count($items)) {
            return $this; //this makes only address type shipping to come through
        }
 
        $quote = $address->getQuote();
 
        $amountDiscount = $address->getCouponDiscount();
        $amountPromotion = $address->getPromotionalDiscount();	 
        $address->setBaseDiscountAmount($amountDiscount+$amountPromotion);
        $address->setDiscountAmount($amountDiscount+$amountPromotion);

    }

    /**
     * Add coupon discount here to show on cart page
     *
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    { 
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $description = $quote->getCouponCode();
        if($address->getCouponDiscount() > 0 ) {
            $address->addTotal(array(
                'code'  => 'coupon_discount',
                'title' => Mage::helper('sales')->__('Coupon discount (%s)', $address->getCouponCode()),
                'value' => -$address->getCouponDiscount(),
            ));
        }
        return $this;
    }
}
