<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use Laravel\Lumen\Application;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    public function __construct(Application $app)
    {
        parent::__construct($app);
        self::load_commands();
    }

    private function load_commands() {
        $paths = [
            __DIR__.DIRECTORY_SEPARATOR.'Commands'
        ];
        $paths = array_unique(is_array($paths) ? $paths : (array) $paths);

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = 'App\\';
        foreach ((new Finder)->in($paths)->files() as $command) {

            $command = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getPathname(), app('path').DIRECTORY_SEPARATOR)
                );
            if (is_subclass_of($command, Command::class) &&
                ! (new ReflectionClass($command))->isAbstract()) {
                array_push($this->commands, $command);
            }
        }
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
