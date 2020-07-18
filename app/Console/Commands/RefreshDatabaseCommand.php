<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is usefull to refresh all database and seed the default data';

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
     * @return int
     */
    public function handle()
    {
        //php artisan refresh:database => tinggal pakai command ini

        //migrate:refresh digunakan unutk menghapus data dari database 
        $this->call('migrate:refresh');


        //db:seed digunakan untuk membuat data seed 
        $this->call('db:seed');
        
        // $categories = collect(['Framework', 'Code']);
        // $categories->each(function ($c) {
        //     \App\Category::create([
        //         'name' => $c,
        //         'slug' => \Str::slug($c),
        //     ]);
        // });

        // $tags = collect(['Laravel', 'Fondation', 'Slim', 'Help', 'Bug']);
        // $tags->each(function ($c) {
        //     \App\Tag::create([
        //         'name' => $c,
        //         'slug' => \Str::slug($c),
        //     ]);
        // });

        $this->info('All database has been refreshed and seeded');
    }
}
