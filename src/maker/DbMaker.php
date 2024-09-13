<?php

    namespace Coco\scanner\maker;

    use Coco\scanner\abstract\MakerAbastact;
    use think\DbManager;

class DbMaker extends MakerAbastact
{
    public DbManager $dbManager;
    public $callback;

    public function __construct($username, $password, $db, $host = '127.0.0.1', $port = 3306)
    {
        $config = [
            'default'     => 'db',
            'connections' => [
                'db' => [
                    'type'     => 'mysql',
                    'hostname' => $host,
                    'password' => $username,
                    'username' => $password,
                    'database' => $db,
                    'charset'  => 'utf8mb4',
                    'hostport' => $port,
                    'prefix'   => '',
                    'debug'    => true,
                ],
            ],
        ];

        $this->dbManager = new DbManager();
        $this->dbManager->setConfig($config);
        $this->dbManager->connect();
    }

    public function init(callable $callback): void
    {
        $this->callback = function () use ($callback) {
            return call_user_func_array($callback, [
                $this->dbManager,
            ]);
        };
    }

    public function makeMission(): static
    {
        $this->data = call_user_func_array($this->callback, []);

        return $this;
    }
}
