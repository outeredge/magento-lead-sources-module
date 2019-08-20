<?php

namespace OuterEdge\LeadSources\Api;

use Magento\Sales\Model\Order;
use OuterEdge\LeadSources\Api\Data\CustomFieldsInterface;

interface CustomFieldsRepositoryInterface
{
    /**
     * @param int $cartId
     * @param \OuterEdge\LeadSources\Api\Data\CustomFieldsInterface $customFields
     *
     * @return \OuterEdge\LeadSources\Api\Data\CustomFieldsInterface
     */
    public function saveCustomFields(
        int $cartId,
        CustomFieldsInterface $customFields
    ): CustomFieldsInterface;

    /**
     * @param Order $order
     *
     * @return CustomFieldsInterface
     */
    public function getCustomFields(Order $order) : CustomFieldsInterface;
}
