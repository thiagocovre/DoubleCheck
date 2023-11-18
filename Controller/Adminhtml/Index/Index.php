<?php
// app/code/DigitalHub/DoubleCheck/Controller/Adminhtml/Index/Index.php
namespace DigitalHub\DoubleCheck\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Digital Hub - Pricing Approval'));

        return $resultPage;
    }
}
