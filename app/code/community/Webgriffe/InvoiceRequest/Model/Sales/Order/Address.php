<?php

/**
 * Created by PhpStorm.
 * User: manuele
 * Date: 02/11/15
 * Time: 15:57
 */
class Webgriffe_InvoiceRequest_Model_Sales_Order_Address extends Mage_Sales_Model_Order_Address
{
    public function format($type)
    {
        $formattedAddress = parent::format($type);
        if (!Mage::app()->getStore()->isAdmin()) {
            return $formattedAddress;
        }

        if ($this->getAddressType() !== Mage_Sales_Model_Order_Address::TYPE_BILLING) {
            return $formattedAddress;
        }

        $requestedStatus = 'No';
        if ($this->getOrder() && $this->getOrder()->getInvoiceRequest()) {
            $requestedStatus = 'Yes';
        }

        $helper = Mage::helper('webgriffe_invoicerequest');
        $message = $helper->__('Invoice Requested') . ': ' . $helper->__($requestedStatus);
        $message = '<h3>' . $message . '</h3>';
        return $message . $formattedAddress;
    }
}
