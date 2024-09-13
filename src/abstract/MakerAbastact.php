<?php

    namespace Coco\scanner\abstract;

abstract class MakerAbastact
{
    public array              $processors = [];
    protected mixed           $data;
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

    public function getData(): mixed
    {
        return $this->data;
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
