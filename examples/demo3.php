<?php

    use Coco\scanner\maker\CallbackMaker;
    use Coco\scanner\LoopScanner;
    use Coco\scanner\processor\CallbackProcessor;

    require '../vendor/autoload.php';

    /*-------------------------------------------*/
    $maker = new CallbackMaker(function() {

        return time();
    });

    /*-------------------------------------------*/
    $maker->init(function(CallbackMaker $maker_) {
        $maker_->aaa      = 'aaa';
        $maker_->bbb      = [];
        $maker_->bbb['a'] = 123;
    });

    /*-------------------------------------------*/
    $maker->addProcessor(new CallbackProcessor(function($data, CallbackMaker $maker_) {
        echo $maker_->aaa . '-' . $maker_->bbb['a'] . '-' . $data;
        echo PHP_EOL;
    }));

    /*-------------------------------------------*/
    $scanner = new  LoopScanner($maker);
    $scanner->setDelayMs(1000);
    $scanner->setStandardLogger('test');
    $scanner->addStdoutHandler(callback: $scanner::getStandardFormatter());
    $scanner->setName('test111');

    $scanner->listen();


