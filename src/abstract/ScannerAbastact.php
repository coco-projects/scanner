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
        protected string         $name;
        protected Timer          $timer;
        protected ?MakerAbastact $maker   = null;
        protected ?\Redis        $redis   = null;

        public function __construct(?MakerAbastact $maker = null, string $host = '127.0.0.1', string $password = '', int $port = 6379, int $db = 9)
        {
            if ($maker instanceof MakerAbastact)
            {
                $this->setMaker($maker);
            }

            $redis = new \Redis();
            $redis->connect($host, $port);
            $password && $redis->auth($password);
            $redis->select($db);

            $this->redis = $redis;

            $this->timer = new Timer();
            $this->name  = (string)hrtime(true);
        }

        public function setName(string $name): static
        {
            $this->name = $name;

            return $this;
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

        public function listen(): void
        {
            $this->redis->setex($this->makeLockKey(), 5, 1);
            $this->startListen();
        }

        protected function makeLockKey(): string
        {
            return 'scanner:' . $this->name . '';
        }

        abstract public function startListen(): void;
    }
