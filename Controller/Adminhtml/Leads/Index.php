<?php

namespace OuterEdge\LeadSources\Controller\Adminhtml\Leads;

use OuterEdge\LeadSources\Controller\Adminhtml\Leads;
use Magento\Backend\Model\View\Result\Page;

class Index extends Leads
{
    
    /**
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->createActionPage();
        $resultPage->addContent(
            $resultPage->getLayout()->createBlock('OuterEdge\LeadSources\Block\Adminhtml\Leads')
        );
        return $resultPage;
    }
}
