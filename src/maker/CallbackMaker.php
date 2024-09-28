<?php

    namespace Coco\scanner\maker;

    use Coco\scanner\abstract\MakerAbastact;

class CallbackMaker extends MakerAbastact
{
    public function __construct(protected $callback)
    {
    }

    public function init(callable $callback): void
    {
        call_user_func_array($callback, [
            $this,
        ]);
    }

    public function makeMission(): static
    {
        $this->dataResult = call_user_func_array($this->callback, []);

        return $this;
    }
}
