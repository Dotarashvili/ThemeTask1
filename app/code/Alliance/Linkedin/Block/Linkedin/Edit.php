<?php

namespace Alliance\Linkedin\Block\Linkedin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Store\Model\ScopeInterface;


class Edit extends Template
{
    private $data;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var CurrentCustomer
     */
    private $currentCustomer;

    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @param Context $context
     * @param CurrentCustomer $currentCustomer
     * @param array $data
     */
    public function __construct(
        Context $context,
        CurrentCustomer $currentCustomer,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->data = $data;
        $this->context = $context;
        $this->currentCustomer = $currentCustomer;
        $this->scopeConfig = $scopeConfig;
    }

    public function getLinkedinInformation()
    {
        if ($this->currentCustomer->getCustomer()->getCustomAttribute('linkedin_profile') != null) {
            try {
                $linkedin = $this->currentCustomer->getCustomer()->getCustomAttribute('linkedin_profile')->getValue();
            } catch (NoSuchEntityException $e) {
                return $this->escapeHtml(__('You have not set a Linkedin Profile.'));
            }
            if ($linkedin) {
                return $linkedin;
            } else {
                return $this->escapeHtml(__('You have not set a Linkedin Profile.'));
            }
        }
    }

    public function getVisibilityValue()
    {
       return $this->scopeConfig->getValue('linkedin_config/general/visibility', ScopeInterface::SCOPE_STORE);
    }

    public function getReqValue()
    {
        return $this->scopeConfig->getValue('linkedin_config/general/required', ScopeInterface::SCOPE_STORE);
    }
}
