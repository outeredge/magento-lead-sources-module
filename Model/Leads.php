<?php

namespace OuterEdge\LeadSources\Model;

use Magento\Framework\Model\AbstractModel;

class Leads extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('OuterEdge\LeadSources\Model\ResourceModel\Leads');
    }
}