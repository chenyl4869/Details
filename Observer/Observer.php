<?php
/*

    * Observer request
     *
     * @param connector $request
     * @return ResponseInterface
     * @throws NotFoundException


*/
namespace Orderinfo\Details\Observer;

use Magento\Framework\Event\ObserverInterface;

class Observer implements ObserverInterface {

    protected $_objectManager;
    protected $_order;
    protected $_scopeConfig;

    public function __construct(
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Quote\Model\QuoteFactory $quoteFactory, \Magento\Sales\Model\Order $order) {

        $this->_objectManager = $objectManager;
        $this->_order = $order;
        $this->_scopeConfig = $scopeConfig;
        //$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
 //        try {


 //            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
 //            $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
 //            $baseurl = $storeManager->getStore()->getBaseUrl();
                  
 //            // Fetch current order detail from the event
 //            $order = $observer->getEvent()->getOrder();
 //            $orderId = $order->getId();
 //            $orderNumber = $order->getIncrementId();
 //            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/orderDetail.log');
 //            $logger = new \Zend\Log\Logger();
 //            $logger->addWriter($writer);
            
 //       //     $logger->info($orderId); 

 //            // Get object of order model to fetch order details.
 //            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
 //            $order = $objectManager->create('Magento\Sales\Model\Order')->load($orderId);
 //            $details = $order->getData();

 //            // $order_url = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/order_url');
 //            $middleware_domainName = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/domain_name');
 //            $middleware_port = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/port');
 //            $middleware_web_application_name = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/web_application_name');
 //            $companyNumber = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/company_number');
 //            $customerNumber = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/customer_number');
 //            $salesPerson = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/sales_person_number');
 //           // http://localhost:8085/webstore_integration_war_exploded/Services/magento/order/post/company/41/customer/99
 //            $order_url = $middleware_domainName . ':' . $middleware_port . '/magento/order/post/company/' . $companyNumber . '/customer/' . $customerNumber . '/sales_person/' . $salesPerson;
 //            $logger->info("20200120chen", array($order_url)); 
 //            $logger->info("============="); 

 //            $billing = $order->getBillingAddress();
 //            $billingAddress = $billing->getData();
 //            $region = $objectManager->create('Magento\Directory\Model\Region')->load($billingAddress['region_id']);
 //            $billingAddress['region_code'] = $region->getCode();
 //            // get shipping address
 //            $shipping = $order->getShippingAddress();
 //            $shippingAddress = $shipping->getData();
 //            $region = $objectManager->create('Magento\Directory\Model\Region')->load($shippingAddress['region_id']);
 //            $shippingAddress['region_code'] = $region->getCode();

 //            // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/shippingAddress.log');
 //            // $logger = new \Zend\Log\Logger();
 //            // $logger->addWriter($writer);
 //            // $logger->info($shippingAddress); 



 //            // get order items
 //            $orderItems = $order->getAllItems();
 //            // get payment details
 //            $paymentDetails = $order->getPayment()->getData();
 //            if (isset($paymentDetails['additional_information']) && is_array($paymentDetails['additional_information'])) {
 //                foreach ($paymentDetails['additional_information'] as $key => $info) {
 //                    $paymentDetails['additional_information'][$key] = str_replace('/', 'OR', $info);
 //                }
 //            }



 //            // format data to send to details to JAVA application in Camel Format 
 //            $camelFormat = $OD = $CD = $SD = $SA = $BA = $ID = $PD = $PYD = array();
 //            // start order detail
 //            $OD['sellerType'] = 'Magento';
 //            $OD['sellerDomain'] = urlencode($baseurl);
 //            $OD['orderId'] = $orderId;
 //            $OD['orderNumber'] = $orderNumber;
 //            $OD['baseCurrencyCode'] = $details['base_currency_code'];
 //            $OD['baseDiscountAmount'] = $details['base_discount_amount'];
 //            $OD['baseGrandTotal'] = $details['base_grand_total'];
 //            $OD['baseSubtotal'] = $details['base_subtotal'];
 //            $OD['baseSubtotalInclTax'] = $details['base_subtotal_incl_tax'];
 //            $OD['baseTaxAmount'] = $details['base_tax_amount'];
 //            $OD['baseTotalDue'] = $details['base_total_due'];
 //            $OD['createdAt'] = str_replace(':', '-', $details['created_at']);
 //            $OD['discountAmount'] = $details['discount_amount'];
 //            $OD['globalCurrencyCode'] = $details['global_currency_code'];
 //            $OD['grandTotal'] = $details['grand_total'];
 //            $OD['orderCurrencyCode'] = $details['order_currency_code'];
 //            $OD['state'] = $details['state'];
 //            $OD['status'] = $details['status'];
 //            $OD['storeCurrencyCode'] = $details['store_currency_code'];
 //            $OD['subtotal'] = $details['subtotal'];
 //            $OD['subtotalInclTax'] = $details['subtotal_incl_tax'];
 //            $OD['taxAmount'] = $details['tax_amount'];
 //            $OD['totalDue'] = $details['total_due'];
 //            $OD['totalItemCount'] = $details['total_item_count'];
 //            $OD['totalQtyOrdered'] = (int)$details['total_qty_ordered'];
 //            $OD['updatedAt'] = str_replace(':', '-', $details['updated_at']);
 //            $OD['weight'] = $details['weight'];
 //            $camelFormat = $OD;
 //            // end order detail
 //            // start customer detail
 //            $CD['customerEmail'] = (!empty($details['customer_email'])) ? $details['customer_email'] : 'conveyorware@chetu.com';
 //            $CD['customerFirstname'] = (!empty($details['customer_firstname'])) ? $details['customer_firstname'] : 'conveyorware';
 //            $CD['customerLastname'] = (!empty($details['customer_lastname'])) ? $details['customer_lastname'] : 'sen';
 //            $CD['customerGroupId'] = (!empty($details['customer_group_id'])) ? $details['customer_group_id'] : '1';
 //            $CD['customerId'] = (!empty($details['customer_id'])) ? $details['customer_id'] : '683859771453';
 //            $camelFormat['customerDetails'] = $CD;
 //            // end customer detail
 //            // Start of Shipping Detail
 //            $SD['baseShippingAmount'] = $details['base_shipping_amount'];
 //            $SD['baseShippingDiscountAmount'] = $details['base_shipping_discount_amount'];
 //            $SD['baseShippingDiscountTaxCompensationAmnt'] = $details['base_shipping_discount_tax_compensation_amnt'];
 //            $SD['baseShippingInclTax'] = $details['base_shipping_incl_tax'];
 //            $SD['baseShippingTaxAmount'] = $details['base_shipping_tax_amount'];
 //            $SD['shippingAmount'] = $details['shipping_amount'];
 //            $SD['shippingDescription'] = $details['shipping_description'];
 //            $SD['shippingDiscountAmount'] = $details['shipping_discount_amount'];
 //            $SD['shippingDiscountTaxCompensationAmount'] = $details['shipping_discount_tax_compensation_amount'];
 //            $SD['shippingInclTax'] = $details['shipping_incl_tax'];
 //            $SD['shippingTaxAmount'] = $details['shipping_tax_amount'];
 //            $SD['shippingTaxAmount'] = $details['shipping_tax_amount'];
 //            $SD['shippingMethod'] = $details['shipping_method'];
 //            $SD['addressType'] = 'shipping'; // here address type is shipping we can send it static because we didn't get in order details
 //            $camelFormat['shippingDetails'] = $SD;
 //            // end Shipping Detail

            

 //            if (!empty($shipping['first_name'])) {
 //                $firstname = $shipping['first_name'];
 //            } else {
 //                $firstname = 'testing';
 //            }
 //            if (!empty($shipping['last_name'])) {
 //                $lastname = $shipping['last_name'];
 //            } else {
 //                $lastname = 'testing';
 //            }
            
 //            // Start of Shipping Address
 //            $SA['addressType'] = $shippingAddress['address_type'];
 //            $SA['city'] = $shippingAddress['city'];
 //            $SA['countryId'] = $shippingAddress['country_id'];
 //            $SA['customerAddressId'] = $shippingAddress['customer_address_id'];
 //            $SA['customerAddressId'] = 1051446476861;
 //            $SA['email'] = $shippingAddress['email'];
 //            $SA['entityId'] = $shippingAddress['entity_id'];
 //            $SA['firstName'] = $shippingAddress['firstname'];
 //            $SA['lastName'] = $shippingAddress['lastname'];



 //            $SA['parentId'] = $shippingAddress['parent_id'];
 //            $SA['postcode'] = $shippingAddress['postcode'];
 //            //$SA['postcode'] = 35801;
 //            $SA['region'] = $shippingAddress['region'];
 //            //$SA['region'] = 'Alabama';
 //            $SA['regionCode'] = $shippingAddress['region_code'];
 //            $SA['regionCode'] = 'UP';
 //            $SA['regionId'] = $shippingAddress['region_id'];
 //            $SA['regionId'] = '566';

 //            $tempStreet = $shippingAddress['street'];
 //            $tempStreetArray = explode("\n",$tempStreet);

 //            $SA['street'] = preg_replace('/[^A-Za-z0-9-]/', ' ', $tempStreetArray[0]);
            
 //            $tempStreet2 = '';
 //            if(isset($tempStreetArray[1])){
 //                $tempStreet2 = preg_replace('/[^A-Za-z0-9-]/', ' ', $tempStreetArray[1]);
 //                $SA['street2'] = $tempStreet2;
 //            }else{
 //                $tempStreet2 = '';
 //            }
            
            


 //            $SA['telephone'] = $shippingAddress['telephone'];
 //            $camelFormat['shippingAddress'] = $SA;
 //            // end Shipping Detail
 //            // Start of Billing Address
 //            $BA['addressType'] = (!empty($billingAddress['address_type'])) ? $billingAddress['address_type'] : 'billing';
 //            $BA['city'] = (!empty($billingAddress['city'])) ? $billingAddress['city'] : '1';
 //            $BA['countryId'] = (!empty($billingAddress['country_id'])) ? $billingAddress['country_id'] : '1';
 //            $BA['customerAddressId'] = (!empty($billingAddress['customer_address_id'])) ? $billingAddress['customer_address_id'] : '1111';
 //            $BA['customerAddressId'] = 1018598981693;
 //            $BA['email'] = (!empty($billingAddress['email'])) ? $billingAddress['email'] : 'awdheshs@chetu.com';
 //            $BA['entityId'] = (!empty($billingAddress['entity_id'])) ? $billingAddress['entity_id'] : '1212';
 //            $BA['firstName'] = (!empty($billingAddress['firstname'])) ? $billingAddress['firstname'] : '1';
 //            $BA['lastName'] = (!empty($billingAddress['lastname'])) ? $billingAddress['lastname'] : '1';

 //            $BA['parentId'] = (!empty($billingAddress['parent_id'])) ? $billingAddress['parent_id'] : '1';
 //            $BA['postcode'] = (!empty($billingAddress['postcode'])) ? $billingAddress['postcode'] : '201301';
 //            $BA['region'] = (!empty($billingAddress['region'])) ? $billingAddress['region'] : 'Uttar pradesh';
 //            //$BA['regionCode'] = (!empty($billingAddress['region_code'])) ? $billingAddress['regionCode'] : 'UP';
 //            $BA['regionId'] = (!empty($billingAddress['regionId'])) ? $billingAddress['regionId'] : '334';
 //            $BA['street'] = preg_replace('/[^A-Za-z0-9-]/', '', $billingAddress['street']);
 //            $BA['telephone'] = (!empty($billingAddress['telephone'])) ? $billingAddress['telephone'] : '858965555';
 //            $camelFormat['billingAddress'] = $BA;
 //            // end Shipping Address
 //            // start items details
 //            foreach ($orderItems as $key => $item) {

 //                $product = $item->getData();


 //                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
 //                $appState = $objectManager->get('\Magento\Framework\App\State');

 //                $productStockObj = $objectManager->get('Magento\CatalogInventory\Api\StockRegistryInterface')->getStockItem($product['product_id']);
 //                $PD['prodcuQuantity'] = $productStockObj['qty'];


 //                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/Integer.log');
 //                $logger = new \Zend\Log\Logger();
 //                $logger->addWriter($writer);



 //                $PD['amountRefunded'] = $product['amount_refunded'];
 //                $PD['baseAmountRefunded'] = $product['base_amount_refunded'];
 //                $PD['baseDiscountInvoiced'] = $product['base_discount_invoiced'];
 //                $PD['baseOriginalPrice'] = $product['base_original_price'];
 //                $PD['basePrice'] = $product['base_price'];
 //                $PD['basePriceInclTax'] = (int)$product['base_price_incl_tax'];
 //                $PD['baseRowInvoiced'] = $product['base_row_invoiced'];
 //                $PD['baseRowTotal'] = $product['base_row_total'];
 //                $PD['baseRowTotalInclTax'] = $product['base_row_total_incl_tax'];
 //                $PD['baseTaxAmount'] = $product['base_tax_amount'];
 //                $PD['baseTaxInvoiced'] = $product['base_tax_invoiced'];
 //                $PD['createdAt'] = str_replace(':', '-', $product['created_at']);
 //                $PD['discountAmount'] = $product['discount_amount'];
 //                $PD['discountInvoiced'] = $product['discount_invoiced'];
 //                $PD['discountPercent'] = $product['discount_percent'];
 //                $PD['isQtyDecimal'] = $product['is_qty_decimal'];
 //                $PD['itemId'] = $product['item_id'];
 //                $PD['name'] = urlencode($product['name']);
 //                $PD['freeShipping'] = $product['free_shipping'];
 //                $PD['noDiscount'] = $product['no_discount'];    
 //                $PD['orderId'] = $product['order_id'];
 //                $PD['originalPrice'] = (int)$product['original_price'];
 //                $PD['price'] = (int)$product['price'];
 //                $PD['priceInclTax'] = (int)$product['price_incl_tax'];
 //                $PD['productId'] = $product['product_id'];
 //                $PD['productType'] = $product['product_type'];
 //                $PD['qtyCanceled'] = (int)$product['qty_canceled'];

 //                //$qty_canceled_int = (int)$product['qty_canceled'];


 //                $PD['qtyInvoiced'] = (int)$product['qty_invoiced'];
 //                $PD['qtyOrdered'] = (int)$product['qty_ordered'];
 //                $PD['qtyRefunded'] = (int)$product['qty_refunded'];
 //                $PD['qtyShipped'] = (int)$product['qty_shipped'];
 //                $PD['quoteItemId'] = $product['quote_item_id'];
 //                $PD['rowInvoiced'] = $product['row_invoiced'];
 //                $PD['rowTotal'] = (int)$product['row_total'];
 //                $PD['rowTotalInclTax'] = $product['row_total_incl_tax'];
 //                $PD['rowWeight'] = $product['row_weight'];
 //                $PD['sku'] = $product['sku'];
 //                $PD['storeId'] = $product['store_id'];
 //                $PD['taxAmount'] = $product['tax_amount'];
 //                $PD['taxInvoiced'] = $product['tax_invoiced'];
 //                $PD['taxPercent'] = $product['tax_percent'];
 //                $PD['updatedAt'] = str_replace(':', '-', $product['updated_at']);
 //                $PD['weight'] = $product['weight'];

 //                $ID[$key] = $PD;
 //            }
 //            $camelFormat['itemDetails'] = $ID;
 //            // end of items details
 //            // start of payment details
 //            $PYD['accountStatus'] = $paymentDetails['account_status'];
 //            $PYD['additionalInformation'] = $paymentDetails['additional_information'];
 //            $PYD['amountOrdered'] = $paymentDetails['amount_ordered'];
 //            $PYD['baseAmountOrdered'] = $paymentDetails['base_amount_ordered'];
 //            $PYD['baseShippingAmount'] = $paymentDetails['base_shipping_amount'];
 //            $PYD['entityId'] = $paymentDetails['entity_id'];
 //            $PYD['method'] = $paymentDetails['method'];
 //            $PYD['parentId'] = $paymentDetails['parent_id'];
			
 //            // end of payment details
 //            $camelFormat['paymentDetails'] = $PYD;
 //            // end of format
 //            // Send order details to JAVA application
			  
 //             $data_string = json_encode($camelFormat);
	// // echo $data_string;
	// // error_log("Hello world! Here's the order: ");
	// // error_log($data_string);		 
	// 		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/orderXML.log');
	// 		$logger = new \Zend\Log\Logger();
	// 		$logger->addWriter($writer);
	// 		$logger->info("01142020",array($data_string)); 
			 
 //            $endpoint = $order_url;
 //            $handler = curl_init();
 //            curl_setopt($handler, CURLOPT_URL, $endpoint);
 //            curl_setopt($handler, CURLOPT_POSTFIELDS, $data_string);
 //            curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
 //            curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
 //            curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
 //            $res = curl_exec($handler);

            
 //        } catch (Exception $e) {
           
 //        }
    }

}
