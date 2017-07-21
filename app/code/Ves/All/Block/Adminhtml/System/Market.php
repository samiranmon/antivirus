<?php
namespace Ves\All\Block\Adminhtml\System;

use Magento\Framework\App\Filesystem\DirectoryList;
use Ves\All\Block\Adminhtml\System\ListLicense;

class Market extends \Magento\Config\Block\System\Config\Form\Field
{

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
        $proxy = new \SoapClient(ListLicense::API_URL);
        $sessionId = $proxy->login(ListLicense::API_USERNAME, ListLicense::API_PASSWORD);
        $products = $proxy->call($sessionId, 'veslicense.productlist1');
        $total = 12;
        $column = 2;
        $x = 0;
        $html = '';
        $html .= '<div id="ves-elist">';
        $html .=  '<h1><a href="http://landofcoder.com">Landofcoder.com - Opensource Marketplace for magento, opencart</a></h1>';
        foreach ($products as $_product) {
            if( $column == 1 || $x%$column == 0){
                $html .= '<div class="erow">';
            }
            $class = '';
            if( $column == 1 || ($x+1)%$column == 0 || $x == ($total-1) ) {
                $class = ' last';
            }
            $html .= '<div class="extend-card ' . $class . '">';
            $html .= '<div class="extend-card-top">';
            $html .= '<div class="extend-card-image"><a href="' . $_product['purl'] . '" title="' . $_product['name'] . '"><img src="' .  $_product['pimg'] . '" class="plugin-icon" alt=""></a></div>';
            $html .= '<div class="extend-card-desc"><a href="' . $_product['purl'] . '" title="' . $_product['name'] . '"><h3>' .  $_product['name'] . '</h3></a><div class="extend-des"> ' . $_product['short_description'] . ' <a href="' . $_product['purl'] . '" class="edetai">More Details</a></div><div class="extend-price">' . $_product['price'] . '</div><a href="' . $_product['purl'] . '" title="' . $_product['name'] . '" class="extend-buynow">Buy Now</a></div>';
            $html .= '</div>';
            $html .= '</div>';
            if( $column == 1 || ($x+1)%$column == 0 || $x == ($total-1) ) {
                $html .= '</div>';
            }
            $x++;
        }
        $html .= '</div>';
        
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