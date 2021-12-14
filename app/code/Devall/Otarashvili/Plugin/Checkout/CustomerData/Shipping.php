<?php

namespace Devall\Otarashvili\Plugin\Checkout\CustomerData;

use Magento\Checkout\CustomerData\Cart;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;


class Shipping
{

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    private $cart;


    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Cart $cart
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->cart = $cart;
    }


    /**
     * Add dynamic message to cart section data
     *
     * @param Cart $subject
     * @param array $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetSectionData(Cart $subject, array $result): array
    {
        $cart = $this->cart;
        $totalQuantity = $cart->getQuote()->getItemsQty();
        $price = $this->scopeConfig->getValue('carriers/flatrate/price');
        $totalShippingAmount = $totalQuantity * $price;
        $result['shipping'] = $totalShippingAmount .' $';

        return $result;
    }

}
