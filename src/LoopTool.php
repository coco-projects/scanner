<?php

    namespace Coco\scanner;

class LoopTool
{
    public static ?LoopTool $ins   = null;
    protected ?\Redis       $redis = null;

    public function __construct(public string $host = '127.0.0.1', public string $password = '', public int $port = 6379, public int $db = 9)
    {
        $redis = new \Redis();
        $redis->connect($host, $port);
        $password && $redis->auth($password);
        $redis->select($db);

        $this->redis = $redis;
    }

    public static function getIns(string $host = '127.0.0.1', string $password = '', int $port = 6379, int $db = 9)
    {
        if (is_null(static::$ins)) {
            static::$ins = new static($host, $password, $port, $db);
        }

        return static::$ins;
    }

    protected function makeLockKey(string $name): string
    {
        return $name;
    }

    public function stop(string $name): void
    {
        $this->redis->del($this->makeLockKey($name));
    }
}
