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

class Cybage_Checkout_Model_Observer extends Varien_Event_Observer
{
    const COUPON_TYPE_FUE_GENERATED   = 2;

    /*
     * function to bifurcate coupons
     * @param object
     * @author srinidhid<srinidhid@cybage.com>
     */
    public function discountBifurcation(Varien_Event_Observer $observer)
    {
        $rule = $observer->getEvent()->getRule();
        $result = $observer->getEvent()->getResult();
        $itemId = $observer->getEvent()->getItem()->getItemId();
        //set Unique key
        $curUnique=  $rule->getRuleId().'_'.$itemId;
        //check if Mage registry unique call set
        if(Mage::registry('uniqueCall')!==null){
            //if check in array
            $uniqueCalls = Mage::registry('uniqueCall');
            if(  in_array($curUnique,$uniqueCalls)){
                return;
            }else{
                //unset existing registry. also take existing array in variable
                Mage::unregister('uniqueCall');
                $uniqueCalls[]=  $curUnique ;
                //set registry again with new array include $uniqueCall into it
                Mage::register('uniqueCall',$uniqueCalls);
            }
        }else{
            //set registry again with new array include $uniqueCall into it
            $array = array();
            $array[]=$rule->getRuleId().'_'.$itemId;
            Mage::register('uniqueCall',$array);

        }        

        //condition for the Promotional coupons
        if ( $rule->getCouponType() == Mage_SalesRule_Model_Rule::COUPON_TYPE_NO_COUPON ) {
                $promotionDiscount = 0;
                $promotionDiscount = Mage::registry('promotion');
                if (Mage::registry('promotion')!==null){
                    Mage::unregister('promotion');
                }
                if (Mage::registry('promo_lable')!==null){
                    Mage::unregister('promo_lable');
                }
                $promotionDiscount += $result->getDiscountAmount();
                Mage::register('promotion', $promotionDiscount);
                Mage::register('promo_lable',$rule->getName());
        } elseif ( $rule->getCouponType() == self::COUPON_TYPE_FUE_GENERATED ) {
            $couponDiscount = 0;
            $couponDiscount = Mage::registry('coupon');
            if(Mage::registry('coupon')!==null){
                Mage::unregister('coupon');
            }
            //sum up all the values of discounted coupons
            $couponDiscount += $result->getDiscountAmount();
            Mage::register('coupon',$couponDiscount);
        }
        $quote = $observer->getEvent()->getQuote();
        $quoteAddress = $observer->getEvent()->getAddress();
        //set discounted coupons and promotional coupons amount in quote
        $quote->setCouponDiscount(Mage::registry('coupon'));
        $quote->setPromotionalDiscount(Mage::registry('promotion'));

        if (Mage::getStoreConfig('promodiscount/promodiscount/use_default')) {
            $quote->setPromoLable(Mage::getStoreConfig('promodiscount/promodiscount/default_lable'));
        } else {
            if (Mage::registry('promo_lable')) {
                $quote->setPromoLable(Mage::registry('promo_lable'));
            } else {
                $quote->setPromoLable(Mage::getStoreConfig('promodiscount/promodiscount/default_lable'));
            }
        }
        
        $quoteAddress->setCouponDiscount(Mage::registry('coupon'));
        $quoteAddress->setPromotionalDiscount(Mage::registry('promotion'));
        if (Mage::registry('promo_lable')) {
            $quoteAddress->setPromoLable(Mage::registry('promo_lable'));
        } else {
            $quoteAddress->setPromoLable(Mage::getStoreConfig('promodiscount/promodiscount/default_lable'));
        }
    }
}