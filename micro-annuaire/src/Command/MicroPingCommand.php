<?php

namespace App\Command;

use App\Entity\MicroService;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'micro:ping',
    description: 'Add a short description for your command',
)]
class MicroPingCommand extends Command
{
    private EntityManagerInterface $em;
    private HttpClientInterface $client;

    public function __construct(EntityManagerInterface $em,
                                HttpClientInterface $client,
                                string $name = null,
    ) {
        parent::__construct($name);
        $this->em = $em;
        $this->client = $client;
    }

    protected function configure(): void
    {
        $this
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $section = $output->section();
        $table = new Table($section);

        $table->setHeaders(['Service', 'Groupe', 'Ping', ' ']);
        $table->render();

        $services = $this->em->getRepository(MicroService::class)->findAll();

        /** @var MicroService $service */
        foreach ($services as $service) {
            $row = [
                $service->service,
                $service->groupe,
                null,
                "😟",
            ];

            if ($service->host == null) {
                $row[2] = "--";
                $table->appendRow($row);
                continue;
            }
            try {
                $url = $service->getUrlToPing();
                $response = $this->client->request(
                    'GET',
                    $url,
                    //['timeout' => 10]
                );
                $code = $response->getStatusCode();
                $time = (int)($response->getInfo("total_time")*100);
                //dump($response);
            }
            catch (\Exception $e) {
                $code = 404;
                $time = null;
            }

            if ($code == 200) {
                $service->ping = $time;
                $row[2] = "$time ms";
                $row[3] = "🙂";
                $table->appendRow($row);
            }
            else {
                $service->ping = null;
                $row[2] = "ERR $code";
                $row[3] = "😟";
                $table->appendRow($row);
            }
        }

        $this->em->flush();

        $io->success('DONE');

        return Command::SUCCESS;
    }
}
