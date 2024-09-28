<?php

    namespace Coco\scanner;

    use Coco\scanner\abstract\ScannerAbastact;

class LoopScanner extends ScannerAbastact
{
    public function listen(): void
    {
        $this->timer->start();

        $this->logInfo('starting loop ...');

        $times = 1;

        while (true) {
            $this->maker->makeMission()->run();
            $this->logInfo("[$times]:" . $this->timer->totalTime() . 'S,' . $this->timer->getTotalMemory() . '/' . $this->timer->getTotalMemoryPeak());

            $times++;
            usleep($this->delayMs * 1000);
        }
    }
}
