<?php
namespace DigitalHub\DoubleCheck\Block\Adminhtml\Changes;

use Magento\Backend\Block\Widget\Grid\Container;

class Grid extends Container
{
    protected $_changeCollection;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \DigitalHub\DoubleCheck\Model\ResourceModel\Change\CollectionFactory $changeCollection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_changeCollection = $changeCollection->create();
    }

    protected function _prepareLayout()
    {
        $this->addChild(
            'exportButton',
            \Magento\Backend\Block\Widget\Button::class,
            [
                'label' => __('Exportar CSV'),
                'class' => 'export',
                'id' => 'changesGrid_export_button',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'export', 'target' => '#changesGrid'],
                    ],
                ],
            ]
        );

        return parent::_prepareLayout();
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_changeCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        // Adicione suas colunas aqui
        // ...

        $this->addColumn(
            'action',
            [
                'header' => __('Ação'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Editar'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'id',
            ]
        );

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('change_ids');
        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Excluir'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => __('Tem certeza?'),
            ]
        );

        return $this;
    }
}
