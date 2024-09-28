<?php

    namespace Coco\scanner\abstract;

use Coco\magicAccess\MagicArrayTrait;
use Coco\magicAccess\MagicMethod;

abstract class ProcessorAbastact
{
    use MagicArrayTrait;
    use MagicMethod;

    abstract public function process(MakerAbastact $maker): bool;
}
