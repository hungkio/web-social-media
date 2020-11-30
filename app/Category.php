<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categorys';
    protected $fillable = ['name'];

    const DEFAULT = [
        1 => 'All Communities',
        2 => 'Near You',
        3 => 'Sports',
        4 => 'Gaming',
        5 => 'News',
        8 => 'Memes',
        9 => 'Pics & gifs',
        10 => 'Travel',
        11 => 'Tech',
        12 => 'Music',
        13 => 'Art & design',
        14 => 'Beauty',
        15 => 'Books & writing',
        16 => 'Crypto',
        17 => 'Discussion',
        18 => 'Fashion',
        19 => 'Finance & business',
        20 => 'Food',
        21 => 'Health & fitness',
        22 => 'Learning',
        23 => 'Outdoors',
        24 => 'Parenting',
        25 => 'Relationships',
        26 => 'Science',
        27 => 'Videos',
    ];
}
