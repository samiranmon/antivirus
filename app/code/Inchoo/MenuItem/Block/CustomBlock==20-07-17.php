<?php

namespace Inchoo\MenuItem\Block;

class CustomBlock extends \Magento\Framework\View\Element\Template {

    protected $_productCollectionFactory;

    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getHelloWorldTxt1() {
        return 'Sold Activation codes';
    }

    public function getProductCollection() {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(20); // fetching only 3 products
        return $collection;
    }

}
