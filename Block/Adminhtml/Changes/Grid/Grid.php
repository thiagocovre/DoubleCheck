<?php
namespace DigitalHub\DoubleCheck\Block\Adminhtml\Changes\Grid;

use Magento\Backend\Block\Widget\Grid\Extended;

class Grid extends Extended
{
    protected $_changeCollection;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \DigitalHub\DoubleCheck\Model\ResourceModel\Change\Collection $changeCollection,
        array $data = []
    ) {
        $this->_changeCollection = $changeCollection;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _prepareCollection()
    {
        $this->setCollection($this->_changeCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'index' => 'id',
            ]
        );

        $this->addColumn(
            'user_name',
            [
                'header' => __('Nome do Usuário'),
                'index' => 'user_name',
            ]
        );

        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku',
            ]
        );

        $this->addColumn(
            'request_time',
            [
                'header' => __('Data e Hora da Solicitação'),
                'index' => 'request_time',
                'type' => 'datetime',
            ]
        );

        $this->addColumn(
            'attribute_name',
            [
                'header' => __('Nome do Atributo'),
                'index' => 'attribute_name',
            ]
        );

        $this->addColumn(
            'previous_value',
            [
                'header' => __('Valor Anterior'),
                'index' => 'previous_value',
                'type' => 'price',
            ]
        );

        $this->addColumn(
            'pending_value',
            [
                'header' => __('Valor Pendente de Aprovação'),
                'index' => 'pending_value',
                'type' => 'price',
            ]
        );

        $this->addColumn(
            'approval_status',
            [
                'header' => __('Status de Aprovação'),
                'index' => 'approval_status',
                'type' => 'options',
                'options' => [
                    0 => __('Pendente'),
                    1 => __('Aprovado'),
                ],
            ]
        );

        $this->addColumn(
            'action',
            [
                'header' => __('Ação'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Aprovar'),
                        'url' => ['base' => '*/*/approve'],
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
}
