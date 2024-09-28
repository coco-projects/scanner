<?php

    namespace Coco\scanner\abstract;

    use Coco\logger\Logger;
    use Coco\magicAccess\MagicArrayTrait;
    use Coco\magicAccess\MagicMethod;
    use Coco\timer\Timer;

abstract class ScannerAbastact
{
    use Logger;
    use MagicArrayTrait;
    use MagicMethod;

    protected int   $delayMs = 100;
    protected Timer $timer;

    public function __construct(protected MakerAbastact $maker)
    {
        $this->maker->setScanner($this);
        $this->timer = new Timer();
    }

    public function setDelayMs(int $delayMs): static
    {
        $this->delayMs = $delayMs;

        return $this;
    }

    abstract public function listen(): void;
}
