<?php
namespace OuterEdge\LeadSources\Block\Adminhtml\Leads;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data as BackendHelper;
use OuterEdge\LeadSources\Model\LeadsFactory;
use Magento\Framework\DataObject;

class Grid extends Extended
{
    /**
     * @var LeadsFactory
     */
    private $leadsFactory;
    /**
     * @param Context $context
     * @param BackendHelper $backendHelper
     * @param LeadsFactory $leadsFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        BackendHelper $backendHelper,
        LeadsFactory $leadsFactory,
        array $data = []
    ) {
        $this->leadsFactory = $leadsFactory;
        parent::__construct($context, $backendHelper, $data);
    }
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('leadsGrid');
        $this->setDefaultSort('title');
        $this->setDefaultDir('ASC');
    }
    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->leadsFactory->create()->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index'  => 'title'
            ]
        );
        $this->addColumn(
            'active',
            [
                'header' => __('Active'),
                'index'  => 'active'
            ]
        );
        $this->addColumn(
            'sort_order',
            [
                'header' => __('Sort Order'),
                'index'  => 'sort_order'
            ]
        );
        $this->_eventManager->dispatch('leads_grid_build', ['grid' => $this]);
        return parent::_prepareColumns();
    }
    /**
     * Return url of given row
     *
     * @param DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['entity_id' => $row->getId()]);
    }
}