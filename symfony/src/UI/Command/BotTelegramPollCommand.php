<?php

declare(strict_types=1);

namespace App\UI\Command;

use App\Infrastructure\Client\Telegram\TelegramClientInterface;
use App\Infrastructure\Storage\BotTelegramLastUpdateIdStorage;
use App\Infrastructure\Storage\Exception\CacheStorageException;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:bot_telegram:poll')]
final class BotTelegramPollCommand extends Command
{
    public function __construct(
        private readonly TelegramClientInterface $telegramClient,
        private readonly BotTelegramLastUpdateIdStorage $storage
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Started telegram bot polling...');

        try {
            $lastUpdateId = $this->storage->get();
        } catch (CacheStorageException) {
            $output->writeln('<error>Failed to read lastUpdateId from cache.</error>');
            return Command::FAILURE;
        }

        while (true) {
            try {
                $botUpdates = $this->telegramClient->getBotUpdates($lastUpdateId);

                if ($botUpdates->hasUpdates()) {
                    foreach ($botUpdates as $botUpdate) {
                        $lastUpdateId = $botUpdate->getUpdateId();
                    }
                    $this->storage->set($lastUpdateId);
                }
            } catch (Exception $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
                return Command::FAILURE;
            }
        }
    }
}
