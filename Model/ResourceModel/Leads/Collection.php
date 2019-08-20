<?php
namespace OuterEdge\LeadSources\Model\ResourceModel\Leads;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OuterEdge\LeadSources\Model\Leads', 'OuterEdge\LeadSources\Model\ResourceModel\Leads');
    }
}