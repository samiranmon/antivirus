<?php

namespace Inchoo\MenuItem\Block;

class ImportCodes extends \Magento\Framework\View\Element\Template {

    protected $_modelFactory;
    
    public function __construct( \Magento\Backend\Block\Template\Context $context,  
 \Inchoo\MenuItem\Model\ActivationCodeFactory $modelFactory, array $data = array() ) {
        
        parent::__construct($context, $data);
        $this->_modelFactory = $modelFactory;
    }

 

    public function getCollection(){
        
        //var_dump($this->_modelFactory);
        
        //die;
        
        return $this->_modelFactory->create()->getCollection();
    }
     
    
    public function getHelloWorldTxt() {
        return 'import';
    }
 

}
