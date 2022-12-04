<?php

namespace MuhammetSafak\DataVersions;

class Version
{

    private string $id;

    private int $time;

    private array $data = [];

    private array $info = [];

    public function __construct(array $data, array $info = [], ?string $id = null, ?int $time = null)
    {
        $this->id = $id ?? uniqid();
        $this->time = $time ?? time();

        $this->data = $data;
        $this->info = $info;
    }

    public function getID(): string
    {
        return $this->id;
    }

    public function toJSON(): string
    {
        return json_encode($this->data);
    }

    public function getDate(string $format = 'c'): string
    {
        return date($format, $this->time);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getInfo(): array
    {
        return $this->info;
    }

    public function diff(Version $nextVersion): Diff
    {
        $thisData = $this->getData();
        $versionData = $nextVersion->getData();

        $diff = [];

        foreach ($versionData as $key => $value) {
            if (!array_key_exists($key, $thisData)) {
                $diff[] = [
                    'name'      => $key,
                    'value'     => $value,
                    'type'      => Diff::ADDED,
                ];
            }
        }

        foreach ($thisData as $key => $value) {

            if (!array_key_exists($key, $versionData)) {
                $diff[] = [
                    'name'      => $key,
                    'value'     => $value,
                    'type'      => Diff::REMOVED,
                ];
                continue;
            }

            if ($value != $versionData[$key]) {
                $diff[] = [
                    'name'      => $key,
                    'value'     => [
                        $value, // Old
                        $versionData[$key], // New
                    ],
                    'type'      => Diff::CHANGING,
                ];
            }

        }

        return new Diff($diff, $nextVersion->getInfo());
    }

}
