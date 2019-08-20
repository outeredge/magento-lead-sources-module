<?php

namespace OuterEdge\LeadSources\Api\Data;

interface CustomFieldsInterface
{
    const CHECKOUT_LEAD = 'lead';
    const CHECKOUT_COMMENT = 'comment';

    /**
     * Get checkout buyer name
     *
     * @return string|null
     */
    public function getCheckoutLead();

    /**
     * Get checkout comment
     *
     * @return string|null
     */
    public function getCheckoutComment();

    /**
     * Set checkout buyer name
     *
     * @param string|null $checkoutLead Buyer name
     *
     * @return CustomFieldsInterface
     */
    public function setCheckoutLead(string $checkoutLead = null);

    /**
     * Set checkout comment
     *
     * @param string|null $comment Comment
     *
     * @return CustomFieldsInterface
     */
    public function setCheckoutComment(string $comment = null);
}
