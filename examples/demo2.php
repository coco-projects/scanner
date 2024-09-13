<?php

    use Coco\scanner\maker\DbMaker;
    use Coco\scanner\processor\DebugProcessor;
    use Coco\scanner\LoopScanner;
    use Monolog\Logger;
    use think\DbManager;

    require '../vendor/autoload.php';

    $logger = new Logger('my_logger');

    $maker = new DbMaker(username: 'root', password: 'root', db: 'ithinkphp_telegraph_test1');
    $maker->addProcessor(new DebugProcessor());

    $maker->init(function(DbManager $dbManager) {
        return $dbManager->table('telegraph_media_source_item')->column('url');
    });

    $scanner = new  LoopScanner($maker, $logger);

    $scanner->setDelayMs(100);

    $scanner->addStdoutLogger();
//    $scanner->addFileLogger('test.log');

    $scanner->listen();
