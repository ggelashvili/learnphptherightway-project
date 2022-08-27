<?php

declare(strict_types = 1);

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends Command
{
    protected static $defaultName        = 'app:my-command';
    protected static $defaultDescription = 'My Command';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write('Hello World', true);

        return Command::SUCCESS;
    }
}
