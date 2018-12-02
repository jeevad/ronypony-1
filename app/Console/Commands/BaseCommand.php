<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just Base Command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }

    /**
     * Exec sheel with pretty print.
     *
     * @param string $command
     * @return mixed
     */
    public function execShellWithPrettyPrint($command)
    {
        $this->info('---');
        $this->info('Running command: ' . $command);
        $output = shell_exec($command);
        $this->info($output);
        $this->info('---');
    }
}
