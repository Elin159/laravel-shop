<?php

namespace App\Services;

use App\Mode\UserAuth;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends Server
{
    /**
     * @param string $username 登陆账号
     * @param string $password 登陆密码
     * @param string $source 登陆来源 pc 安卓 ios
     * @param int $type 类型：１密码登陆、２短信登陆
     * @param string $code　短信验证码
     * @return array
     */
    public static function login($username, $password = '', $source = 'pc', $type = 1, $code = '')
    {
        if(strlen($username) === 0) {
            return self::render(1, '用户名/Email/手机号码必须填写');
        }

        if(strlen($type) == 1) {
            if(strlen($password) === 0) {
                return self::render(2, '密码必须填写');
            }
            $account_type_info = UserService::accountTypeAndInfo($username);

            if ( empty($account_type_info) === true ) {
                return self::render(3, '账号或密码不正确');
            }
            $userinfo = $account_type_info['info'];
            $encrypt_password = UserService::encrypt($password, $userinfo->credential);
            if($encrypt_password != $userinfo->credential) {
                return self::render(4, '账号或密码不正确');
            }

            switch(strtolower($source)) {
                case 'pc':
                    Auth::loginUsingId($userinfo->id);
                    return self::render(0, 'success', $userinfo);
                    break;
            }

        }

    }

    /**
     * 登陆账号类型和账号详情
     * -- 1、账号类型：即此账号是用户名还是邮箱还是手机号码或者是第三方登陆
     * -- 2、再根据确认的类型返回账号用户信息
     * @param string $username 登陆账号
     * @return array
     */
    public static function accountTypeAndInfo($username)
    {
        $user = UserAuth::where(['identifier'=>$username])->first();

        if(empty($user)) {
            return [];
        }
        switch($user->identity) {
            case '1':
                $arr = ['type' => 'mobile_phone'];
                break;
            case '2':
                $arr = ['type' => 'email'];
                break;
            case '3':
                $arr = ['type' => 'user_name'];
                break;
        }
        $arr = $arr + ['info'=>$user];
        return $arr;
    }

    /**
     * 用户密码加密函数(暂用登陆密码与加密后密码进行比对)
     * @param $password 登陆密码
     * @param $salt 加密后密码
     * @return mixed
     */
    public static function encrypt( $password, $salt )
    {
        if (Hash::check($password, $salt)) {
            // 密码匹配...
            return $salt;
        }

        return $password;
    }

    /**
     * 邮箱注册
     * @param array $request 数据集合
     * @return array
     */
    public static function emailRegister(array $request)
    {
        $validator = \Validator::make($request,[
            'email'     => 'required|email|unique:user_auths,identifier',
            'username'  => 'required|min:3|max:20|unique:user_auths,identifier',
            'password'  => 'required|regex:/^[A-Za-z0-9_]{6,32}$/',
            'captcha'   => 'required'
        ],[
            'email.required' => '邮箱必须填写',
            'email.unique'   => '邮箱已经存在',
            'username.required'   => '用户名必须填写',
            'username.max'   => '用户名太长',
            'username.min'   => '用户名太短',
            'username.unique'   => '用户名已经存在',
            'password.required' => '密码必须填写',
            'password.regex' => '密码格式必须英文+数字',
            'captcha.required' => '验证码必须填写'
        ]);

        if($validator->fails()) {
            return self::render(1,$validator->errors()->first());
        }
        unset($request['captcha']);
        $user = User::create([
            'nickname' => ECoreService::rand_string(6,4),
            'avatar'   => 'default.jpg'
        ]);
        $userAuth = $user->userAuths()->saveMany([
            //生成邮箱账号
            new UserAuth(['identity' => 2,'identifier' => $request['email'],'credential' => bcrypt($request['password'])]),
            //生成用户名账号
            new UserAuth(['identity' => 3,'identifier' => $request['username'],'credential' => bcrypt($request['password'])]),
        ]);

        if(count($userAuth)) {
            return self::render(0, 'success');
        }

        return self::render(2, '服务器繁忙');
    }

    /**
     * 获取用户详情
     * @param int $userId 用户id
     * @return array
     */
    public static function userInfo($userId)
    {
        if($userId <= 0) {
            return self::render(1, '用户id异常');
        }

        $user_info = User::find($userId);
        if(empty($user_info)) {
            return self::render(2, '用户不存在');
        }
        return self::render(0, 'success', $user_info);
    }

    /**
     * -- Example start
     * $options = array(
     *      'user_id' => '用户id,非必须',
     *      'keyword' => '查询关键词，可不传',
     *      'order_time' => '注册时间排序'
     * )
     * 用户列表详情
     * @param array $options 集合数据
     * @param int $page 当前页码
     * @param int $count 每页显示条数
     * @return array
     */
    public static function userList($options = [], $page = 1, $count = 10)
    {
        $query = User::where('id','>',0);
        if(isset($options['keyword'])&&strlen($options['keyword']) > 0) {
            $query = $query->where('nickname', 'like', '%' . $options['keyword'] . '%');
        }
        $total = User::count();
        if($page > ceil($total/$count)) {
            $page = ceil($total/$count);
        }
        $user  = $query->forPage($page, $count)->get();
        $result = [
            'list' => $user,
            'total' => $total,
            'page' => $page,
            'count' => $count,
            'isNext' => self::IsHasNextPage($total, $page, $count)
        ];
        return self::render(0, 'success', $result);
    }

    /**
     * 修改用户密码
     * @param $userId
     * @param $oldPassword
     * @param $newPassword
     * @return array
     */
    public static function editPassword($userId, $oldPassword, $newPassword)
    {
        if(strlen($userId) === 0) {
            return self::render(1, '用户id有误');
        }

        if(strlen($oldPassword) === 0) {
            return self::render(2, '密码必须填写');
        }

        if(strlen($newPassword) === 0) {
            return self::render(3, '密码必须填写');
        }

        $user = User::where('id',$userId)->first();
        if(!$user) {
            return self::render(4, '寻找不到该用户信息');
        }
        $auths = $user->userAuths()->where('identity', 3)->first();
        if(!$auths) {
            return self::render(5, '账号非法，请联系管理员');
        }

        $salt = UserService::encrypt($oldPassword,$auths->credential);
        if($salt != $auths->credential) {
            return self::render(6, '原密码输入错误');
        }
        $user->toEditPassword($newPassword);

        return self::render(0, 'success');

    }
}