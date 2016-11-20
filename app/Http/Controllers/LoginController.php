<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Laravel\Socialite\Facades\Socialite ;
class LoginController extends Controller
{
    protected $config = [
        'github' => [
            'client_id'     => '7efd14213c3552740a3e',
            'client_secret' => '95b0ea52ecb6d390c1b7805256648653c2890300',
            'redirect'      => 'http://112.74.173.24/github/login',
        ]
    ];

    public function github() {
        return Socialite::driver('github')->redirect();
    }

    public function githubLogin() {
        $user = Socialite::driver('github')->user();
	dd($user);
    }


}
