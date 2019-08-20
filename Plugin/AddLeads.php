<?php

namespace OuterEdge\LeadSources\Plugin;

use OuterEdge\LeadSources\Helper\Data as LeadsHelper;

class AddLeads
{
     /**
     * @var LeadsHelper
     */
    protected $leadsHelper;

    /**
     * @param LeadsHelper $leadsHelper
     */
    public function __construct(
        LeadsHelper $leadsHelper
    ) {
        $this->leadsHelper = $leadsHelper;
    }

    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $result)
	{
	    $customAttributeCode = 'checkout_lead';
        $customField = [
            'component' => 'OuterEdge_LeadSources/js/view/checkout/custom-checkout-form',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'leads',
            ],
            'dataScope' => 'shippingAddress.' . $customAttributeCode,
            'label' => $this->leadsHelper->getFieldLabel(),
            'provider' => 'checkoutProvider',
            'sortOrder' => 251,
            'validation' => [
               'required-entry' => true
            ],
            'id' => 'leads',
            'options' => $this->leadsHelper->getLeadArray(),
            'visible' => true,
        ];

        $result['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode] = $customField;

        $customAttributeCodeInput = 'checkout_lead_input';
        $customFieldInput = [
            'component' => 'OuterEdge_LeadSources/js/view/checkout/custom-checkout-form',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
            ],
            'dataScope' => 'shippingAddress.' . $customAttributeCodeInput,
            'provider' => 'checkoutProvider',
            'sortOrder' => 252,
            'validation' => [
               'required-entry' => false
            ],
            'id' => 'leads-input',
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
        ];

        $result['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCodeInput] = $customFieldInput;

        return $result;
    }
}
