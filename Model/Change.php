<?php
namespace DigitalHub\DoubleCheck\Model;

use Magento\Catalog\Model\Product;
use Magento\Framework\Model\AbstractModel;

class Change extends AbstractModel
{
    const ATTRIBUTE_PRICE = 'price';

    /**
     * Verifique se a alteração é válida antes de salvar
     *
     * @return bool
     */
    public function isValidChange()
    {
        // Verifique se a alteração é no atributo "price"
        if ($this->getAttributeName() !== self::ATTRIBUTE_PRICE) {
            // Se não for uma alteração de preço, permita a alteração
            return true;
        }

        // Lógica de validação específica para o atributo "price"
        // Por exemplo, permitir a alteração apenas se o valor pendente for maior que zero
        return $this->getPendingValue() > 0;
    }

    /**
     * Executado antes de salvar o modelo
     *
     * @return $this
     */
    public function beforeSave()
    {
        parent::beforeSave();

        // Se a alteração não for válida, não prossiga com o salvamento
        if (!$this->isValidChange()) {
            return $this;
        }

        // Se a alteração for aprovada, aplique a alteração ao produto
        if ($this->getIsApproved()) {
            $this->applyPriceChange();
        }

        return $this;
    }

    /**
     * Aplicar a alteração de preço ao produto
     *
     * @return void
     */
    public function applyPriceChange()
    {
        if ($this->getIsApproved()) {
            $product = $this->getProduct();

            if ($product instanceof Product) {
                $newPrice = $this->getPendingValue();
                $product->setPrice($newPrice);
                $product->save(); // Salvar o produto após a alteração de preço
                // Adicione qualquer outra lógica necessária para aplicar a alteração de preço
            }
        }
    }
}
