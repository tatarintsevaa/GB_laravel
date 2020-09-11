<?php


namespace App\Repositories;

use App\User;
//use SocialiteProviders\Manager\OAuth2\User as UserOAuth;
use Laravel\Socialite\Two\User as UserOAuth;

class UserRepository
{
    public function getUserBySocId(UserOAuth $user, string $socName)
    {
        $userInSystem = User::query()
            ->where('id_in_soc', $user->id)
            ->where('type_auth', $socName)
            ->first();

        if (empty($userInSystem)) {
            $userInSystem = new User();
            $userInSystem->fill([
                'name' => !empty($user->getName()) ? $user->getName() : '',
                'email' => !empty($user->getEmail()) ? $user->getEmail() : '',
                'email_verified_at' => now(),
                'password' => '',
                'id_in_soc' => !empty($user->getId()) ? $user->getId() : '',
                'type_auth' =>$socName,
                'avatar' => !empty($user->getAvatar()) ? $user->getAvatar() : '',
                'is_admin' => false
            ]);
            $userInSystem->save();

        }
        return $userInSystem;
    }
}
