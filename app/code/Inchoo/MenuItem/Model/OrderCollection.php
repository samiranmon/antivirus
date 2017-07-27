<?php

namespace Inchoo\MenuItem\Model;

/**
 * Pay In Store payment method model
 */
class OrderCollection extends \Magento\Framework\View\Element\Template {

    protected $_orderCollectionFactory;
    protected $orders;

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context, 
            \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
            array $data = []
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getOrderCollection() {

        if (!$this->orders) {
            $this->orders = $this->_orderCollectionFactory->create()->addFieldToSelect('*');
            
            $this->orders->addFieldToFilter(
                    //'status', ['in' => 'Complete,Processing,Pending']
                    'status', ['in' => 'Complete']
            );
            
            //$this->orders->addFieldToFilter("product_id", array("eq" => 52));
            //$this->orders->addAttributeToFilter('product_id', array('eq' => 52));
            
            $this->orders->setOrder(
                    'created_at', 'desc'
            );
        }
        return $this->orders;
    }
    
    public function getName() {
        return 'Dam ';
    }

}
