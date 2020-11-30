<?php

namespace App\Http\Repositories;

use App\Category;

class CategoryRepository
{
    public function getAll()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }
}


