<?php

namespace OuterEdge\LeadSources\Helper;

use OuterEdge\LeadSources\Model\LeadsFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var LeadsFactory
     */
    private $leadsFactory;

    /**
     * @param LeadsFactory $leadsFactory
     */
    public function __construct(
        LeadsFactory $leadsFactory
    ) {
        $this->leadsFactory = $leadsFactory;
    }
    
    public function getLeadDropdown()
    {
        $leads = $this->leadsFactory->create()->getCollection();
        $leads
                ->addFieldToFilter('active', ['eq' => 1])
                ->setOrder('sort_order', 'ASC')
                ->setOrder('title', 'ASC');

        $html = '<select id="lead" name="lead" class="required-entry validate-select full-width oversize">';
        $html.= '<option value="">Please select&hellip;</option>';
        foreach ($leads as $lead) {
            $html.= '<option value="' . $lead->getTitle() . '">' . $lead->getTitle() . '</option>';
        }
        $html.= '</select>';

        $html.= '<input type="text" id="lead-other" name="lead" disabled="disabled"/>';

        $html.= "
            <script>
                $('lead').observe('change', function(e){
                    if(this.getValue() === 'Other reason')
                        $('lead-other').addClassName('required-entry').removeAttribute('disabled');
                    else
                        $('lead-other').removeClassName('required-entry').setAttribute('disabled', 'disabled');
                });
            </script>";

        return $html;
    }
    
    public function getLeadArray()
    {
        $leads = $this->leadsFactory->create()->getCollection();
        $leads
                ->addFieldToFilter('active', ['eq' => 1])
                ->setOrder('sort_order', 'ASC')
                ->setOrder('title', 'ASC');
   
        $data[] = ['value' => '', 'label' => 'Please Select'];
        foreach ($leads as $lead) {
            $data[] = ['value' => $lead->getTitle(), 'label' => $lead->getTitle()];
        }
   
        return $data;
    }

    public function getFieldLabel()
    {
        return __('What prompted you to buy from us today?*');
    }

}