<?php

namespace Alliance\Linkedin\Plugin\Checkout\Model;


use Magento\Quote\Model\QuoteRepository;

class ShippingInformationManagement
{

    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var
     */
    protected $dataHelper;

    public function __construct(
        QuoteRepository $quoteRepository
    )
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
                                                              $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    )
    {
        if(!$extensionAttributes = $addressInformation->getExtensionAttributes())
        {
            return;
        }

        $quote = $this->quoteRepository->getActive($cartId);
        $quote->setLinkedinProfile($extensionAttributes->getLinkedinProfile());
    }

}
