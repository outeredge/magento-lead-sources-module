<?php

namespace  OuterEdge\LeadSources\Block\Adminhtml\Leads\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

/**
 * Admin page left menu
 */
class Tabs extends WidgetTabs
{
    
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('leads_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Leads Information'));
    }
    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'main',
            [
                'label' => __('Properties'),
                'title' => __('Properties'),
                'content' => $this->getChildHtml('main'),
                'active' => true
            ]
        );
        return parent::_beforeToHtml();
    }
}