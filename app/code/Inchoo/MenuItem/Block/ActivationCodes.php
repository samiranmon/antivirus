<?php

namespace Inchoo\MenuItem\Block;

class ActivationCodes extends \Magento\Framework\View\Element\Template {

    protected $_productCollectionFactory;

    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getHelloWorldTxt() {
        return 'Product activation codes';
    }

    public function getProductCollection() {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter(
                [
                    //['attribute'=>'type_id','neq'=> 'simple'],
                        ['attribute' => 'type_id', 'eq' => 'downloadable'],
                //['attribute'=>'color','eq'=> 4] // Color filter
                ]
        );
        //$collection->setPageSize(20); // fetching only 3 products
        return $collection;
    }

    public function getCsvCollection() {
        
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter(
                [
                    //['attribute'=>'type_id','neq'=> 'simple'],
                        ['attribute' => 'type_id', 'eq' => 'downloadable'],
                //['attribute'=>'color','eq'=> 4] // Color filter
                ]
        );
        //$collection->setPageSize(20); // fetching only 3 products
        //return $collection;

        $data = "";

        $data .= "SKU,Activation Code,Date/Time,Status,Order No (for Activation Code Sold ),Uploaded By" . "\n";

        foreach ($collection as $product) {
            $stock_status = $product->getQuantity_and_stock_status() > 0 ? 'Available' : 'Sold';

            $data .= $product->getSku() . "," . $product->getActivationcode() . "," . $product->getCreated_at() . ","
                    . $stock_status . "," . $this->getOrderId($product->getId()) . ",Admin" . "\n";
        }
        return $data;
    }

    public function getOrderId($_productId = null) {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Inchoo\MenuItem\Model\OrderCollection');
        $_orders = $model->getOrderCollection();

        if ($_orders && count($_orders)) {
            foreach ($_orders as $_order) {
                $items = $_order->getAllVisibleItems();
                foreach ($items as $item) {
                    //$item->getSku();
                    if ($item->getProductId() == $_productId) {
                        return $_order->getIncrementId();
                        break;
                    } else {
                        return null;
                        break;
                    }
                }
            }
        }
        return null;
    }

}
