<?php

namespace OuterEdge\LeadSources\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\RequestInterface;
use OuterEdge\LeadSources\Api\Data\CustomFieldsInterface;

class AddCustomFieldsToOrder implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(
        RequestInterface $request
    )
    {
        $this->_request = $request; 
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

        $orderData = $this->_request->getParam('order');
        
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
