<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * UpdateInventory controller
 *
 * @method array execute()

 * @api
 * @since 100.0.2
 */

namespace Orderinfo\Details\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class UpdateInventory extends \Magento\Framework\App\Action\Action
{
    
	protected $messageManager; 
    protected $_pageFactory;
	 
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		array $data = []) 
	 {
	    $this->messageManager = $messageManager;
		$this->pageFactory = $pageFactory;
		
		return parent::__construct($context);
	}
	
   

  public function execute()
  {
  
   
     $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 

     $pass = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/password');
	 $user_name = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('conveyorware/active_display/user_name');	
	
	
	if(!empty($this->getRequest()->getParam('sku'))){
	
	$updateData = $this->getRequest()->getParam('sku');
	// $updateData = json_decode($updateData);
	$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
	/**
	* ObjectManager for Message
	*/
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$_messageManager = $objectManager->create('\Magento\Framework\Message\ManagerInterface');
	
	$userData = array("username" =>$user_name, "password" =>$pass);
	
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
	 $baseurl = $storeManager->getStore()->getBaseUrl();
	  
	 	  
  
	$endpoint = $baseurl."index.php/rest/V1/integration/admin/token";
	$requestBody = $userData;
	$handler = curl_init();
	curl_setopt($handler, CURLOPT_URL, $endpoint);
	curl_setopt($handler, CURLOPT_POSTFIELDS, $requestBody);
	curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	 $token = curl_exec($handler);  
	 $token = str_replace('"','',$token);
	
	
	$endpoint = $baseurl."index.php/rest/V1/products";
	$handler = curl_init();
	curl_setopt($handler, CURLOPT_URL, $endpoint);
	curl_setopt($handler, CURLOPT_POSTFIELDS, $updateData);
	curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($handler, CURLOPT_HTTPHEADER, array("Content-type: application/json",'Authorization: Bearer '.$token));
	curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
	$res = curl_exec($handler);
	// echo "update product succesfully";
  }else{
	
	//echo "Please Enter valid URl";
	
	}
	
	
	
	}
	
}