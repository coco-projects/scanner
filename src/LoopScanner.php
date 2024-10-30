<?php

    namespace Coco\scanner;

    use Coco\scanner\abstract\ScannerAbastact;

    class LoopScanner extends ScannerAbastact
    {
        public function startListen(): void
        {
            $this->timer->start();

            $this->logInfo('starting loop ...');

            $times = 1;

            while ($this->redis->get($this->makeLockKey()))
            {
                $this->maker->makeMission()->run();
                $this->logInfo("[$times]:" . $this->timer->totalTime() . 'S,' . $this->timer->getTotalMemory() . '/' . $this->timer->getTotalMemoryPeak());

                $times++;
                $this->redis->setex($this->makeLockKey(), 5, 1);
                usleep($this->delayMs * 1000);
            }

            $this->logInfo("[监听被关闭]");

        }
    }
