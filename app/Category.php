<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categorys';
    protected $fillable = ['name'];

    const DEFAULT = [
        1 => 'All Communities',
        2 => 'Sports',
        3 => 'Gaming',
        4 => 'News',
        5 => 'Memes',
        6 => 'Pics & gifs',
        7 => 'Travel',
        8 => 'Tech',
        9 => 'Music',
        10 => 'Art & design',
        11 => 'Beauty',
        12 => 'Books & writing',
        13 => 'Fashion',
        14 => 'Finance & business',
        15 => 'Food',
        16 => 'Health & fitness',
        17 => 'Learning',
        18 => 'Outdoors',
        19 => 'Parenting',
        20 => 'Relationships',
        21 => 'Science',
        22 => 'Videos',
    ];
}
