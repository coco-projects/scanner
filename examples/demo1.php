<?php

    use Coco\scanner\maker\FilesystemMaker;
    use Coco\scanner\LoopScanner;
    use Coco\scanner\processor\DbProcessor;
    use Coco\scanner\processor\DebugProcessor;
    use Coco\scanner\processor\MoveFileProcessor;
    use Symfony\Component\Finder\Finder;

    require '../vendor/autoload.php';

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

    $scanner = new  LoopScanner($maker);

    $scanner->setDelayMs(300);

    $scanner->setStandardLogger('test');

    $scanner->addStdoutHandler(callback: function(\Monolog\Handler\StreamHandler $handler, LoopScanner $_this) {
        $handler->setFormatter(new \Coco\logger\MyFormatter());
    });


    $scanner->listen();
