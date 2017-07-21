<?php

namespace Inchoo\MenuItem\Controller\Adminhtml\Sample;

class ExportCsv extends \Magento\Backend\App\Action {

    protected $_fileFactory;
    protected $_response;
    protected $_view;
    protected $directory;
    protected $converter;
    protected $resultPageFactory;
    protected $directory_list;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute() {
        $fileName = 'product-activation-codes.csv';
        $resultPage = $this->resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Inchoo\MenuItem\Block\ActivationCodes')->getCsvCollection();
        
        //echo $content; die();
        
        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') {

        $this->_response->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', strlen($content), true)
                ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"', true)
                ->setHeader('Last-Modified', date('r'), true)
                ->setBody($content)
                ->sendResponse();
        die();
    }

}
