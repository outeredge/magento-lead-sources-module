<?php

namespace OuterEdge\LeadSources\Setup;
 
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use OuterEdge\LeadSources\Model\Leads;
use OuterEdge\LeadSources\Model\LeadsFactory;
use Magento\Quote\Setup\QuoteSetupFactory;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Framework\DB\Ddl\Table;
use OuterEdge\LeadSources\Api\Data\CustomFieldsInterface;
 
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var LeadsFactory
     */
    protected $leadsFactory;

    /**
     * @var SalesSetupFactory
     */
    protected $salesSetupFactory;
    
    /**
     * @var QuoteSetupFactory
     */
    protected $quoteSetupFactory;
    
    /**
     * @var ModuleDataSetupInterface
     */
    protected $setup;
 
    public function __construct(
        LeadsFactory $leadsFactory,
        SalesSetupFactory $salesSetupFactory,
        QuoteSetupFactory $quoteSetupFactory)
    {
        $this->leadsFactory = $leadsFactory;
        $this->salesSetupFactory = $salesSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
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

        if ( version_compare($context->getVersion(), '1.0.2', '<=' )) {
            $this->setup = $setup->startSetup();
            $this->installQuoteData();
            $this->installSalesData();
            $this->setup = $setup->endSetup();
        }
    }

    /**
     * Install quote custom data
     *
     * @return void
     */
    public function installQuoteData()
    {
        $quoteInstaller = $this->quoteSetupFactory->create(
            [
                'resourceName' => 'quote_setup',
                'setup' => $this->setup
            ]
        );
        $quoteInstaller
            ->addAttribute(
                'quote',
                CustomFieldsInterface::CHECKOUT_COMMENT,
                ['type' => Table::TYPE_TEXT, 'length' => '64k', 'nullable' => true]
            );
    }
    
    /**
     * @return void
     */
    public function installSalesData()
    {
        $salesInstaller = $this->salesSetupFactory->create(
            [
                'resourceName' => 'sales_setup',
                'setup' => $this->setup
            ]
        );
        $salesInstaller
            ->addAttribute(
                'order',
                CustomFieldsInterface::CHECKOUT_COMMENT,
                ['type' => Table::TYPE_TEXT, 'length' => '64k', 'nullable' => true, 'grid' => false]
            );
    }

}
