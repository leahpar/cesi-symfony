<?php

namespace App\Command;

use App\Service\CommsService;
use App\Service\ModerationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'micro:moderator',
    description: 'Add a short description for your command',
)]
class MicroModeratorCommand extends Command
{
    private CommsService $commsService;
    private ModerationService $moderationService;

    public function __construct(CommsService $commsService, ModerationService $moderationService, string $name = null)
    {
        parent::__construct($name);
        $this->commsService = $commsService;
        $this->moderationService = $moderationService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $comms = $this->commsService->getComms();

        foreach ($comms as $k => $commentaire) {
            $io->writeln("Commentaire $k");
            $text = $this->moderationService->moderate($commentaire['comment']);
            dump($text);
            $this->commsService->updateComm(
                $commentaire['id'],
                $text,
                true,
            );
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
