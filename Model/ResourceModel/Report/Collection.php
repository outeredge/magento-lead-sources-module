<?php
namespace OuterEdge\LeadSources\Model\ResourceModel\Report;

use Magento\Reports\Model\ResourceModel\Order\Collection as OrderCollection;

class Collection extends OrderCollection
{
    /**
     * Set Date range to collection
     *
     * @param int $from
     * @param int $to
     * @return $this
     */
    public function setDateRange($from, $to)
    {
        $this->_reset()->addAttributeToSelect(
            '*'
        )->addLeadSources(
            $from,
            $to
        );
        return $this;
    }

    /**
     * Collect order details for the time period and join 'leads' table to get revenue and number of lead.
     * @param string $from
     * @param string $to
     * @return $this
     */
    public function addLeadSources($from = '', $to = '')
    {
        $this->getSelect()->reset()->from(
            ['order' => $this->getTable('sales_order')],
            ["SUBSTRING_INDEX(`order`.`lead`,':',1) as lead"]
        )->joinLeft(
            ['leads' => $this->getTable('leads')],
            '`leads`.title = `order`.lead',
            []
        )->columns('SUM(order.base_grand_total) as revenue')->columns('COUNT(lead) as result')->group("SUBSTRING_INDEX(`order`.`lead`,':',1)");


        if ($from != '' && $to != '') {
            $this->getSelect()->where('created_at >= ?', $from)->where('created_at <= ?', $to);
        }

        return $this;
    }

    /**
     * Set store filter to collection
     *
     * @param array $storeIds
     * @return $this
     */
    public function setStoreIds($storeIds)
    {
        if ($storeIds) {
            $this->getSelect()->where('`order`.store_id IN (?)', (array)$storeIds);
        }
        return $this;
    }

    /**
     * Set order
     *
     * @param string $attribute
     * @param string $dir
     * @return $this
     */
    public function setOrder($attribute, $dir = self::SORT_ORDER_DESC)
    {
        if (in_array($attribute, ['orders', 'ordered_qty'])) {
            $this->getSelect()->order($attribute . ' ' . $dir);
        } else {
            parent::setOrder($attribute, $dir);
        }
        return $this;
    }
}