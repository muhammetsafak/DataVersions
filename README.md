# Data Versions and Differance

This library was written to version data and calculate differences between historical versions.

## Requirements

- PHP 7.4 or later

## Installation

```
composer require muhammetsafak/data-versions
```

## Usage

```php
require_once 'vendor/autoload.php';
use \MuhammetSafak\DataVersions\{Version, Diff};

/** @var Version[] $versions */
$versions = [
    new Version(['name' => 'Muhammet', 'surname' => 'Şafak'], ['user' => 10]),
    new Version(['name' => 'Muhammet', 'surname' => 'Şafak'], ['user' => 12]),
    new Version(['name' => 'Muhammet', 'surname' => 'Şafak', 'age' => 30], ['user' => 5]),
    new Version(['name' => 'Ahmet', 'surname' => 'Şafak'], ['user' => 7]),
];

$compare = new Version(['name' => 'Muhammet'], ['user' => 1]);
foreach ($versions as $version) {
    echo '<h2>' . $version->getID() . ' Changer: #' . $version->getInfo()['user'] . '</h2>';
    
    $diff = $compare->diff($version);
    
    if ($diff->isDiff()) {
        echo '<ul>' . PHP_EOL;
        foreach ($differences as $difference) {
            echo '<li>' . $difference['name'] . ' : ';
            switch ($difference['type']) {
                case Diff::ADDED:
                    echo ' added "' . $difference['value'] . '"';
                    break;
                case Diff::CHANGING:
                    echo '"' . $difference['value'][0] . '" has been replaced with; "' .$difference['value'][1] . '"';
                    break;
                case Diff::REMOVED:
                    echo ' removed "' . $difference['value'] . '"';
                    break;
            }
            echo '</li>' . PHP_EOL;
        }
        echo '</ul>';
    } else {
        echo 'It does not contain any changes.';
    }
    
    
    $compare = $version;
}
```

# Structures

```php
namespace MuhammetSafak\DataVersions;

class Version
{
    public function __construct(array $data, array $info = [], ?string $id = null, ?int $time = null);
    public function getID(): string;
    public function toJSON(): string;
    public function getDate(string $format = 'c'): string;
    public function getData(): array;
    public function getInfo(): array;
    public function diff(\MuhammetSafak\DataVersions\Version $nextVersion): \MuhammetSafak\DataVersions\Diff;
}

class Diff
{
    public const REMOVED = 0;
    public const ADDED = 1;
    public const CHANGING = 2;
    
    public function __construct(array $diff, array $info = []);
    public function getDiff(): array;
    public function getInfo(): array;
    public function isDiff(): bool;
    public function count(): int;
}
```

## Credits

- [Muhammet ŞAFAK](https://www.muhammetsafak.com.tr) <<info@muhammetsafak.com.tr>>

## License

Copyright &copy; 2022 [MIT Licence](./LICENSE)
