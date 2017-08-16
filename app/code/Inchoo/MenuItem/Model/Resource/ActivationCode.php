<?php

namespace Inchoo\MenuItem\Model\Resource;

//use Magento\Framework\Model\Resource\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ActivationCode extends AbstractDb {

    /**
     * Define main table
     */
    protected function _construct() {
        $this->_init('activation_code', 'id');
    }

}
