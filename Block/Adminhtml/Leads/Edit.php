<?php

namespace OuterEdge\LeadSources\Block\Adminhtml\Leads;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Phrase;

class Edit extends Container
{
    /**
     * Block Leads name
     *
     * @var string
     */
    protected $_blockGroup = 'OuterEdge_LeadSources';
    
    /**
     * @var Registry
     */
    protected $_coreRegistry = null;
    
    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    
    /**
     * Initialize Leads edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'entity_id';
        $this->_controller = 'adminhtml_leads';
        
        parent::_construct();
        
        $this->buttonList->update('save', 'label', __('Save Lead'));
        $this->buttonList->add(
            'save_and_edit_button',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete'));
    }
    
    /**
     * Retrieve header text
     *
     * @return Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('leadsModel')->getId()) {
            return __('Edit Lead "%1"', $this->escapeHtml($this->_coreRegistry->registry('leadsModel')->getTitle()));
        }
        return __('New Lead');
    }
    
    /**
     * Retrieve URL for save
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', ['_current' => true, 'back' => null]);
    }
}