<?php

    namespace Coco\scanner\processor;

    use Coco\scanner\abstract\MakerAbastact;
    use Coco\scanner\abstract\ProcessorAbastact;

class DebugProcessor extends ProcessorAbastact
{
    public $callback;

    public function __construct(?callable $callback = null)
    {
        $this->callback = $callback;
    }

    public function process(MakerAbastact $maker): bool
    {
        $data = $maker->getData();

        if (is_callable($this->callback)) {
            $data = call_user_func($this->callback, $data);
        }

        print_r($data);

        return true;
    }
}
