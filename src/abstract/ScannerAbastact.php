<?php

    namespace Coco\scanner\abstract;

    use Coco\logger\Logger;
    use Psr\Log\LoggerInterface;

abstract class ScannerAbastact
{
    use Logger;

    public int $delayMs = 100;

    public function __construct(protected MakerAbastact $maker, ?LoggerInterface $logger = null)
    {
        $this->setLogger($logger);
        $this->maker->setScanner($this);
    }

    public function setDelayMs(int $delayMs): static
    {
        $this->delayMs = $delayMs;

        return $this;
    }

    abstract public function listen(): void;
}
