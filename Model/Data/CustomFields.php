<?php

namespace OuterEdge\LeadSources\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use OuterEdge\LeadSources\Api\Data\CustomFieldsInterface;

class CustomFields extends AbstractExtensibleObject implements CustomFieldsInterface
{
    /**
     * @return string|null
     */
    public function getCheckoutLead()
    {
        return $this->_get(self::CHECKOUT_LEAD);
    }

    /**
     * @return string|null
     */
    public function getCheckoutComment()
    {
        return $this->_get(self::CHECKOUT_COMMENT);
    }

    /**
     * @param string|null $checkoutLead
     *
     * @return CustomFieldsInterface
     */
    public function setCheckoutLead(string $checkoutLead = null)
    {
        return $this->setData(self::CHECKOUT_LEAD, $checkoutLead);
    }

    /**
     * @param string|null $comment
     *
     * @return CustomFieldsInterface
     */
    public function setCheckoutComment(string $comment = null)
    {
        return $this->setData(self::CHECKOUT_COMMENT, $comment);
    }
}
