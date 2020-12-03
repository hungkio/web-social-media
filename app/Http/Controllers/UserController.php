<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit()
    {
        $user = \auth()->user();
        return view('users.edit', [
            'user' => $user
        ]);
    }
    public function update(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            // if size less than 150MB
            if ($file->getSize() < 150000000) {
                // delete the older one
                if (Auth::user()->avatar != config('chatify.user_avatar.default')) {
                    $path = storage_path('app/public/' . config('chatify.user_avatar.folder') . '/' . Auth::user()->avatar);
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }
                // upload
                $avatar = 'user_avatar_' . Str::uuid() . "." . $file->getClientOriginalExtension();
                $update = User::where('id', Auth::user()->id)->update(['avatar' => $avatar]);
                $file->storeAs("public/" . config('chatify.user_avatar.folder'), $avatar);
                $success = $update ? 1 : 0;
            } else {
                $msg = "File extension not allowed!";
                $error = 1;
            }
        }
        $data = $request->only('name', 'description', 'birth');
        try {
            User::findOrfail($request->id)->update($data);
            return back()->with(['success' => 'Updated Success']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if (Hash::check($request->password, \auth()->user()->password)) {
            try {
                User::findOrfail(\auth()->id())->update([
                    'password' => Hash::make($request->new_password)
                ]);
                return back()->with(['success' => 'Password Changed Success']);
            } catch (\Exception $exception) {
                return back()->with(['error_pass' => $exception->getMessage()]);
            }
        } else {
            return back()->with(['error_pass' => 'Password is incorrect']);
        }
    }
}
