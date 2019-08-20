<?php

namespace OuterEdge\LeadSources\Plugin\Block\Adminhtml\Order\Create;

class DataPlugin extends \Magento\Backend\Block\Template
{
    public function beforegetChildHtml($subject, $alias = '', $useCache = true)
    {
        if ($alias == 'comment') {
            echo $this->getLayout()
            ->createBlock('\Magento\Backend\Block\Template')
            ->setTemplate('OuterEdge_LeadSources::order/leads/form.phtml')->toHtml();
        }
   }

}
