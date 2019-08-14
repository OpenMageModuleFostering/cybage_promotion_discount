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

class Cybage_SalesRule_Model_Quote_Discount extends Mage_SalesRule_Model_Quote_Discount
{ 
    public function getCustomDiscountRenderer()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if($quote->getCouponDiscount() || $quote->getPromotionalDiscount())
        {
            return true;
        }
    }
    
    public function getDiscountTitle($title){
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        switch($title){
            case "coupon":
                $description = $quote->getCouponCode();
                $title = Mage::helper('sales')->__('Coupon Discount (%s)', $description);
                break;
             case "promotional":
                 $title = $quote->getPromoLable();
                 break;
        }
        return $title;
    }
    
    /**
     * Add discount total information to address
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_SalesRule_Model_Quote_Discount
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $amount = $address->getDiscountAmount();
        $amountdiscount = $address->getCouponDiscount();
        $amountpro = $address->getPromotionalDiscount();

        $quote = Mage::getSingleton('checkout/session')->getQuote();
        if ($amount != 0) {
            if($this->getCustomDiscountRenderer()) {
                
                if($this->getDiscountTitle('promotional')) {
                    $address->addTotal(array(
                    'code'  => $this->getCode(),
                    'title' => $address->getPromoLable(),
                    'value' => $amountpro
                    ));
                }
            } else {
               $description = $quote->getCouponCode();
                if (strlen($description)) {
                    $title = Mage::helper('sales')->__('Discount (%s)', $description);
                } else {
                    $title = Mage::helper('sales')->__('Discount');
                }
                $address->addTotal(array(
                    'code'  => $this->getCode(),
                    'title' => $title,
                    'value' => $amount
                ));
           }
        }
        return $this;
    }
}
