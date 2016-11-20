<?php

namespace App\Http\Controllers\WeChat;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $weChat;
    public function __construct(Application $weChat)
    {
        $this->weChat = $weChat;
    }

    public function users() {
        $user = $this->weChat->user->lists();
        return $user;
    }
}
