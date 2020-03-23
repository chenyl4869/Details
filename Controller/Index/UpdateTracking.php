<?php

namespace Orderinfo\Details\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class UpdateTracking extends \Magento\Framework\App\Action\Action {

    protected $messageManager;
    protected $_pageFactory;

    public function __construct(
    \Magento\Framework\App\Action\Context $context, \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Framework\View\Result\PageFactory $pageFactory, array $data = []) {
        $this->messageManager = $messageManager;
        $this->pageFactory = $pageFactory;

        return parent::__construct($context);
    }

    public function execute() {

        if (!empty($this->getRequest()->getParam('OrderID'))) {

            //$TrackingNumber = 'ABCDEFGH';
            $OrderID = $this->getRequest()->getParam('OrderID');

            $TrackingNumber = $this->getRequest()->getParam('TrackingNumber');
            $OrderID = $this->getRequest()->getParam('OrderID');

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $order = $objectManager->create('\Magento\Sales\Model\Order')->load($OrderID);
            $state = 'complete';
            $status = 'complete';
            $comment = 'Order Shiped By conveyorware';
            $isNotified = true;
            $order->setState($state);
            $order->setStatus($status);
            $order->setComment($comment);
            $order->addStatusToHistory($order->getStatus(), $comment);
            $order->save();

            $orderInterface = $objectManager->get('\Magento\Sales\Api\Data\OrderInterface');
            $order = $orderInterface->load($OrderID);

            foreach ($order->getAllItems() AS $orderItem) {
           //print_r($orderItem->getData());
                if (!$orderItem->getQtyToShip() || $orderItem->getIsVirtual()) {
                    continue;
                }
            }

            $convertOrder = $objectManager->create('Magento\Sales\Model\Convert\Order');
            $shipment = $convertOrder->toShipment($order);
            $qtyShipped = $orderItem->getQtyToShip();
            // print_r($shipment->getData());
            $data = array(
                'carrier_code' => 'ups',
                'title' => 'United Parcel Service',
                'number' => $TrackingNumber, // Replace with your tracking number
            );

            $track = $objectManager->create('Magento\Sales\Model\Order\Shipment\TrackFactory')->create()->addData($data);
            $shipmentItem = $shipment->addTrack($track);
            $shipmentItem = $convertOrder->itemToShipmentItem($orderItem)->setQty($qtyShipped);
            // Add shipment item to shipment
            $shipment->addItem($shipmentItem);
            $shipment->register();
            $shipment->getOrder()->setIsInProcess(true);
            $shipment->save();
            $shipment->getOrder()->save();
            //echo "Tracking Number Update Succesfully";
        } else {
            //echo "Please Enter valid URl";
        }
    }

}
