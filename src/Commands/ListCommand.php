<?php
namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Repositories\StorageRepository;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description = 'Command description';

    protected static $defaultName = 'history:list';

    private $storageService;

    public function __construct(StorageRepository $storageRepository)
    {
        parent::__construct();
        $this->storageService = $storageRepository;
    }

    public function configure() {
        $commandVerb = $this->getCommandVerb();
        $getCommandPassiveVerb = $this->getCommandPassiveVerb();

        $this->signature = sprintf(
            '%s {filters* : The filters to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );

        $this->description = sprintf('%s all given filters', ucfirst($commandVerb));
        $this->addArgument('filters',InputArgument::IS_ARRAY,sprintf('The number to be %s', ucfirst($getCommandPassiveVerb)));
        $this->addOption(
                'driver',
                null,
                InputOption::VALUE_REQUIRED,
                'How many times should the message be printed?',
                1
            );
    }

    protected function getCommandVerb(): string
    {
        return 'history';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'histories';
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->requestCommand();
        $id = $this->requestId();
        $driver = $this->requestDriver();
        $this->getDataList($output,$command,$id,$driver);
    }

    protected function getOption(): string
    {
        return $this->option('driver');
    }

    protected function getInput(): array
    {
        return $this->argument('filters');
    }

    protected function getDataList($output,$command,$id,$driver) {
        $datas = $this->storageService->getList($command,$id,$driver);

        $table = new Table($output);
        $table
            ->setHeaders(['Id', 'Command', 'Operation', 'Input', 'Result', 'Name Driver'])
            ->setRows($datas)
        ;
        $table->render();
    }

    protected function requestCommand() {
        $command = $this->getInput()[0] ?? null;
        return $command;
    }

    protected function requestId() {
        $id = $this->getInput()[1] ?? null;
        return $id;
    }

    protected function requestDriver() {
     $driver = $this->getOption() ?? null;
     return $driver;
    }
}
