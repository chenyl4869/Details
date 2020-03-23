<?php

namespace Orderinfo\Details\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class UpdateCustomer extends \Magento\Framework\App\Action\Action {


    protected $authSession;

    public function __construct( 
	\Magento\Framework\App\Action\Context $context, 
	\Magento\Backend\Model\Auth\Session $authSession, 
	array $data = []) {
	
     $this->authSession = $authSession;  

    return parent::__construct($context);
    }

    public function execute() {

	print_r($this->authSession->getUser());
	//die;
     
    }

}
