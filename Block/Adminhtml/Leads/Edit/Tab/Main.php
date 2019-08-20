<?php

namespace OuterEdge\LeadSources\Block\Adminhtml\Leads\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

class Main extends Generic
{
    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $leads = $this->_coreRegistry->registry('leadsModel');

        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Leads Properties')]);

        if ($leads->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
    
        $fieldset->addField(
            'title',
            'text',
            [
                'name'  => 'leads[title]',
                'label' => __('Title'),
                'title' => __('Title')
            ]
        );
        
        $fieldset->addField(
            'active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'leads[active]',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );
    
        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name'  => 'leads[sort_order]',
                'label' => __('Sort Order'),
                'title' => __('Sort Order')
            ]
        );

        $form->setValues($leads->getData());
        $this->setForm($form);

        $this->_eventManager->dispatch('leads_form_build_main_tab', ['form' => $form]);

        return parent::_prepareForm();
    }
}
