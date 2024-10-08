<?php

    use Coco\scanner\maker\DbMaker;
    use Coco\scanner\processor\DebugProcessor;
    use Coco\scanner\LoopScanner;
    use Monolog\Logger;
    use think\DbManager;

    require '../vendor/autoload.php';

    $maker = new DbMaker(username: 'root', password: 'root', db: 'ithinkphp_telegraph_test1');
    $maker->addProcessor(new DebugProcessor());

    $maker->init(function(DbManager $dbManager) {
        return $dbManager->table('telegraph_media_source_item')->where('id','<',10)->column('url');
    });

    $scanner = new  LoopScanner($maker);

    $scanner->setDelayMs(100);

    $scanner->setStandardLogger('test');

    $scanner->addStdoutHandler(callback: $scanner::getStandardFormatter());

    $scanner->listen();
