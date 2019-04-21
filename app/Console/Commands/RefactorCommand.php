<?php

namespace App\Console\Commands;


use Exception;
use ReflectionClass;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RefactorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refactor {--class=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refactor database';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        $class = $this->option('class');
        if (!class_exists($class)) throw new Exception('Invalid refactor class: ' . $class);

        $reflectionClass = (new ReflectionClass($class));
        if (!$reflectionClass->hasMethod('run')) {
            throw new Exception('Method run does not exist on: ' . $class);
        }
        (new $class)->run();
    }

    protected function getOptions()
    {
        return [
            ['class', null, InputOption::VALUE_REQUIRED, 'The path of the route to be called', null]
        ];
    }
}