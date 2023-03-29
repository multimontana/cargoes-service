<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CodeStyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command checked code PSR-12';

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
     * @return void
     */
    public function handle()
    {
        if (PHP_OS === "Linux") {
            $this
                ->comment(
                    shell_exec(
                        "php ~/.config/composer/vendor/bin/phpcs --standard=PSR12 --extensions=php  app --colors"
                    )
                );
        } else {
            $this
                ->comment(
                    shell_exec(
                        "php ~/.composer/vendor/bin/phpcs --standard=PSR12 --extensions=php  app --colors"
                    )
                );
        }
    }
}
