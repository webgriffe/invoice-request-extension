<?php

/**
 * Created by PhpStorm.
 * User: manuele
 * Date: 29/10/15
 * Time: 12:37
 */
class Webgriffe_InvoiceRequest_Block_InvoiceRequest extends Mage_Core_Block_Template
{
    const FIELD_ID = 'billing-invoice-request';

    public function getFieldId()
    {
        return self::FIELD_ID;
    }

    public function getFieldName()
    {
        return 'billing[' . Webgriffe_InvoiceRequest_Model_Checkout_Type_Onepage::FIELD_NAME . ']';
    }

    public function isInvoiceRequest()
    {
        $quote = Mage::getSingleton('checkout/session')->getQuote();
        return (bool)$quote->getInvoiceRequest();
    }
}
