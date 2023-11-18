<?php
namespace DigitalHub\DoubleCheck\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DigitalHub\DoubleCheck\Model\ResourceModel\Change\CollectionFactory;

class ListChanges extends Command
{
    protected $_changeCollectionFactory;

    public function __construct(
        CollectionFactory $changeCollectionFactory
    ) {
        $this->_changeCollectionFactory = $changeCollectionFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('digitalhub_doublecheck:list_changes')
            ->setDescription('Lista todas as alterações pendentes.');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $changeCollection = $this->_changeCollectionFactory->create()->addFieldToFilter('approval_status', 0);

        foreach ($changeCollection as $change) {
            $output->writeln("ID: " . $change->getId());
            $output->writeln("Nome do Usuário: " . $change->getUserName());
            $output->writeln("SKU: " . $change->getSku());
            $output->writeln("Data e Hora da Solicitação: " . $change->getRequestTime());
            $output->writeln("Nome do Atributo: " . $change->getAttributeName());
            $output->writeln("Valor Anterior: " . $change->getPreviousValue());
            $output->writeln("Valor Pendente de Aprovação: " . $change->getPendingValue());
            $output->writeln("Status de Aprovação: Pendente\n");
        }
    }
}
