<?php

    namespace Coco\scanner\abstract;

abstract class ProcessorAbastact
{
    abstract public function process(MakerAbastact $maker): bool;
}
