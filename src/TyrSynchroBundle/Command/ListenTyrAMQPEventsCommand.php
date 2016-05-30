<?php

namespace TyrSynchroBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListenTyrAMQPEventsCommand extends ContainerAwareCommand
{
    /**
     * {@InheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('fenrir:listen-tyr-events')
            ->setDescription('Shortcut for keeping synchronized by listening Tyr event (users creations, updates...)')
        ;
    }

    /**
     * {@InheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Listen Tyr events from AMQP...');

        $command = $this->getApplication()->find('rabbitmq:consumer');

        $commandInput = new ArrayInput(array(
            'name' => 'tyr_event',
            '--without-signals' => true,
        ));

        $command->run($commandInput, $output);
    }
}