<?php

namespace OuterEdge\LeadSources\Controller\Adminhtml\Leads;

use OuterEdge\LeadSources\Controller\Adminhtml\Leads;
use OuterEdge\LeadSources\Model\LeadsFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Exception;
use Magento\PageCache\Model\Config;
use Magento\Framework\App\Cache\TypeListInterface;

class Save extends Leads
{
    /**
     * @var DateTime
     */
    protected $dateTime;
    
    /**
     * @var Config
     */
    protected $config;
    
    /**
     * @var TypeListInterface
     */
    protected $typeList;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param LeadsFactory $leadsFactory
     * @param DateTime $dateTime
     * @param Config $config
     * @param TypeListInterface $typeList
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        LeadsFactory $leadsFactory,
        DateTime $dateTime,
        Config $config,
        TypeListInterface $typeList
    ) {
        $this->dateTime = $dateTime;
        $this->config = $config;
        $this->typeList = $typeList;
        parent::__construct(
            $context,
            $coreRegistry,
            $resultPageFactory,
            $leadsFactory
        );
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue('leads');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $data['updated_at'] = $this->dateTime->date();

            $model = $this->leadsFactory->create();

            $leadsId = $this->getRequest()->getParam('entity_id');
           
            if ($leadsId) {
                $model->load($leadsId);

                if (!$model->getId()) {
                    $this->messageManager->addError(__('This lead no longer exists.'));
                    return $this->returnResult('*/*/', [], ['error' => true]);
                }
            } else {
                $data['created_at'] = $this->dateTime->date();
            }

            $model->addData($data);

            try {
                $model->save();

                $this->messageManager->addSuccess(__('The lead has been saved.'));

                $this->_session->setLeadsData(false);
                
                if ($this->config->isEnabled()) {
                    $this->typeList->invalidate('BLOCK_HTML');
                }

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath(
                        '*/*/edit',
                        ['entity_id' => $model->getId(), '_current' => true],
                        ['error' => false]
                    );
                }
                return $resultRedirect->setPath('*/*/', [], ['error' => false]);
            } catch (Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_session->setLeadsData($data);
                return $resultRedirect->setPath(
                    '*/*/edit',
                    ['entity_id' => $model->getId(),
                    '_current' => true],
                    ['error' => true]
                );
            }
        }
        return $resultRedirect->setPath('*/*/', [], ['error' => true]);
    }
}
