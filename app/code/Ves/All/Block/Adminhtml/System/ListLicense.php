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
namespace Ves\All\Block\Adminhtml\System;
use Magento\Framework\App\Filesystem\DirectoryList;

class ListLicense extends \Magento\Config\Block\System\Config\Form\Field
{

    const API_URL = 'http://landofcoder.com/api/soap/?wsdl=1';
    const API_USERNAME = 'checklicense';
    const API_PASSWORD = 'n2w3z2y0kc';

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * [__construct description]
     * @param \Magento\Backend\Block\Template\Context              $context 
     * @param \Magento\Framework\App\ResourceConnection            $resource      
     * @param \Ves\All\Helper\Data                                 $helper        
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress 
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\ResourceConnection $resource,
        \Ves\All\Helper\Data $helper,
        \Ves\All\Model\License $license,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
        )
    {
        parent::__construct($context);
        $this->_resource      = $resource;
        $this->_helper        = $helper;
        $this->_remoteAddress = $remoteAddress;
        $this->_license       = $license;
    }

    /**
     * Retrieve HTML markup for given form element
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        if (!extension_loaded('soap')) {
            throw new \Magento\Framework\Webapi\Exception(
                __('SOAP extension is not loaded.'),
                0,
                \Magento\Framework\Webapi\Exception::HTTP_INTERNAL_ERROR
            );
        }
        $email = $html = '';
        try{
            $proxy = new \SoapClient(self::API_URL);
            $sessionId = $proxy->login(self::API_USERNAME, self::API_PASSWORD);
            $products = $proxy->call($sessionId, 'veslicense.productlist');
            $path = $this->_filesystem->getDirectoryRead(DirectoryList::APP)->getAbsolutePath('code/Ves/');
            $files = glob($path . '*/*/license.xml');
            $extensions = [];
            foreach ($files as $file) {
                $xmlObj = new \Magento\Framework\Simplexml\Config($file);
                $xmlData = $xmlObj->getNode();
                $sku = $xmlData->code;
                $name = $xmlData->name;
                if($email=='' && ($xmlData->email)){
                    $email = $xmlData->email;
                }
                foreach($products as $_product){
                    if($sku == $_product['sku']){
                        $_product['extension_name'] = (string)$name;
                        $extensions[] = $_product;
                        break;
                    }
                }
            }
            if($email){
                throw new \RuntimeException(__('Something went wrong while validating license. Please contact %1', $email));
            }
        }catch(\Exception $e){
            die($e->getMessage());
        }
        if(!empty($extensions)){
            try{
                $connection = $this->_resource->getConnection();
                $html .= '<div class="vlicense">';
                $html .= '<h1 style="margin-bottom: 50px;text-align: center;">LOF Licenses</h1>';
                foreach ($extensions as $_extension) {
                    $name = str_replace('[licenses]', '[' . str_replace(['-','_',' '], [''], $_extension['sku']) . ']', $element->getName());
                    $value = $this->_helper->getConfig('general/' . str_replace(['-','_',' '], [''], $_extension['sku']),'veslicense');
                    $baseUrl = $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_WEB,
                        $this->_storeManager->getStore()->isCurrentlySecure()
                        );
                    $remoteAddress = $this->_remoteAddress->getRemoteAddress();
                    $domain = $this->getDomain($baseUrl);
                    $license = $proxy->call($sessionId, 'veslicense.active', array($value, $_extension['sku'], $domain, $remoteAddress));
                    if(!is_array($license) && $license == 1){
                        $license = [];
                        $license['is_valid'] = 0;
                    }
                    if($license === true){
                        $license = [];
                        $license['is_valid'] = 1;
                    }
                    $html .= '<div class="vitem">';
                    $html .= '<div class="pimg">';
                    $html .= '<a href="' . $_extension['purl'] . '" target="_blank" title="' . $_extension['name'] . '"><img src="' .  $_extension['pimg'] . '"/></a>';
                    $html .= '</div>';
                    $html .= '<div class="pdetails">';
                    $html .=  '<h1><a href="' . $_extension['purl'] . '" target="_blank" title="' . $_extension['name'] . '">' . str_replace(' for Magento 2', '', $_extension['name']) . '</a></h1>';
                    $html .= '<div>';
                    $html .= '<span class="plicense"><strong>License Serial</strong></span>';
                    $html .= '<div><input type="text" name="' . $name . '" value="' . $value . '"/></div>';
                    $html .= '<div class="pmeta">';
                    if(!empty($license) && $license['is_valid']){
                        $html .= '<p><strong>Status: </strong><span class="pvalid">Valid</span></p>';
                    }else{
                        $html .= '<p><strong>Status: </strong><span class="pinvalid">In Valid</span></p>';
                    }
                    if(!empty($license) && isset($license['description'])){
                        $html .= $license['description'];
                    }
                    if(!empty($license) && isset($license['created_at'])){
                        $html .= '<p><strong>Activation Date:</strong> ' . $license['created_at'] . '</p>';
                    }
                    if(!empty($license) && isset($license['expired_time'])){
                        $html .= '<p><strong>Expiration Date:</strong> ' . $license['expired_time'] . '</p>';
                    }
                    $html .= '</div>';
                    $licenseCollection = $this->_license->getCollection();
                    foreach ($licenseCollection as $klience => $vlience) {
                        if($vlience->getData('extension_code') == $_extension['sku']){
                            $vlience->delete();
                        }
                    }
                    $licenseData = [];
                    if(isset($_extension['sku'])){
                        $licenseData['extension_code'] = $_extension['sku'];
                    }
                    if(isset($_extension['name'])){
                        $licenseData['extension_name'] = $_extension['name'];
                    }
                    if(empty($license) || !$license['is_valid']){
                        $licenseData['status'] = 0;
                    }else{
                        $licenseData['status'] = 1;
                    }
                    $this->_license->setData($licenseData)->save();
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
                $html .= '</div>';
            }catch(\Exception $e){
                die($e->getMessage());
            }
        }else{
            try{
                $licenseCollection = $this->_license->getCollection();
                foreach ($licenseCollection as $klience => $vlience) {
                    $vlience->delete();
                }
            }catch(\Exception $e){
                die($e->getMessage());
            }
        }
        return $this->_decorateRowHtml($element, $html);
    }

    public function getDomain($domain) {
        $domain = strtolower($domain);
        $domain = str_replace(['www.','WWW.','https://','http://','https','http'], [''], $domain);
        if($this->endsWith($domain, '/')){
            $domain = substr_replace($domain ,"",-1);
        }
        return $domain;
    }
    public function endsWith($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
}