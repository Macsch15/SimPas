<?php

namespace SimPas\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BuildAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assets:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build assets for application';

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
        $this->buildFonts();
        $this->buildJs();

        $this->info('Assets successfully built.');
    }

    /**
     * Build fonts.
     *
     * @return void
     */
    private function buildFonts()
    {
        $fonts_path = base_path('/public/fonts');

        $directories = collect([
            base_path('/vendor/components/font-awesome/fonts') => $fonts_path,
            // ...
        ]);

        $directories->each(function ($target, $source) {
            File::copyDirectory($source, $target);
        });

        $this->comment('Building fonts...');
    }

    /**
     * Build javascript.
     *
     * @return void
     */
    private function buildJs()
    {
        $js_files = collect([
            base_path('vendor/twbs/bootstrap/dist/js/bootstrap.min.js') => base_path('resources/assets/js/bootstrap.min.js'),
            // ...
        ]);

        $js_files->each(function ($target, $source) {
            if (File::exists($target)) {
                File::delete($target);
            }

            File::copy($source, $target);
        });

        $this->comment('Building JS...');
    }
}
