<?php

    namespace Coco\scanner;

    use Coco\scanner\abstract\ScannerAbastact;

class LoopScanner extends ScannerAbastact
{
    public function listen(): void
    {
        while (true) {
            $this->maker->makeMission()->run();
            $this->logInfo('looping ...');

            usleep($this->delayMs * 1000);
        }
    }
}
