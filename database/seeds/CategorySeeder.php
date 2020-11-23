<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Category::DEFAULT as $category)
        {
            Category::create(['name' => $category]);
        }
        return true;
    }
}
