<?php
// app/code/DigitalHub/DoubleCheck/Model/GraphQl/Query/PricingApprovalQuery.php
namespace DigitalHub\DoubleCheck\Model\GraphQl\Query;

use Magento\Framework\GraphQl\Query\QueryInterface;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\TypeResolver;
use DigitalHub\DoubleCheck\Model\Change;
use DigitalHub\DoubleCheck\Model\ChangeFactory;

class PricingApprovalQuery implements QueryInterface
{
    /**
     * @var ValueFactory
     */
    private $valueFactory;

    /**
     * @var ChangeFactory
     */
    private $changeFactory;

    /**
     * @param ValueFactory $valueFactory
     * @param ChangeFactory $changeFactory
     */
    public function __construct(
        ValueFactory $valueFactory,
        ChangeFactory $changeFactory
    ) {
        $this->valueFactory = $valueFactory;
        $this->changeFactory = $changeFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute(array $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        return $this->valueFactory->create(
            function () {
                $pricingApprovalData = $this->getPricingApprovalData();
                return [
                    'pricingApproval' => $pricingApprovalData,
                ];
            }
        );
    }

    /**
     * Get pricing approval data
     *
     * @return array
     */
    private function getPricingApprovalData()
    {
        // Implemente a lógica para buscar e retornar os dados de aprovação de preços
        // Este é um exemplo básico, adapte conforme necessário

        $changes = $this->changeFactory->create()->getCollection();
        $pricingApprovalData = [];

        foreach ($changes as $change) {
            $pricingApprovalData[] = [
                'id' => $change->getId(),
                'user_name' => $change->getUserName(),
                'sku' => $change->getSku(),
                'date' => $change->getDate(),
                'attribute' => $change->getAttributeName(),
                'old_value' => $change->getOldValue(),
                'new_value' => $change->getPendingValue(),
                'is_approved' => $change->getIsApproved(),
            ];
        }

        return $pricingApprovalData;
    }
}
