<?php
namespace DigitalHub\DoubleCheck\Ui\Component\Listing\Column;

class ChangeActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    const URL_PATH_EDIT = 'digitalhub_doublecheck/changes/edit';
    const URL_PATH_DELETE = 'digitalhub_doublecheck/changes/delete';

    protected $urlBuilder;
    private $editUrl;

    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_EDIT,
                                ['id' => $item['id']]
                            ),
                            'label' => __('Editar'),
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_DELETE,
                                ['id' => $item['id']]
                            ),
                            'label' => __('Excluir'),
                            'confirm' => [
                                'title' => __('Excluir "${ $.$data.title }"'),
                                'message' => __('Tem certeza de que deseja excluir este item?'),
                            ],
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
