<?php

    namespace Coco\scanner\processor;

class DebugProcessor extends CallbackProcessor
{
    public function __construct(?callable $callback = null)
    {
        parent::__construct(function ($data) use ($callback) {

            if (is_callable($callback)) {
                $data = call_user_func($callback, $data);
            }

            print_r($data);
        });
    }
}
