<?php

declare(strict_types=1);

namespace App\UI\Command;

use App\Infrastructure\Client\Telegram\TelegramClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:bot_telegram:poll')]
final class BotTelegramPollCommand extends Command
{
    public function __construct(
        private readonly TelegramClientInterface $telegramClient
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Started telegram bot polling...');
        $lastUpdateId = 0;

        while (true) {
            $botUpdates = $this->telegramClient->getBotUpdates($lastUpdateId);
        }
    }
}
