<?php

namespace OuterEdge\LeadSources\Block\Order;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order;
use OuterEdge\LeadSources\Api\Data\CustomFieldsInterface;
use OuterEdge\LeadSources\Api\CustomFieldsRepositoryInterface;

class CustomFields extends Template
{
    /**
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @var CustomFieldsRepositoryInterface
     */
    protected $customFieldsRepository;

    /**
     * @param Context                         $context
     * @param Registry                        $registry
     * @param CustomFieldsRepositoryInterface $customFieldsRepository
     * @param array                           $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        CustomFieldsRepositoryInterface $customFieldsRepository,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->customFieldsRepository = $customFieldsRepository;
        $this->_isScopePrivate = true;
        $this->_template = 'order/view/custom_fields.phtml';
        parent::__construct($context, $data);
    }

    /**
     * @return Order
     */
    public function getOrder() : Order
    {
        return $this->coreRegistry->registry('current_order');
    }

    /**
     * @param Order $order Order
     *
     * @return CustomFieldsInterface
     */
    public function getCustomFields(Order $order)
    {
        return $this->customFieldsRepository->getCustomFields($order);
    }
}
