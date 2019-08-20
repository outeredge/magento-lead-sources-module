<?php

namespace OuterEdge\LeadSources\Controller\Adminhtml\Leads;

use OuterEdge\LeadSources\Controller\Adminhtml\Leads;
use Magento\Framework\Controller\ResultInterface;

class Edit extends Leads
{
    /**
     * @return ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        $model = $this->leadsFactory->create();
    
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This leads no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_session->getLeadsData(true);
        
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('leadsModel', $model);

        $item = $id ? __('Edit Lead') : __('New Lead');

        $resultPage = $this->createActionPage($item);
        $resultPage->getConfig()->getTitle()->prepend($id ? $model->getTitle() : __('New Lead'));
        return $resultPage;
    }
}
