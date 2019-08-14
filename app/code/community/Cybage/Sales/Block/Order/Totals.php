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

class Cybage_Sales_Block_Order_Totals extends Mage_Sales_Block_Order_Totals
{
    /*
     * Created to return the discount array to display bifurcated discount coupons for EC.
     * @param $total (Object)
     * @Return $label(Array)
     */
    public function getCouponLabelValue($totals)
    {
            $discounts = array();
            if($this->getOrder()->getCouponDiscount())
            {
                $discounts['coupon_discount'] = array('label'=>Mage::helper('sales')->__('Coupon Discount (%s)', $this->getOrder()->getCouponCode()),'value'=>$this->getOrder()->getCouponDiscount());

            }
            if($this->getOrder()->getPromotionalDiscount())
            {
                $discounts['promotional_discount'] = array('label'=>$this->getOrder()->getPromoLable(),'value'=>$this->getOrder()->getPromotionalDiscount());

            }
        return $discounts;
    }
}
