<?php

    use Coco\scanner\maker\FilesystemMaker;
    use Coco\scanner\LoopScanner;
    use Coco\scanner\processor\DbProcessor;
    use Coco\scanner\processor\DebugProcessor;
    use Coco\scanner\processor\MoveFileProcessor;
    use Monolog\Logger;
    use Symfony\Component\Finder\Finder;

    require '../vendor/autoload.php';

    $logger = new Logger('my_logger');

    $maker = new FilesystemMaker(dirname(__DIR__) . '/runtime/source');

    $maker->addProcessor(new DebugProcessor(function(Finder $finder) {
        $files = [];

        foreach ($finder as $k => $pathName)
        {
            $files[] = $pathName->getRealPath();
        }

        return $files;
    }));

    $maker->addProcessor(new MoveFileProcessor(function($fileName, $fullSourcePath) {
        return dirname(dirname($fullSourcePath)) . '/dest/' . $fileName;
    }));

    $processor = new DbProcessor(username: 'root', password: 'root', db: 'ithinkphp_telegraph_test1');
    $processor->init(function(\think\DbManager $dbManager, $data) {

        $files = [];

        foreach ($data as $k => $pathName)
        {
            $files[] = $pathName->getRealPath();
        }

        // 实际使用中,这里可能应该是吧 data 插入到 数据库
        echo $dbManager->table('telegraph_media_source_item')->count();
        echo PHP_EOL;
        print_r($files);
        echo PHP_EOL;
        echo PHP_EOL;
    });

    $maker->addProcessor($processor);

    $maker->init(function(string $path, Finder $finder) {
        $finder->depth('< 1')->in($path)->files();
    });

    $scanner = new  LoopScanner($maker, $logger);

    $scanner->setDelayMs(100);

    $scanner->addStdoutLogger();
//    $scanner->addFileLogger('test.log');

    $scanner->listen();