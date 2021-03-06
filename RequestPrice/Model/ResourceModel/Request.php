<?php

namespace Codelegacy\RequestPrice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Codelegacy\RequestPrice\Model\Request as Model;

class Request extends AbstractDb
{
    const MAIN_TABLE = 'request_price';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, Model::KEY_ID);
    }
}