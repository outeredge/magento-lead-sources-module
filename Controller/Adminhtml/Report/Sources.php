<?php
namespace OuterEdge\LeadSources\Controller\Adminhtml\Report;

use Magento\Reports\Controller\Adminhtml\Report\Product as ProductReport;

class Sources extends ProductReport
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'OuterEdge_LeadSources::lead_sources';

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     */
    public function execute()
    {
        $this->_initAction()->_setActiveMenu('OuterEdge_LeadSources::report_lead_sources'
        )->_addBreadcrumb(
            __('Report Lead Sources'),
            __('Report Lead Sources')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Lead Sources Report'));
        $this->_view->renderLayout();
    }

}