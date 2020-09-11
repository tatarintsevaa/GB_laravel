<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginVK () {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return Socialite::with('vkontakte')->redirect();
    }

    public function responseVK(UserRepository $userRepository) {

        if (Auth::check()) {
            return redirect()->route('home');
        }
        $user = Socialite::driver('vkontakte')->user();
        session(['soc.token' => $user->token]);
        $userInSystem = $userRepository->getUserBySocId($user, 'vk');
        Auth::login($userInSystem);
        return redirect()->route('home');
    }

    public function loginFb () {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return Socialite::with('facebook')->redirect();
    }

    public function responseFb(UserRepository $userRepository) {

        if (Auth::check()) {
            return redirect()->route('home');
        }
        $user = Socialite::driver('facebook')->user();
        session(['soc.token' => $user->token]);
        $userInSystem = $userRepository->getUserBySocId($user, 'fb');
        Auth::login($userInSystem);
        return redirect()->route('home');
    }

    public function loginGh () {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return Socialite::driver('github')->redirect();
    }

    public function responseGh(UserRepository $userRepository) {

        if (Auth::check()) {
            return redirect()->route('home');
        }
        $user = Socialite::driver('github')->user();
        session(['soc.token' => $user->token]);
        $userInSystem = $userRepository->getUserBySocId($user, 'gh');

        Auth::login($userInSystem);
        return redirect()->route('home');
    }
}
