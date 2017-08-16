<?php
namespace Inchoo\MenuItem\Controller\Adminhtml\ImportCsv;
 
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
 
class Index extends \Magento\Backend\App\Action
{
    
     /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        
        
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Inchoo_MenuItem::importcsv');
        $resultPage->addBreadcrumb(__('Activation codes'), __('Activation codes'));
        $resultPage->addBreadcrumb(__('View activation codes'), __('View activation codes'));
        $resultPage->getConfig()->getTitle()->prepend(__('Import activation codes'));

        return $resultPage;
    }

    /**
     * Is the user allowed to view the blog post grid.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Inchoo_MenuItem::importcsv');
    }
    
}