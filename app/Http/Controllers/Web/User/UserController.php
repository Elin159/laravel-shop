<?php

namespace App\Http\Controllers\Web\User;

use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function userList(Request $request)
    {
        $options = [];
        $current_page = $request->get('page', 1);
        $page_size = $request->get('page_size', 10);
        if($request->has('search'))
            if(strlen($request->get('search')))
                $options['keyword'] = $request->get('search');
//        $users = User::forPage($current_page, $page_size)->get();
//        $count = User::count();
//        $isNext = UserService::IsHasNextPage($count, $current_page, $page_size);
        $user = UserService::userList($options, $current_page, $page_size);
        if($user['code'] === 0) {
            $users = $user['data'];
        }

        return view('backstage.user.userlist',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
