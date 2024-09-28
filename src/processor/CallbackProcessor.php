<?php

    namespace Coco\scanner\processor;

    use Coco\scanner\abstract\MakerAbastact;
    use Coco\scanner\abstract\ProcessorAbastact;

class CallbackProcessor extends ProcessorAbastact
{
    public function __construct(public $callback)
    {
    }

    public function init(?callable $callback = null): static
    {
        if (is_callable($callback)) {
            call_user_func($callback, $this);
        }

        return $this;
    }

    public function process(MakerAbastact $maker): bool
    {
        $data = $maker->getDataResult();

        call_user_func_array($this->callback, [$data,$maker]);

        return true;
    }
}
