<?php

namespace App\Console\Commands;

class Deploy extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:deploy';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactive application deploy helper';

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
        $inputBranch = $this->ask('Specify Git branch to deploy');
        $productionBranch = 'master';
        if (is_production() && $inputBranch !== 'master') {
            $this->line('Production should always be associted with ' . $productionBranch . ' branch.');
            $this->line('Exiting...');
            exit;
        }
        $this->execGitCommands(['branch' => $inputBranch]);
    }

    /**
     * Execute the commands to deploy code
     *
     * @param array $options
     */
    public function execGitCommands(array $options = [])
    {
        $commands = $this->commands($options);
        foreach ($commands as $command) {
            $this->execShellWithPrettyPrint($command);
        }
    }

    public function commands(array $options = [])
    {
        return [
            'down' => 'php artisan down',
            'checkout' => 'git checkout -f ' . $options['branch'],
            'pull' => 'git fetch && git pull -f origin ' . $options['branch'],
            'composer' => 'composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs',
            'migrate' => is_production() ? 'php artisan migrate --force' : 'php artisan migrate',
            'env_sync' => 'php artisan env:sync',
            'clear_cache' => 'php artisan cache:clear',
            'clear_routes' => 'php artisan route:clear',
            'cache_routes' => is_production() ? 'php artisan route:cache' : '',
            'clear_config' => 'php artisan config:clear',
            'cache_config' => is_production() ? 'php artisan config:cache' : '',
            'self_diagnosis' => 'php artisan self-diagnosis',
            'up' => 'php artisan up'
        ];
    }
}