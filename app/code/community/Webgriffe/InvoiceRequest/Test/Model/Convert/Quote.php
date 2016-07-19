<?php

/**
 * Created by PhpStorm.
 * User: manuele
 * Date: 29/10/15
 * Time: 11:19
 */
class Webgriffe_InvoiceRequest_Test_Model_Convert_Quote extends EcomDev_PHPUnit_Test_Case
{
    public function testConvertQuoteToOrderShouldCopyInvoiceRequestFlag()
    {
        $quote = Mage::getModel('sales/quote');
        $quote->setInvoiceRequest(1);
        $quote->getPayment()->setMethod('cashondelivery');
        $convertQuote = Mage::getSingleton('sales/convert_quote');
        $order = $convertQuote->toOrder($quote);
        $this->assertEquals(1, $order->getInvoiceRequest());

        $quote->setInvoiceRequest(0);
        $order = $convertQuote->toOrder($quote);
        $this->assertEquals(0, $order->getInvoiceRequest());
    }
}
