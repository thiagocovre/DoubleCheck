<?php
namespace DigitalHub\DoubleCheck\Controller\Adminhtml\Changes;

use Magento\Framework\App\ResponseInterface;
use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use DigitalHub\DoubleCheck\Model\ResourceModel\Change\CollectionFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;

class Export extends Action
{
    protected $filter;
    protected $collectionFactory;
    protected $fileFactory;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->fileFactory = $fileFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $content = [];
            $content[] = ['ID', 'Nome do Usuário', 'SKU', 'Data', 'Atributo', 'Valor Anterior', 'Valor Atual'];

            foreach ($collection as $item) {
                $content[] = [
                    $item->getId(),
                    $item->getUserName(),
                    $item->getSku(),
                    $item->getRequestTime(),
                    $item->getAttributeName(),
                    $item->getPreviousValue(),
                    $item->getPendingValue(),
                ];
            }

            $csv = $this->arrayToCsv($content);
            $fileName = 'changes_export.csv';

            $result = $this->fileFactory->create($fileName, $csv, DirectoryList::VAR_DIR);
            return $result;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while exporting the data.'));
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('*/*/');
        }
    }

    private function arrayToCsv($array)
    {
        $csv = '';
        foreach ($array as $line) {
            $csv .= implode(',', $line) . PHP_EOL;
        }
        return $csv;
    }
}
