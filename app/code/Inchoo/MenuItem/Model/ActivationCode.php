<?php

namespace Inchoo\MenuItem\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Pay In Store payment method model
 */
class ActivationCode extends AbstractModel {

    /**
     * Define resource model
     */
    protected function _construct() {
        $this->_init('Inchoo\MenuItem\Model\Resource\ActivationCode');
    }

}
