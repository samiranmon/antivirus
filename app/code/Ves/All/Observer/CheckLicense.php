<?php
/**
 * Venustheme
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Venustheme.com license that is
 * available through the world-wide-web at this URL:
 * http://www.venustheme.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Venustheme
 * @package    Ves_All
 * @copyright  Copyright (c) 2014 Venustheme (http://www.venustheme.com/)
 * @license    http://www.venustheme.com/LICENSE-1.0.html
 */
namespace Ves\All\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Module\Dir;

class CheckLicense implements ObserverInterface
{
	/**
     * @var \Ves\All\Model\License
     */
	protected $_license;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

	/**
     * @var \Magento\Framework\Module\Dir\Reader
     */
	protected $_moduleReader;

	/**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    protected $_remoteAddress;

	/**
	 * @param \Ves\All\Model\License                               $licnese        
	 * @param \Magento\Framework\Module\Dir\Reader                 $moduleReader   
	 * @param \Magento\Store\Model\StoreManagerInterface           $storeManager   
	 * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress  
	 * @param \Magento\Framework\Message\ManagerInterface          $messageManager 
	 */
	public function __construct(
		\Ves\All\Model\License $licnese,
		\Magento\Framework\Module\Dir\Reader $moduleReader,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
		\Magento\Framework\Message\ManagerInterface $messageManager
		) {
		$this->_license       = $licnese;
		$this->_moduleReader  = $moduleReader;
		$this->messageManager = $messageManager;
		$this->_storeManager  = $storeManager;
		$this->_remoteAddress = $remoteAddress;
	}
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		$ip = $this->_remoteAddress->getRemoteAddress();
		$obj = $observer->getObj();
		$module_name = $obj->getData('module_name');
		$file = $this->_moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, $module_name) . '/license.xml';
		try{
			$xmlObj = new \Magento\Framework\Simplexml\Config($file);
			$xmlData = $xmlObj->getNode();
		}catch(\Exception $e){
			die($e->getMessage());
		}
		$error = false;
		if($xmlData){
			$code = $xmlData->code;
			$license = $this->_license->load($code);
			if($license && $license->getStatus()){
				$obj->setData('is_valid',1);
			}else{
				$obj->setData('is_valid',0);
				$error = true;
			}
		}else{
			$obj->setData('is_valid',0);
			$error = true;
		}
		if($error && $ip != '127.0.0.1'){
			$this->messageManager->addError('Your licence is assigned to the different store domain. Please, login to your account in <a href="http://landofcoder.com">landofcoder.com</a> and check your licence status.');
		}
		if($ip === '127.0.0.1'){
			$obj->setData('is_valid',1);
		}
	}
}