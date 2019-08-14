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

class Mage_Adminhtml_Block_Sales_Totals extends Mage_Sales_Block_Order_Totals
{
    /**
     * Format total value based on order currency
     *
     * @param   Varien_Object $total
     * @return  string
     */
    public function formatValue($total)
    {
        if (!$total->getIsFormated()) {
            return $this->helper('adminhtml/sales')->displayPrices(
                $this->getOrder(),
                $total->getBaseValue(),
                $total->getValue()
            );
        }
        return $total->getValue();
    }

    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
        $this->_totals = array();
        $this->_totals['subtotal'] = new Varien_Object(array(
            'code'      => 'subtotal',
            'value'     => $this->getSource()->getSubtotal(),
            'base_value'=> $this->getSource()->getBaseSubtotal(),
            'label'     => $this->helper('sales')->__('Subtotal')
        ));

        /**
         * Add shipping
         */
        if (!$this->getSource()->getIsVirtual() && ((float) $this->getSource()->getShippingAmount() || $this->getSource()->getShippingDescription()))
        {
            $this->_totals['shipping'] = new Varien_Object(array(
                'code'      => 'shipping',
                'value'     => $this->getSource()->getShippingAmount(),
                'base_value'=> $this->getSource()->getBaseShippingAmount(),
                'label' => $this->helper('sales')->__('Shipping & Handling')
            ));
        }

        /**
         * Add discount
         */
        if (((float)$this->getSource()->getDiscountAmount()) != 0) {
            if ($this->getSource()->getDiscountDescription()) {
                $discountLabel = $this->helper('sales')->__('Discount (%s)', $this->getSource()->getCouponCode());
            } else {
                $discountLabel = $this->helper('sales')->__('Discount');
            }
            $this->_totals['discount'] = new Varien_Object(array(
                'code'      => 'discount',
                'value'     => $this->getSource()->getDiscountAmount(),
                'base_value'=> $this->getSource()->getBaseDiscountAmount(),
                'label'     => $discountLabel
            ));
        }

        /**
         * Add Coupon discount
         */
        if (((float)$this->getSource()->getCouponDiscount()) != 0) {

            if ($this->getSource()->getCouponCode()) {
                $discountLabel = $this->helper('sales')->__('Coupon Discount (%s)', $this->getSource()->getCouponCode());
            } else {
                $discountLabel = $this->helper('sales')->__('Coupon Discount');
            }
            $this->_totals['coupon_discount'] = new Varien_Object(array(
                'code'      => 'coupon_discount',
                'value'     => "-".$this->getSource()->getCouponDiscount(),
                'base_value'=>  "-".$this->getSource()->getCouponDiscount(),
                'label'     => $discountLabel
            ));
        }

        /**
         * Add Promotional discount
         */
        if (((float)$this->getSource()->getPromotionalDiscount()) != 0) {

            if ($this->getSource()->getPromoLable()) {
                $discountLabel = $this->getSource()->getPromoLable();
            } else {
                $discountLabel = $this->getSource()->getPromoLable();
            }
            $this->_totals['promotional_discount'] = new Varien_Object(array(
                'code'      => 'promotional_discount',
                'value'     =>  "-".$this->getSource()->getPromotionalDiscount(),
                'base_value'=>  "-".$this->getSource()->getPromotionalDiscount(),
                'label'     => $discountLabel
            ));
        }

        $this->_totals['grand_total'] = new Varien_Object(array(
            'code'      => 'grand_total',
            'strong'    => true,
            'value'     => $this->getSource()->getGrandTotal(),
            'base_value'=> $this->getSource()->getBaseGrandTotal(),
            'label'     => $this->helper('sales')->__('Grand Total'),
            'area'      => 'footer'
        ));

        return $this;
    }
}
