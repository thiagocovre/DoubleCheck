<?php
namespace DigitalHub\DoubleCheck\Plugin;

use DigitalHub\DoubleCheck\Model\ChangeFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\CouldNotSaveException;

class ProductSave
{
    protected $_changeFactory;
    protected $_productRepository;

    public function __construct(
        ChangeFactory $changeFactory,
        ProductRepository $productRepository
    ) {
        $this->_changeFactory = $changeFactory;
        $this->_productRepository = $productRepository;
    }

    public function beforeSave(Product $product)
    {
        $origProduct = $this->_productRepository->getById($product->getId());

        // Verifique se a alteração é no atributo "PRICE"
        if ($product->getPrice() != $origProduct->getPrice()) {
            // Bloqueie a modificação imediata
            throw new CouldNotSaveException(__('As alterações de preço requerem aprovação.'));
        }

        return [$product];
    }

    public function afterSave(Product $product)
    {
        // Verifique se a alteração é no atributo "PRICE"
        if ($product->getOrigData('price') != $product->getPrice()) {
            // Salve a tentativa de alteração na grid para aprovação
            $change = $this->_changeFactory->create();
            $change->setUserName('Nome do Usuário'); // Substitua pelo nome do usuário real
            $change->setSku($product->getSku());
            $change->setRequestTime(date('Y-m-d H:i:s'));
            $change->setAttributeName('price');
            $change->setPreviousValue($product->getOrigData('price'));
            $change->setPendingValue($product->getPrice());
            $change->save();
        }

        return $product;
    }
}
