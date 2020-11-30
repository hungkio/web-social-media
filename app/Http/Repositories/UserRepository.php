<?php

namespace App\Http\Repositories;

use App\User;

class UserRepository
{
    public function find($id)
    {
        return User::findOrFail($id);
    }
}
