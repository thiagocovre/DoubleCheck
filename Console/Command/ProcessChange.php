<?php
namespace DigitalHub\DoubleCheck\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DigitalHub\DoubleCheck\Model\ChangeFactory;

class ProcessChange extends Command
{
    protected $_changeFactory;

    public function __construct(
        ChangeFactory $changeFactory
    ) {
        $this->_changeFactory = $changeFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('digitalhub_doublecheck:process_change')
            ->setDescription('Aprova ou reprova determinada alteração.')
            ->addArgument('change_id', InputArgument::REQUIRED, 'ID da alteração a ser processada.');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $changeId = $input->getArgument('change_id');

        $change = $this->_changeFactory->create()->load($changeId);

        if (!$change->getId()) {
            $output->writeln("Alteração com ID $changeId não encontrada.");
            return;
        }

        // Processar a aprovação ou reprovação da alteração
        // Adicione a lógica conforme necessário

        $output->writeln("Alteração com ID $changeId processada com sucesso.");
    }
}
