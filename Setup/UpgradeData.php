<?php

namespace OuterEdge\LeadSources\Setup;
 
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use OuterEdge\LeadSources\Model\Leads;
use OuterEdge\LeadSources\Model\LeadsFactory;
 
class UpgradeData implements UpgradeDataInterface
{
    protected $leadsFactory;
 
    public function __construct(LeadsFactory $leadsFactory)
    {
        $this->leadsFactory = $leadsFactory;
    }

    public function upgrade( ModuleDataSetupInterface $setup, ModuleContextInterface $context ) 
    {
        if ( version_compare($context->getVersion(), '1.0.1', '<=' )) {
            
            $data = array
                (
                    ['title' => 'Recommended by a friend', 'active' => '1', 'sort_order' => '10'],
                    ['title' => 'Existing Customer', 'active' => '1', 'sort_order' => '20'],
                    ['title' => 'Google Search', 'active' => '1', 'sort_order' => '30'],
                    ['title' => 'Facebook', 'active' => '1', 'sort_order' => '40'],
                    ['title' => 'Instagram ', 'active' => '1', 'sort_order' => '50'],
                    ['title' => 'Pinterest', 'active' => '1', 'sort_order' => '60'],
                    ['title' => 'Twitter', 'active' => '1', 'sort_order' => '70'],
                    ['title' => 'Magazine', 'active' => '1', 'sort_order' => '150'],
                    ['title' => 'Amazon', 'active' => '1', 'sort_order' => '170'],
                    ['title' => 'Newspaper', 'active' => '1', 'sort_order' => '180'],
                    ['title' => 'The Mail Online', 'active' => '1', 'sort_order' => '190'],
                    ['title' => 'Received a gift', 'active' => '1', 'sort_order' => '200'],
                    ['title' => 'Seen in shops', 'active' => '1', 'sort_order' => '220'],
                    ['title' => 'Online Competition', 'active' => '1', 'sort_order' => '230'],
                    ['title' => 'Other reason', 'active' => '1', 'sort_order' => '300'],
                );
            
            foreach ($data as $value) {
                $this->leadsFactory->create()->setData($value)->save();    
            }
            
         }
     }
}
