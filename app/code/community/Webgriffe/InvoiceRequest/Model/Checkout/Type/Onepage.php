<?php

/**
 * Created by PhpStorm.
 * User: manuele
 * Date: 29/10/15
 * Time: 14:23
 */
class Webgriffe_InvoiceRequest_Model_Checkout_Type_Onepage extends Mage_Checkout_Model_Type_Onepage
{
    const FIELD_NAME = 'invoice_request';

    /**
     * Save billing address information to quote
     * This method is called by One Page Checkout JS (AJAX) while saving the billing information.
     *
     * @param   array $data
     * @param   int $customerAddressId
     * @return  Mage_Checkout_Model_Type_Onepage
     */
    public function saveBilling($data, $customerAddressId)
    {
        $this->getQuote()->setInvoiceRequest(false);
        if (isset($data[self::FIELD_NAME]) && $data[self::FIELD_NAME]) {
            if (!empty($customerAddressId)) {
                $customerAddress = Mage::getModel('customer/address')->load($customerAddressId);
            } else {
                /* @var $addressForm Mage_Customer_Model_Form */
                $addressForm = Mage::getModel('customer/form');
                $addressForm->setFormCode('customer_address_edit')
                    ->setEntityType('customer_address')
                    ->setIsAjaxRequest(Mage::app()->getRequest()->isAjax());
                $customerAddress = Mage::getModel('customer/address');
                $addressForm->setEntity($customerAddress);
                $addressData = $addressForm->extractData($addressForm->prepareRequest($data));
                $addressForm->compactData($addressData);
            }
            $companyDataMandatory = (bool)$customerAddress->getIsBusinessAddress();
            $taxCode = $customerAddress->getTaxCode();
            $vatNumber = $customerAddress->getVatNumber();
            $company = $customerAddress->getCompany();

            $fixMessage = Mage::helper('webgriffe_invoicerequest')->__(
                'Please, add the required information and come back to checkout to complete the purchase.'
            );
            if (!$taxCode) {
                $message = Mage::helper('webgriffe_invoicerequest')->__(
                    'Warning, to receive the invoice on the selected address you have to enter the Tax Code in the ' .
                    '"My Account / Default billing address" section.'
                );
                return array(
                    'error' => 1,
                    'message' => $message . ' ' . $fixMessage,
                );
            }
            if ($companyDataMandatory && !$company) {
                $message = Mage::helper('webgriffe_invoicerequest')->__(
                    'Warning, to receive the invoice on the selected address you have to enter the Company Name in ' .
                    'the "My Account / Default billing address" section.'
                );
                return array(
                    'error' => 1,
                    'message' => $message . ' ' . $fixMessage
                );
            }
            if ($companyDataMandatory && !$vatNumber) {
                $message = Mage::helper('webgriffe_invoicerequest')->__(
                    'Warning, to receive the invoice on the selected address you have to enter the VAT Number in the ' .
                    '"My Account / Default billing address" section.'
                );
                return array(
                    'error' => 1,
                    'message' => $message . ' ' . $fixMessage
                );
            }

            $this->getQuote()->setInvoiceRequest(true);
        }
        return parent::saveBilling($data, $customerAddressId);
    }
}
