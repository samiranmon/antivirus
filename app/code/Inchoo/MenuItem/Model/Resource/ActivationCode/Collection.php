<?php

namespace Inchoo\MenuItem\Model\Resource\ActivationCode;

//use Magento\Framework\Model\Resource\Db\Collection\AbstractCollection;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection {

    /**
     * Define model & resource model
     */
    protected function _construct() {
        $this->_init(
                'Inchoo\MenuItem\Model\ActivationCode', 'Inchoo\MenuItem\Model\Resource\ActivationCode'
        );
    }

}
