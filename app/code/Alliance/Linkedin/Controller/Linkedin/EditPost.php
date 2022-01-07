<?php

namespace Alliance\Linkedin\Controller\Linkedin;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerFactory as CustomerResourceFactory;

class EditPost extends Action implements HttpPostActionInterface
{
    /**
     * @var CurrentCustomer
     */
    public $currentCustomer;
    /**
     * @var Customer
     */
    public $customerModel;
    /**
     * @var CustomerResourceFactory
     */
    public $customerResourceFactory;

    /**
     * @param Context $context
     * @param CurrentCustomer $currentCustomer
     * @param Customer $customerModel
     * @param CustomerResourceFactory $customerResourceFactory
     */
    public function __construct(
        Context $context,
        CurrentCustomer $currentCustomer,
        Customer $customerModel,
        CustomerResourceFactory $customerResourceFactory
    )
    {
        parent::__construct($context);
        $this->currentCustomer = $currentCustomer;
        $this->customerModel = $customerModel;
        $this->customerResourceFactory = $customerResourceFactory;
        $this->context = $context;
    }

    public function execute()
    {
        try {
            $option = $_POST['linkedin'] ?? false;
            if ($option){
                $customerId = $this->currentCustomer->getCustomer()->getId();
                $customerNew = $this->customerModel->load($customerId);
                $customerData = $customerNew->getDataModel();
                $customerData->setCustomAttribute('linkedin_profile', $option);
                $customerNew->updateData($customerData);

                $customerResource = $this->customerResourceFactory->create();
                $customerResource->saveAttribute($customerNew,'linkedin_profile');
                $this->_redirect('customer/account/');
            }
        }catch (\Exception $e){
            $this->messageManager->addExceptionMessage($e, __('We can\'t save the company.'));
        }
    }
}
