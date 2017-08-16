<?php

namespace Inchoo\MenuItem\Controller\Adminhtml\Sample;

use Magento\Framework\Controller\ResultFactory;

class Delete extends \Magento\Backend\App\Action {

    protected $_fileFactory;
    protected $_response;
    protected $_view;
    protected $directory;
    protected $converter;
    protected $resultPageFactory;
    protected $directory_list;
    protected $_messageManager;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_messageManager = $context->getMessageManager();
        parent::__construct($context);
    }

    public function execute() {

        $id = $this->getRequest()->getParam('code_id');

        $this->_response = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
        $connection = $this->_response->getConnection();
        $themeTable = $this->_response->getTableName('activation_code');
        $sql = "DELETE FROM " . $themeTable . " WHERE id=$id";

        try {
            $connection->query($sql);
            $message = 'Activation code has been deleted successfully';
            $this->_messageManager->addSuccess($message);
        } catch (Exception $e) {
            $this->_messageManager->addError($e);
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('menuitem/importcsv/index');
        return $resultRedirect;
    }

}