<?php

namespace OuterEdge\LeadSources\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Leads extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('leads', 'id');
    }
}