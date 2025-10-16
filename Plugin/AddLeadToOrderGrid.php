<?php
namespace OuterEdge\LeadSources\Plugin;

use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OrderGridCollection;

class AddLeadToOrderGrid
{
    public function afterGetReport(CollectionFactory $subject, $collection, $requestName)
    {
        if ($requestName == 'sales_order_grid_data_source') {
            if ($collection instanceof OrderGridCollection && !$collection->isLoaded()) {
                $collection->getSelect()->joinLeft(
                    ['sales_order' => $collection->getTable('sales_order')],
                    'main_table.entity_id = sales_order.entity_id',
                    ['lead' => 'sales_order.lead']
                );
                $collection->getSelect()->group('main_table.entity_id');
            }
        }
        return $collection;
    }
}