<?php

namespace OuterEdge\LeadSources\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Leads extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_leads';
        $this->_blockGroup = 'OuterEdge_LeadSources';
        $this->_headerText = __('Leads');
        $this->_addButtonLabel = __('Create New Lead');
        parent::_construct();
    }
}