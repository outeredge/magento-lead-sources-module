<?php

namespace OuterEdge\LeadSources\Api;

use Magento\Sales\Model\Order;
use OuterEdge\LeadSources\Api\Data\CustomFieldsInterface;

interface CustomFieldsGuestRepositoryInterface
{
    /**
     * @param string $cartId
     * @param OuterEdge\LeadSources\Api\Data\CustomFieldsInterface $customFields
     *
     * @return OuterEdge\LeadSources\Api\Data\CustomFieldsInterface
     */
    public function saveCustomFields(
        string $cartId,
        CustomFieldsInterface $customFields
    ): CustomFieldsInterface;
}
