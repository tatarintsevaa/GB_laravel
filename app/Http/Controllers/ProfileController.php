<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{

    public function index(User $user)
    {
        return view('profile')->with('user', $user);
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, $this->validateRules(), [], $this->attributesNames());


        $user->fill([
            'name' => $request->post('name'),
            'email' => $request->post('email')
        ]);
        $user->save();

        return redirect()->route('profile.index', $user)->with('success', 'Данные сохранены');

    }

    public function editPassword(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, $this->validateRulesForPassword(), [], $this->attributesNames());


        if (Hash::check($request->post('password'), $user->password) &&
            Str::is($request->post('newPassword'), $request->post('newPasswordСonfirm'))) {
            $user->fill(['password' => Hash::make($request->post('newPassword'))]);
            $user->save();
            return redirect()->route('profile.index', $user)->with('success', 'Пароль изменён');
        } elseif (!Hash::check($request->post('password'), $user->password)) {
            $errors['password'][] = 'Текущий пароль введен не верно';
            return redirect()->route('profile.index', $user)->withErrors($errors);
        } elseif (!Str::is($request->post('newPassword'), $request->post('newPasswordСonfirm'))) {
            $errors['newPassword'][] = 'Пароли не совпадают';
            return redirect()->route('profile.index', $user)->withErrors($errors);
        }
    }

    public function addAvatar(Request $request)
    {
        $userId = Auth::id();
        $this->validate($request, $this->validateRulesForAvatar());
        $path = Storage::putFile('public/img/' . $userId . '/avatars', $request->file('avatar'));
        $filename = Storage::url($path);
        $user = Auth::user();
        $user->fill(['avatar' => $filename])->save();
        return redirect()->route('profile.index', $user)->with('success', 'Данные сохранены');
    }

    public function validateRules()
    {
        return [
            'name' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . Auth::id()
        ];
    }

    public function validateRulesForPassword()
    {
        return [
            'password' => 'string|min:3',
            'newPassword' => 'string|min:3',
            'newPasswordСonfirm' => 'string|min:3',
        ];
    }

    public function validateRulesForAvatar()
    {
        return [
            'avatar' => 'required|mimes:jpeg,bmp,png|max:1000'
        ];
    }

    public function attributesNames()
    {
        return [
            'newPassword' => 'Новый пароль',
            'newPasswordСonfirm' => 'Подтверждение пароля'
        ];
    }
}
