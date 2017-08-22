<?php

namespace Inchoo\MenuItem\Controller\Adminhtml\Sample;
use Magento\Framework\Controller\ResultFactory;

class ImportCsv extends \Magento\Backend\App\Action {

    protected $_fileFactory;
    protected $_response;
    protected $_view;
    protected $directory;
    protected $converter;
    protected $resultPageFactory;
    protected $directory_list;
    protected $_messageManager;

    public function __construct( \Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_messageManager = $context->getMessageManager();
        parent::__construct($context);
    }

    public function execute() {
        //$number = $this->getRequest()->getParam('file');
 

        //validate whether uploaded file is a csv file
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                //open uploaded csv file with read only mode
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

                //skip first line
                fgetcsv($csvFile);

                //parse data from csv file line by line
                $this->_response = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection= $this->_response->getConnection();
                $themeTable = $this->_response->getTableName('activation_code');
                
                while (($line = fgetcsv($csvFile)) !== FALSE) {
                    
                    //Select Data from table
                    $unique_sql = "Select id FROM " . $themeTable." where activation_code='$line[1]'";
                    $result = $connection->fetchAll($unique_sql);
                    if(!empty($result)) {
                        $message = 'Sorry! please import unique activation code';
                        $this->_messageManager->addError($message);
                        
                        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                        $resultRedirect->setPath('menuitem/importcsv/index');
                        return $resultRedirect;
                    }
                    
                    $date = date('Y-m-d H:i:s');
                    $sql = "INSERT INTO " . $themeTable . "(sku, activation_code, price, status, created_on) VALUES ('$line[0]', '$line[1]', '$line[2]', 1, '$date')";
                    $connection->query($sql);
                }

                //close opened csv file
                fclose($csvFile);

                $message = 'Your csv file has been imported successfully';
                $this->_messageManager->addSuccess($message);
                
                 $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                 $resultRedirect->setPath('menuitem/importcsv/index');
                 return $resultRedirect;
                
            } else {
                $message = 'Please enter correct csv file';
                //$this->_messageManager->addSuccess($message);
                $this->_messageManager->addError($message);
                return $this->_redirect('menuitem/importcsv/index');
            }
        } else {
            $message = 'Please enter correct csv file';
            //$this->_messageManager->addSuccess($message);
            $this->_messageManager->addError($message);
            return $this->_redirect('menuitem/importcsv/index');
        }


    }

     

}