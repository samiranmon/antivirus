<?php
 
namespace VendoreName\ModuleName\Observer;
 
use Magento\Framework\ObjectManager\ObjectManager;
 
class AfterplaceOrder implements \Magento\Framework\Event\ObserverInterface {
 
    /** @var \Magento\Framework\Logger\Monolog */
    protected $_logger;
    
    /**
     * @var \Magento\Framework\ObjectManager\ObjectManager
     */
    protected $_objectManager;
    
    protected $_orderFactory;    
    protected $_checkoutSession;
    
    public function __construct(        
        \Psr\Log\LoggerInterface $loggerInterface,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\ObjectManager\ObjectManager $objectManager
    ) {
        $this->_logger = $loggerInterface;
        $this->_objectManager = $objectManager;        
        $this->_orderFactory = $orderFactory;
        $this->_checkoutSession = $checkoutSession;        
    }
 
    /**
     * This is the method that fires when the event runs.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer ) {        
        
        $orderIds = $observer->getEvent()->getOrderIds();
        $email="aneel.brainium@gmail.com";
			mail($email,"hii",'teliphone');
		
        if (count($orderIds)) {
            $orderId = $orderIds[0];            
            $order = $this->_orderFactory->create()->load($orderId);
            $shippingAddress = $order->getShippingAddress();
            $email="aneel.brainium@gmail.com";
			mail($email,"hii",'teliphone');

 
            // do something
            // your code goes here
            
            //$this->logger->debug('Logging HelloWorld Observer');            
        }
    }
}
