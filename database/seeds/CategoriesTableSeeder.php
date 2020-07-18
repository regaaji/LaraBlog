<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //collect digunakan untuk memasukkan array ke dalam collection dan bisa di eksekusi dengan each 
        $categories = collect(['Framework', 'Code']);
        $categories->each(function ($c) {
            \App\Category::create([
                'name' => $c,
                'slug' => \Str::slug($c),
            ]);
        });
    }
}
