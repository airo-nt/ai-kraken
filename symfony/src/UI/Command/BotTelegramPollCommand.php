<?php

declare(strict_types=1);

namespace App\UI\Command;

use App\Application\Client\Telegram\DTO\BotUpdateResponse;
use App\Application\Client\Telegram\TelegramClientInterface;
use App\Application\Command\ProcessBotUpdateCommand;
use App\Infrastructure\Storage\BotTelegramLastUpdateIdStorage;
use App\Infrastructure\Storage\Exception\CacheStorageException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'app:bot_telegram:poll')]
final class BotTelegramPollCommand extends Command
{
    public function __construct(
        private readonly TelegramClientInterface $telegramClient,
        private readonly BotTelegramLastUpdateIdStorage $storage,
        private readonly MessageBusInterface $bus
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
                    /* @var BotUpdateResponse $botUpdate */
                    foreach ($botUpdates as $botUpdate) {
                        $this->bus->dispatch(
                            new ProcessBotUpdateCommand(
                                $botUpdate->getChatId(),
                                $botUpdate->getText()
                            )
                        );
                        $lastUpdateId = $botUpdate->getUpdateId();
                    }

                    $this->storage->set($lastUpdateId);
                }
            } catch (\Throwable $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
                return Command::FAILURE;
            }
        }
    }
}
