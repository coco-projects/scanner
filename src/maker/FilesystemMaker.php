<?php

    namespace Coco\scanner\maker;

    use Coco\scanner\abstract\MakerAbastact;
    use Symfony\Component\Finder\Finder;

class FilesystemMaker extends MakerAbastact
{
    public Finder $finder;

    public function __construct(protected string $path)
    {
        $this->finder = new Finder();
    }

    public function init(callable $callback): void
    {
        call_user_func_array($callback, [
            $this->path,
            $this->finder,
        ]);
    }

    public function getFinder(): Finder
    {
        return $this->finder;
    }

    public function makeMission(): static
    {
        $this->dataResult = $this->finder;

        return $this;
    }
}
