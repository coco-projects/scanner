<?php

    namespace Coco\scanner\processor;

    use Coco\scanner\abstract\MakerAbastact;
    use Coco\scanner\abstract\ProcessorAbastact;

class MoveFileProcessor extends ProcessorAbastact
{
    private $targetCallback;

    public function __construct($targetCallback)
    {
        $this->targetCallback = $targetCallback;
    }

    public function process(MakerAbastact $maker): bool
    {
        $finder = $maker->getDataResult();

        foreach ($finder as $k => $pathName) {
            $fullSourcePath = $pathName->getRealPath();

            if (is_dir($fullSourcePath)) {
                $maker->getScanner()->logInfo(implode('', [
                    'skip: ',
                    $fullSourcePath,
                    PHP_EOL,
                ]));
                continue;
            }

            $targetPath = call_user_func_array($this->targetCallback, [
                $pathName->getFilename(),
                $fullSourcePath,
            ]);

            is_dir(dirname($targetPath)) or mkdir(dirname($targetPath), 777, 1);

            $maker->getScanner()->logInfo(implode('', [
                'move: ',
                $fullSourcePath,
                ' -> ',
                $targetPath,
                PHP_EOL,
            ]));

            rename($fullSourcePath, $targetPath);
        }

        return true;
    }
}
