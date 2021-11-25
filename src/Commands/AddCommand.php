<?php
namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Repositories\StorageRepository;
use Symfony\Component\Console\Input\InputArgument;

class AddCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description = 'Command description';

    protected static $defaultName = 'add';

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
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );

        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));
        $this->addArgument('numbers',InputArgument::IS_ARRAY,sprintf('The number to be %s', ucfirst($getCommandPassiveVerb)));
    }

    protected function getCommandVerb(): string
    {
        return 'add';
    }

        protected function getCommandPassiveVerb(): string
    {
        return 'added';
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);

        $this->limitLatest();
        $this->historyLogLatest($result);
        $this->historyLogFile($result);
        $this->historyLogComposite($result);

        $this->comment(sprintf('%s = %s', $description, $result));
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return '+';
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 + $number2;
    }

    protected function historyLogComposite($result) {
        $this->storageService->historyLogComposite([
            'id' => uniqid(),
            'command' => $this->getCommandVerb(),
            'operation' => $this->getOperator(),
            'input' => $this->getInput(),
            'result' => $result,
        ]);
    }

    protected function historyLogFile($result){
        $this->storageService->historyLogFile([
            'id' => uniqid(),
            'command' => $this->getCommandVerb(),
            'operation' => $this->getOperator(),
            'input' => $this->getInput(),
            'result' => $result,
        ]);
    }

    protected function historyLogLatest($result){
        $this->storageService->historyLogLatest([
            'id' => uniqid(),
            'command' => $this->getCommandVerb(),
            'operation' => $this->getOperator(),
            'input' => $this->getInput(),
            'result' => $result,
        ]);
    }

    protected function limitLatest(){
        $path = 'storage/Latest/latest.log';
        $fdata = file_get_contents($path);
        $stringArr = explode("\n", $fdata);
        $tampung = [];
        foreach($stringArr as $key => $value){
            $encode = json_decode($value);
            if($encode != null) {
                $tampung[] = $encode;
                if(count($tampung) >= 10){
                    unset($tampung);
                    $numbers = $this->getInput();
                    $result = $this->calculateAll($numbers);
                    file_put_contents($path,$this->historyLogLatest($result));
                }
            }
        }
    }

}
