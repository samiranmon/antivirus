<?php
 
namespace YourCompany\YourModule\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;

class HelloWorld implements ObserverInterface {

 protected $_order;
 protected $_response;
    public function __construct(
        \Magento\Sales\Api\Data\OrderInterface $order
    ) {
         $this->_order = $order;    
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
		$objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
		$connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION'); 
	
      $orderids = $observer->getEvent()->getOrderIds();
	  $order = $this->_order->load($orderids);

        //get Order All Item
       // $itemCollection = $order->getItemsCollection();
       $items = $order->getAllItems();
	   //print_r($items);
	   $ProdustSku = [];
	  foreach ($order->getAllItems() as $item) {
            $ProdustIds[] = $item->getProductId(); 
			$proName[] = $item->getName(); //product name
			$ProdustSku = $item->getSku();
			
			
          $result1 = $connection->fetchAll("SELECT * FROM activation_code where `status` =1 and `sku`='$ProdustSku' ORDER BY id DESC LIMIT 0,1");
		   
		  if(!empty($result1)) {
			  
			  foreach($result1 as $val) {
				
				  // product activation code update
				  
				 $product = $objectManager->create('Magento\Catalog\Model\Product')->load($item->getProductId());
				 //$product->setData('activationcode', $val['activation_code']); 
				 
				 $product->setData('activationcode', $val['activation_code']); //$value = 1 for yes and $value = 0 for No.
				 $product->getResource()->saveAttribute($product, 'activationcode');
                                 
                                 // for update price
                                 $product->setData('price', $val['price']); //$value = 1 for yes and $value = 0 for No.
				 $product->getResource()->saveAttribute($product, 'price');
				 
				 //$prodcut->setActivationcode($val['activation_code']); $prodcut->save();
				  
				   
				  
				// update status activation table 
					$sql = "UPDATE activation_code SET status=0 WHERE id=".$val['id']; 
					$connection->query($sql);
				  
				 //echo $sql; die; 
				  
				  
				  
			  }
		  } 
		  
		  
        }
		
		 

		
    }


}