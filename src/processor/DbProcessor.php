<?php

    namespace Coco\scanner\processor;

    use Coco\scanner\abstract\MakerAbastact;
    use Coco\scanner\abstract\ProcessorAbastact;
    use think\DbManager;

class DbProcessor extends ProcessorAbastact
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
        $this->callback = function ($data) use ($callback) {
            return call_user_func_array($callback, [
                $this->dbManager,
                $data,
            ]);
        };
    }

    public function process(MakerAbastact $maker): bool
    {
        $data = $maker->getData();

        call_user_func($this->callback, $data);

        return true;
    }
}
