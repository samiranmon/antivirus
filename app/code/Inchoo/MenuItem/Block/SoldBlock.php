<?php

namespace Inchoo\MenuItem\Block;

class SoldBlock extends \Magento\Framework\View\Element\Template {

    protected $_orderCollectionFactory;
    protected $orders;

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory, array $data = []
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getHelloWorldTxt1() {
        return 'Sold Activation codes';
    }

    public function getOrderCollection() {

        if (!$this->orders) {
            $this->orders = $this->_orderCollectionFactory->create()->addFieldToSelect('*');
            
            $this->orders->addFieldToFilter(
                    //'status', ['in' => 'Complete,Processing,Pending']
                    'status', ['in' => 'Complete']
            );
            
            $this->orders->setOrder(
                    'created_at', 'desc'
            );
        }
        return $this->orders;
    }
    
    
    public function getCsvCollection() {
        
        if (!$this->orders) {
            $this->orders = $this->_orderCollectionFactory->create()->addFieldToSelect('*');
            
            $this->orders->addFieldToFilter(
                    //'status', ['in' => 'Complete,Processing,Pending']
                    'status', ['in' => 'Complete']
            );
            
            $this->orders->setOrder(
                    'created_at', 'desc'
            );
        }
        $collection = $this->orders;
         
        $data = "";
        $data .= "Order No,Date/time,Client Names,Client mobile no,Client email,SKU,Activation Code,Sms status,Email status". "\n";
        if ($collection && count($collection)) {
            foreach ($collection as $_order) {
                
                $items = $_order->getAllVisibleItems();
                    foreach ($items as $item) {
                         $_productId = $item->getProductId();
                         $_sku = $item->getSku();

                        // for get activation code
                        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                        $product = $objectManager->get('Magento\Catalog\Model\Product')->load($_productId);
                        $_activationCode = $product->getActivationcode();
                    }
                        $send_email = $_order->getSendEmail()==1?'Yes':'No';

                  $data .= $_order->getIncrementId().",".$_order->getCreatedAt().",".$_order->getCustomerFirstname().' '.$_order->getCustomerLastname().","
                  .$this->getTelephone($_order->getCustomerId()).",".$_order->getCustomerEmail().","
                  .$_sku.",".$_activationCode.",".$send_email.",".$send_email."\n";

            }  
        }
        return $data; 
        
    }
    
    public function getTelephone($customerId = NULL) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerObj = $objectManager->create('Magento\Customer\Model\Customer')->load($customerId);
        $customerAddress = array();

        foreach ($customerObj->getAddresses() as $address) {
            $customerAddress[] = $address->toArray();
        }
        $_telephone = '';
        foreach ($customerAddress as $customerAddres) {
            $_telephone = $customerAddres['telephone'];
        }
        return $_telephone;
    }



}
