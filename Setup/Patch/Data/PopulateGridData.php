<?php

namespace OuterEdge\LeadSources\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\App\ResourceConnection;

class PopulateGridData implements DataPatchInterface
{
    private $resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection,
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    private function populateSalesOrderGridColumns()
    {
        $connection = $this->resourceConnection->getConnection();

        $select = $connection->select()->join(
            $connection->getTableName('sales_order'),
            "sales_order.entity_id = sales_order_grid.entity_id",
            ['entity_id', 'lead']
        );

        $connection->query(
            $connection->updateFromSelect(
                $select,
                'sales_order_grid'
            )
        );
    }

    public function apply()
    {
        $this->populateSalesOrderGridColumns();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
