<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImageTrait;
    public function index()
    {
        return view('admin.profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' . Auth::user()->id,
            'phone_number' => 'required|unique:users,phone,' . Auth::user()->id,
        ]);

        $data = User::find(Auth::user()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone_number;
        if ($request->profile_picture) {
            $data->profile_picture = $this->imageUpload($request->file('profile_picture'), 'profile');
        }

        $data->save();
        return redirect()->back()->with('message', 'Profile updated successfully.');
    }

    public function password()
    {
        return view('admin.password');
    }

    public function passwordUpdate(Request $request)
    {

        $request->validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:new_password',

        ], [
            'old_password.exists' => 'Old password is not correct',
        ]);

        $data = User::find(Auth::user()->id);
        $data->password = Hash::make($request->new_password);
        $data->update();
        return redirect()->back()->with('message', 'Password updated successfully.');
    }
}
