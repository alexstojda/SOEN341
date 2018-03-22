<?php

namespace App\Http\Controllers;

use App\Services\SocialFacebookAccountService;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialAuthFacebookController
 * @package App\Http\Controllers
 */
class SocialAuthFacebookController extends Controller
{
    /**
     * @return mixed
     */
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        auth()->login($user);
        return redirect()->to('/questions');
    }



}
