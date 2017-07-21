<?php
namespace Brainium\MobileProduct\Block;
class MobileProduct extends \Magento\Framework\View\Element\Template
{    
    protected $_categoryFactory;
        
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    )
    {    
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }
    
    public function getCategory($categoryId) 
    {
        $category = $this->_categoryFactory->create();
        $category->load($categoryId);
        return $category;
    }
    
    public function getCategoryProducts($categoryId) 
    {
        $products = $this->getCategory($categoryId)->getProductCollection();
        $products->addAttributeToSelect('*');
        return $products;
    }
}
?>
