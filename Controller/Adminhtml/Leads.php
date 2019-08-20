<?php

namespace OuterEdge\LeadSources\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Phrase;
use OuterEdge\LeadSources\Model\LeadsFactory;

abstract class Leads extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'OuterEdge_LeadSources::leads';
    
    /**
     * @var Registry
     */
    protected $_coreRegistry = null;
    
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    
    /**
     * @var LeadsFactory
     */
    protected $leadsFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param LeadsFactory $leadsFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        LeadsFactory $leadsFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->leadsFactory = $leadsFactory;
        parent::__construct($context);
    }
    
    /**
     * @param Phrase|null $title
     * @return Page
     */
    protected function createActionPage($title = null)
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(__('Leads'), __('Leads'))
            ->addBreadcrumb(__('Manage Leads'), __('Manage Leads'))
            ->setActiveMenu('OuterEdge_LeadSources::leads');
        if (!empty($title)) {
            $resultPage->addBreadcrumb($title, $title);
        }
        $resultPage->getConfig()->getTitle()->prepend(__('Leads'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
    return $this->_authorization->isAllowed('OuterEdge_LeadSources::leads');
    }
}