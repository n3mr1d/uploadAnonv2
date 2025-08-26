<?php


error_reporting(E_ERROR | E_PARSE);

define('LARAVEL_START', microtime(true));

require_once __DIR__ . '/../autoload.php';

class LaravelVsCode
{
    public static function relativePath($path)
    {
        if (!str_contains($path, base_path())) {
            return (string) $path;
        }

        return ltrim(str_replace(base_path(), '', realpath($path) ?: $path), DIRECTORY_SEPARATOR);
    }

    public static function isVendor($path)
    {
        return str_contains($path, base_path("vendor"));
    }

    public static function outputMarker($key)
    {
        return '__VSCODE_LARAVEL_' . $key . '__';
    }

    public static function startupError(\Throwable $e)
    {
        throw new Error(self::outputMarker('STARTUP_ERROR') . ': ' . $e->getMessage());
    }
}

try {
    $app = require_once __DIR__ . '/../../bootstrap/app.php';
} catch (\Throwable $e) {
    LaravelVsCode::startupError($e);
    exit(1);
}

$app->register(new class($app) extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        config([
            'logging.channels.null' => [
                'driver' => 'monolog',
                'handler' => \Monolog\Handler\NullHandler::class,
            ],
            'logging.default' => 'null',
        ]);
    }
});

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
} catch (\Throwable $e) {
    LaravelVsCode::startupError($e);
    exit(1);
}

echo LaravelVsCode::outputMarker('START_OUTPUT');

$blade = new class {
    public function getAllViews()
    {
        $finder = app("view")->getFinder();

        $paths = collect($finder->getPaths())->flatMap(fn($path) => $this->findViews($path));

        $hints = collect($finder->getHints())->flatMap(
            fn($paths, $key) => collect($paths)->flatMap(
                fn($path) => collect($this->findViews($path))->map(
                    fn($value) => array_merge($value, ["key" => "{$key}::{$value["key"]}"])
                )
            )
        );

        [$local, $vendor] = $paths
            ->merge($hints)
            ->values()
            ->partition(fn($v) => !$v["isVendor"]);

        return $local
            ->sortBy("key", SORT_NATURAL)
            ->merge($vendor->sortBy("key", SORT_NATURAL));
    }

    public function getAllComponents()
    {
        $namespaced = \Illuminate\Support\Facades\Blade::getClassComponentNamespaces();
        $autoloaded = require base_path("vendor/composer/autoload_psr4.php");
        $components = [];

        foreach ($namespaced as $key => $ns) {
            $path = null;

            foreach ($autoloaded as $namespace => $paths) {
                if (str_starts_with($ns, $namespace)) {
                    foreach ($paths as $p) {
                        $test = str($ns)->replace($namespace, '')->replace('\\', '/')->prepend($p . DIRECTORY_SEPARATOR)->toString();

                        if (is_dir($test)) {
                            $path = $test;
                            break;
                        }
                    }

                    break;
                }
            }

            if (!$path) {
                continue;
            }

            $files = \Symfony\Component\Finder\Finder::create()
                ->files()
                ->name("*.php")
                ->in($path);

            foreach ($files as $file) {
                $realPath = $file->getRealPath();

                $components[] = [
                    "path" => str_replace(base_path(DIRECTORY_SEPARATOR), '', $realPath),
                    "isVendor" => str_contains($realPath, base_path("vendor")),
                    "key" =>  str($realPath)
                        ->replace(realpath($path), "")
                        ->replace(".php", "")
                        ->ltrim(DIRECTORY_SEPARATOR)
                        ->replace(DIRECTORY_SEPARATOR, ".")
                        ->kebab()
                        ->prepend($key . "::"),
                ];
            }
        }

        return $components;
    }

    protected function findViews($path)
    {
        $paths = [];

        if (!is_dir($path)) {
            return $paths;
        }

        $files = \Symfony\Component\Finder\Finder::create()
            ->files()
            ->name("*.blade.php")
            ->in($path);

        foreach ($files as $file) {
            $paths[] = [
                "path" => str_replace(base_path(DIRECTORY_SEPARATOR), '', $file->getRealPath()),
                "isVendor" => str_contains($file->getRealPath(), base_path("vendor")),
                "key" => str($file->getRealPath())
                    ->replace(realpath($path), "")
                    ->replace(".blade.php", "")
                    ->ltrim(DIRECTORY_SEPARATOR)
                    ->replace(DIRECTORY_SEPARATOR, ".")
            ];
        }

        return $paths;
    }
};

echo json_encode($blade->getAllViews()->merge($blade->getAllComponents()));

echo LaravelVsCode::outputMarker('END_OUTPUT');

exit(0);
