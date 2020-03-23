<?php



/**
 * Copyright � Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * get inventory controller
 *
 * @method array execute()

 * @api
 * @since 100.0.2
 */

namespace Orderinfo\Details\Controller\Index;


use Magento\Framework\Controller\ResultFactory;


class Index extends \Magento\Framework\App\Action\Action {

    protected $_productloader;
    protected $messageManager;
    protected $_pageFactory;
    protected $_logger;
    public function __construct(
    \Magento\Framework\App\Action\Context $context, \Magento\Framework\Message\ManagerInterface $_messageManager, \Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Catalog\Model\ProductFactory $_productloader, 
        \Psr\Log\LoggerInterface $logger //log injection
    ) {


        $this->_productloader = $_productloader;
        $this->messageManager = $_messageManager;
        $this->pageFactory = $pageFactory;
        $this->_logger = $logger;
        return parent::__construct($context);   
    }

    public function execute() 
	{

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $password = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/password');
        $userName = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/user_name');
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        /**
         * ObjectManager for Message
         */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        //$messageManager = $objectManager->create('\Magento\Framework\Message\ManagerInterface');
        $userData = array("username" => $userName, "password" => $password);
		
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $baseurl = $storeManager->getStore()->getBaseUrl();
    
        $endpoint = $baseurl . "index.php/rest/V1/integration/admin/token";
        $requestBody = $userData;
        $handler = curl_init();
        curl_setopt($handler, CURLOPT_URL, $endpoint);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $token = curl_exec($handler);
        $token = str_replace('"', '', $token);

        // get inventory data 
        // $inventory_url = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/inventory_url');
        // getting company number and warehouse number from database(table "core_config_data")
        $cwusername = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/cw_username');
        $companyNumber = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/company_number');
        $warehouseNumber = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/warehouse_number');
        $middleware_domainName = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/domain_name');
        $middleware_port = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/port');
        $middleware_web_application_name = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/web_application_name');
        // $domainName = "http://localhost:8085";
        // $inventory_url = $domainName.'/webstore_integration_war_exploded/Services/magento/order/getInventory/CWUser/' . $cwusername . '/company/'.$companyNumber.'/warehouse/'.$warehouseNumber;

        $inventory_url = $middleware_domainName . ':' . $middleware_port . '/magento/order/getInventory/CWUser/' . $cwusername . '/company/' . $companyNumber . '/warehouse/' . $warehouseNumber;

        $this->_logger->info("chen01092020", array($inventory_url));
        //$this->_logger->info("chen01092020", array(__FILE__));
        // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/inventory_data.log');
        // $logger = new \Zend\Log\Logger();
        // $logger->addWriter($writer);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $inventory_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $output = curl_exec($ch);

        $inventory_data = json_decode($output);
        $i = 0;
        


        if (count($inventory_data) > 0 && !isset($inventory_data->InventoryFileRespond)) {
            foreach ($inventory_data as $keys => $data) {
                //foreach ($data->InventoryRecord as $key => $value) {

			        if (count($data) > 0) {
				   foreach ($data->InventoryRecord as $Inventorykey => $InventoryData) {
			   
			 
			   
                            if (count($InventoryData) > 0) {
                                // its taking too much time when we deploy on server then remove this 20 limit code code 
                                // if ($i > 50) { 
                                if (isset($InventoryData->Cost)) {
                                    $cost = $InventoryData->Cost;
                                } else {
                                    $cost = '0';
                                }



                                $ch = curl_init($baseurl . "/index.php/rest/V1/products");
                                $userData = array('product' =>
                                    array('sku' => $InventoryData->StockNumber,
                                        'name' => $InventoryData->ItemDescription,
                                        'attribute_set_id' => 4,
                                        'price' => $cost,
                                        'status' => 1,
                                        'visibility' => 4,
                                        'type_id' => 'simple',
                                        'weight' => $InventoryData->Weight,
                                        // 'custom_attributes' =>
                                        // array('attribute_code' => 'description',
                                        //     'value' => $InventoryData->ItemDescription
                                        // ),
                                        'extension_attributes' =>
                                        array('stock_item' =>
                                            array('qty' => $InventoryData->Available, 'is_in_stock' => 1)
                                        )
                                    )
                                );
                                // request_data22 {"product":{"sku":"A","name":"TEST AAA","attribute_set_id":4,"price":10,"status":1,"visibility":4,"type_id":"simple","weight":2,"extension_attributes":{"stock_item":{"qty":504,"is_in_stock":1}}}} []
                                //$this->_logger->info("request_data22", $userData);
                                $requestBody = json_encode($userData);
                                $endpoint = $baseurl . "index.php/rest/V1/products";
                                $handler = curl_init();
                                curl_setopt($handler, CURLOPT_URL, $endpoint);
                                curl_setopt($handler, CURLOPT_POSTFIELDS, $requestBody);
                                curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
                                curl_setopt($handler, CURLOPT_HTTPHEADER, array("Content-type: application/json", 'Authorization: Bearer ' . $token));
                                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                                $res = curl_exec($handler);
                                /* } else {
                                  $this->messageManager->addSuccess(__('We can\�t process your request right now.'));
                                  $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                                  return $resultRedirect;
                                  } */
                                $i++;
                            }
                        }
                    } else {
                        $this->messageManager->addSuccess(__('We can\�t process your request right now.'));
                        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                        return $resultRedirect;
                    }
                           }
        } else {
            $this->_logger->info("chen12172019_52", array());
            //$this->messageManager->addSuccess(__('We can\�t process your request right now.'));
            $this->messageManager->addError(__("Error"));
            //$resultRedirect->setUrl($baseurl);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
        $this->_logger->info("chen12172019_62", array());
        $this->messageManager->addSuccess(__('We can\�t process your request right now.'));
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

}
