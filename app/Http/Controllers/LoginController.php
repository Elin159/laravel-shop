<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laravel\Socialite\SocialiteManager;

class LoginController extends Controller
{
    protected $config = [
        'github' => [
            'client_id'     => '',
            'client_secret' => '',
            'redirect'      => '',
        ]
    ];

    public function github() {
        $socialite = new SocialiteManager($this->config);
        return $socialite->driver('github')->redirect();
    }

    public function githubLogin() {
        $socialite = new SocialiteManager($this->config);
        $githubUser = $socialite->driver('github')->user();
    }
}
