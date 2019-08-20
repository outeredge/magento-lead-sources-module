<?php

namespace OuterEdge\LeadSources\Controller\Adminhtml\Leads;

use OuterEdge\LeadSources\Controller\Adminhtml\Leads;
use Magento\Backend\Model\View\Result\Redirect;
use Exception;

class Delete extends Leads
{
    /**
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
       
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            $model = $this->leadsFactory->create();
            $model->load($id);

            try {
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the lead.'));
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        
        $this->messageManager->addError(__('We can\'t find a lead to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
