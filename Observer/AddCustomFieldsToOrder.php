<?php

namespace OuterEdge\LeadSources\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\RequestInterface;
use OuterEdge\LeadSources\Api\Data\CustomFieldsInterface;

class AddCustomFieldsToOrder implements ObserverInterface
{

    public function __construct(
        protected RequestInterface $request
    ) {
    }
    
    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        $orderData = $this->request->getParam('order');
        
        if (isset($orderData['checkout_lead'])) {
            $quote->setData(CustomFieldsInterface::CHECKOUT_LEAD,
                $orderData['checkout_lead']
            );
        } elseif ($order->getCustomerId() != null) {
            $quote->setData(CustomFieldsInterface::CHECKOUT_LEAD,
                'Existing Customer'
            );
        }

        if (isset($orderData['comment']['customer_note'])) {
            $quote->setData(CustomFieldsInterface::CHECKOUT_COMMENT,
                $orderData['comment']['customer_note']
            );
        }

        $order->setData(
            CustomFieldsInterface::CHECKOUT_LEAD,
            $quote->getData(CustomFieldsInterface::CHECKOUT_LEAD)
        );
        $order->setData(
            CustomFieldsInterface::CHECKOUT_COMMENT,
            $quote->getData(CustomFieldsInterface::CHECKOUT_COMMENT)
        );
    }
}
