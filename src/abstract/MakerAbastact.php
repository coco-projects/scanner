<?php

    namespace Coco\scanner\abstract;

use Coco\magicAccess\MagicArrayTrait;
use Coco\magicAccess\MagicMethod;

abstract class MakerAbastact
{
    use MagicArrayTrait;
    use MagicMethod;

    public array              $processors = [];
    protected mixed           $dataResult;
    protected ScannerAbastact $scanner;

    abstract public function makeMission(): static;

    public function run(): void
    {
        /**
         * @var ProcessorAbastact $processor
         */
        foreach ($this->processors as $k => $processor) {
            $processor->process($this);
        }
    }

    public function getDataResult(): mixed
    {
        return $this->dataResult;
    }

    public function addProcessor(ProcessorAbastact $processor): void
    {
        $this->processors[] = $processor;
    }

    public function setScanner(ScannerAbastact $scanner): static
    {
        $this->scanner = $scanner;

        return $this;
    }

    public function getScanner(): ScannerAbastact
    {
        return $this->scanner;
    }
}
