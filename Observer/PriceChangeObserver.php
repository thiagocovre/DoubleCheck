<?php
namespace DigitalHub\DoubleCheck\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\State;
use Magento\Framework\App\ObjectManager;

class PriceChangeObserver implements ObserverInterface
{
    protected $_transportBuilder;
    protected $_inlineTranslation;
    protected $_storeManager;
    protected $_scopeConfig;
    protected $_appState;

    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        State $appState
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_appState = $appState;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();

        // Verifique se a alteração é no atributo "PRICE"
        if ($product->getOrigData('price') != $product->getPrice()) {
            $this->sendEmailNotification($product);
        }
    }

    protected function sendEmailNotification($product)
    {
        $storeId = $this->_storeManager->getStore()->getId();

        // Verificar se o envio de e-mail está ativado
        $isEmailEnabled = $this->_scopeConfig->getValue(
            'digitalhub_doublecheck/email_notification/enabled',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (!$isEmailEnabled) {
            return;
        }

        // Configurar destinatário de e-mail
        $recipientEmail = $this->_scopeConfig->getValue(
            'digitalhub_doublecheck/email_notification/recipient_email',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (!$recipientEmail) {
            return;
        }

        try {
            $this->_appState->setAreaCode('frontend');

            $this->_inlineTranslation->suspend();

            $transport = $this->_transportBuilder
                ->setTemplateIdentifier('digitalhub_doublecheck_price_change_template') // Configurável no painel administrativo
                ->setTemplateOptions([
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $storeId,
                ])
                ->setTemplateVars(['product' => $product])
                ->setFrom(['email' => 'sender@example.com', 'name' => 'Sender'])
                ->addTo($recipientEmail)
                ->getTransport();

            $transport->sendMessage();

            $this->_inlineTranslation->resume();
        } catch (\Exception $e) {
            // Lidar com exceções, se necessário
        }
    }
}
