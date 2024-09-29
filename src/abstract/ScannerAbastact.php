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

    protected int            $delayMs = 100;
    protected Timer          $timer;
    protected ?MakerAbastact $maker   = null;

    public function __construct(?MakerAbastact $maker = null)
    {
        if ($maker instanceof MakerAbastact) {
            $this->setMaker($maker);
        }

        $this->timer = new Timer();
    }

    public function setMaker(MakerAbastact $maker): static
    {
        $this->maker = $maker;
        $this->maker->setScanner($this);

        return $this;
    }

    public function setDelayMs(int $delayMs): static
    {
        $this->delayMs = $delayMs;

        return $this;
    }

    abstract public function listen(): void;
}
