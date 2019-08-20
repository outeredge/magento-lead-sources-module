<?php
namespace OuterEdge\LeadSources\Block\Adminhtml\Report;

use Magento\Backend\Block\Widget\Grid\Container;

class Sources extends Container
{
    /**
     * @var string
     */
    protected $_blockGroup = 'Magento_Reports';

    /**
     * Initialize container block settings
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Magento_Reports';
        $this->_controller = 'adminhtml_lead_sources';
        $this->_headerText = __('Lead Sources');
        parent::_construct();
        $this->buttonList->remove('add');
    }

}