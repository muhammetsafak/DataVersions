<?php

namespace MuhammetSafak\DataVersions;

class Diff
{

    public const REMOVED = 0;
    public const ADDED = 1;
    public const CHANGING = 2;

    private array $diff = [];

    private array $info;

    /**
     * @param array $diff <p>Farklıları tutan dizi.</p>
     * @param array $info <p>Farklılıkların yapıldığı versiyon hakkında bilgileri tutan dizi</p>
     */
    public function __construct(array $diff, array $info = [])
    {
        $this->diff = $diff;
        $this->info = $info;
    }

    public function getDiff(): array
    {
        return $this->diff;
    }

    public function getInfo(): array
    {
        return $this->info;
    }

    public function isDiff(): bool
    {
        return !empty($this->diff);
    }

    public function count(): int
    {
        return count($this->diff);
    }

}
