<?php

namespace Devall\Otarashvili\Plugin\Checkout\CustomerData;

use Magento\Checkout\CustomerData\Cart;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Tax\Api\TaxCalculationInterface;
use Magento\Tax\Api\TaxRateRepositoryInterface;

class Tax
{
    /**
     * @var TaxCalculationInterface
     */
    public $taxCalculation;
    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    private $cart;
    /**
     * @var TaxRateRepositoryInterface
     */
    private $taxRateRepository;

    /**
     * Add dynamic message to cart section data
     *
     * @param TaxCalculationInterface $taxCalculation
     * @param ScopeConfigInterface $scopeConfig
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */

    public function __construct(
        TaxCalculationInterface $taxCalculation,
        ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Cart $cart,
        TaxRateRepositoryInterface $taxRateRepository

    ) {
       $this->taxCalculation = $taxCalculation;
       $this->scopeConfig = $scopeConfig;
        $this->cart = $cart;
        $this->taxRateRepository = $taxRateRepository;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function afterGetSectionData(Cart $subject, array $result): array
    {
        $cart = $this->cart;
        $totalQuantity = $cart->getQuote()->getItemsQty();
        $taxRate = $this->taxRateRepository->get(1)->getRate();
        $newTaxRate = preg_replace('/.0000+/','', $taxRate);
        $taxRateProduct = $newTaxRate * $totalQuantity;
        $result['tax'] = $taxRateProduct . ' $';
        return $result;
    }
}
