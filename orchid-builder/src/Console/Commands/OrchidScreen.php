<?php
declare(strict_types=1);

namespace OrchidBuilder\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;


class OrchidScreen extends Command
{
    protected $signature = 'orchid:screen {name}';
    protected $description = 'Создать кастомный экран';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Orchid/Screens/{$name}.php");

        if (file_exists($path)) {
            $this->error("Экран {$name} уже существует!");
            return;
        }

        $stub = file_get_contents(resource_path('stubs/custom-screen.stub'));
        $stub = str_replace('{{ class }}', $name, $stub);

        file_put_contents($path, $stub);
        $this->info("Экран {$name} успешно создан!");
    }
}
