<?php
namespace DigitalHub\DoubleCheck\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use DigitalHub\DoubleCheck\Model\Change;
use Magento\Catalog\Model\Product;

class ChangeTest extends TestCase
{
    protected $changeModel;

    protected function setUp(): void
    {
        $this->changeModel = new Change();
    }

    public function testGetId()
    {
        $this->assertNull($this->changeModel->getId());
    }

    public function testIsPendingApproval()
    {
        // Testar se a alteração está pendente de aprovação inicialmente
        $this->assertTrue($this->changeModel->isPendingApproval());

        // Testar se a alteração é marcada como aprovada
        $this->changeModel->setIsApproved(true);
        $this->assertFalse($this->changeModel->isPendingApproval());
    }

    public function testApproveChange()
    {
        // Testar a aprovação de uma alteração
        $this->assertTrue($this->changeModel->isPendingApproval());

        $this->changeModel->approveChange();

        $this->assertFalse($this->changeModel->isPendingApproval());
        $this->assertTrue($this->changeModel->getIsApproved());
    }

    public function testApplyPriceChange()
    {
        // Testar a aplicação de uma alteração de preço
        $product = $this->createMock(Product::class);
        $product->expects($this->once())
            ->method('setPrice')
            ->willReturnCallback(function ($price) {
                $this->assertEquals(10.99, $price); // Verificar se o preço foi definido corretamente
            });

        $this->changeModel->setProduct($product);
        $this->changeModel->setPendingValue(10.99);

        $this->assertTrue($this->changeModel->applyPriceChange());
    }
}

