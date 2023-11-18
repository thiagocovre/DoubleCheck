<?php
namespace DigitalHub\DoubleCheck\Controller\Adminhtml\Changes;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use DigitalHub\DoubleCheck\Model\ChangeFactory;

class Index extends Action
{
    protected $_resultPageFactory;
    protected $_changeFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ChangeFactory $changeFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
        $this->_changeFactory = $changeFactory;
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Alterações Pendentes de Aprovação'));

        // Obtenha a solicitação de aprovação (se houver)
        $changeId = $this->getRequest()->getParam('id');
        if ($changeId) {
            $change = $this->_changeFactory->create()->load($changeId);
            if ($change->getId()) {
                // Aprovar a alteração
                $this->approveChange($change);
            }
        }

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('DigitalHub_DoubleCheck::changes');
    }

    protected function approveChange($change)
    {
        // Aplicar o novo valor do atributo "price" no produto em questão
        $product = $this->_objectManager->create(\Magento\Catalog\Model\Product::class)
            ->loadByAttribute('sku', $change->getSku());

        if ($product) {
            $product->setPrice($change->getPendingValue());
            $product->save();

            // Atualizar o status de aprovação na tabela de alterações
            $change->setApprovalStatus(1)->save();
        }
    }
}

