<?php
// app/code/DigitalHub/DoubleCheck/Model/GraphQl/Type/PricingApprovalType.php
namespace DigitalHub\DoubleCheck\Model\GraphQl\Type;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Type\Definition\TypeResolverInterface;
use Magento\Framework\GraphQl\Type\Definition\UnionType;
use Magento\Framework\GraphQl\Type\Definition\ObjectType;
use DigitalHub\DoubleCheck\Model\Change;

class PricingApprovalType extends ObjectType
{
    /**
     * @var TypeResolverInterface
     */
    private $typeResolver;

    /**
     * @param TypeResolverInterface $typeResolver
     * @param array $config
     */
    public function __construct(
        TypeResolverInterface $typeResolver,
        array $config = []
    ) {
        $this->typeResolver = $typeResolver;
        parent::__construct($config);
    }

    /**
     * @return ObjectType
     */
    public function buildType()
    {
        return new UnionType([
            'name' => 'PricingApproval',
            'types' => [
                $this->typeResolver->resolve(Change::class),
                // Adicione mais tipos conforme necessário
            ],
            'resolveType' => function ($value) {
                // Implemente a lógica para resolver o tipo com base no valor
                // Neste exemplo, assumimos que $value é uma instância de Change
                return $this->typeResolver->resolve(Change::class);
            },
        ]);
    }
}
