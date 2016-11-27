@extends('layouts.appNew')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2>Contacts</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    App Views
                </li>
                <li class="active">
                    <strong>用户详情</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-md-4">
            <div class="ibox float-e-margins">

                <div class="ibox-title">
                    <h5>用户个人信息</h5>
                </div>
                <user-detail-app :list="{{ $users }}"></user-detail-app>
            </div>
        </div>
        <div class="col-md-8">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>用户账号信息</h5>
                    </div>
                    <div class="ibox-content">
                        <h2>
                            用户密码修改
                        </h2>
                        <p class="font-bold">该栏信息谨慎修改</p>
                        <form role="form" id="form" novalidate="novalidate" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group"><label>原密码</label> <input type="password" placeholder="原密码" class="form-control" name="oldPas" data-form-pw="1480245682082.315"></div>
                            <div class="form-group"><label>新密码</label> <input type="password" id="newPas" placeholder="新密码" class="form-control" name="newPas" data-form-pw="1480245682082.315"></div>
                            <div class="form-group"><label>确认密码</label> <input type="password" placeholder="确认密码" class="form-control" name="comPas" data-form-pw="1480245682082.315"></div>
                            <div>
                                <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" data-form-sbm="1480245682082.315"><strong>Submit</strong></button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@stop

@section('script')
    @parent

    {{----}}
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script type="text/x-template" id="user-detail-template">
        <div>
            <div class="ibox-content no-padding border-left-right">
                <img alt="image" class="img-responsive" v-bind:src="list.avatar">
            </div>
            <div class="ibox-content profile-content">
                <h4><strong>@{{ list.nickname }}</strong></h4>
                <p>创建时间:@{{ list.created_at }}</p>
                <h5>
                    个性签名
                </h5>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitat.
                </p>
                <div class="row m-t-lg">
                    <div class="col-md-4">
                        <span class="bar" style="display: none;">5,3,9,6,5,9,7,3,5,2</span><svg class="peity" height="16" width="32"><rect fill="#1ab394" x="0" y="7.111111111111111" width="2.3" height="8.88888888888889"></rect><rect fill="#d7d7d7" x="3.3" y="10.666666666666668" width="2.3" height="5.333333333333333"></rect><rect fill="#1ab394" x="6.6" y="0" width="2.3" height="16"></rect><rect fill="#d7d7d7" x="9.899999999999999" y="5.333333333333334" width="2.3" height="10.666666666666666"></rect><rect fill="#1ab394" x="13.2" y="7.111111111111111" width="2.3" height="8.88888888888889"></rect><rect fill="#d7d7d7" x="16.5" y="0" width="2.3" height="16"></rect><rect fill="#1ab394" x="19.799999999999997" y="3.555555555555557" width="2.3" height="12.444444444444443"></rect><rect fill="#d7d7d7" x="23.099999999999998" y="10.666666666666668" width="2.3" height="5.333333333333333"></rect><rect fill="#1ab394" x="26.4" y="7.111111111111111" width="2.3" height="8.88888888888889"></rect><rect fill="#d7d7d7" x="29.7" y="12.444444444444445" width="2.3" height="3.5555555555555554"></rect></svg>
                        <h5><strong>169</strong> 文章</h5>
                    </div>
                    <div class="col-md-4">
                        <span class="line" style="display: none;">5,3,9,6,5,9,7,3,5,2</span><svg class="peity" height="16" width="32"><polygon fill="#1ab394" points="0 15 0 7.166666666666666 3.5555555555555554 10.5 7.111111111111111 0.5 10.666666666666666 5.5 14.222222222222221 7.166666666666666 17.77777777777778 0.5 21.333333333333332 3.833333333333332 24.888888888888886 10.5 28.444444444444443 7.166666666666666 32 12.166666666666666 32 15"></polygon><polyline fill="transparent" points="0 7.166666666666666 3.5555555555555554 10.5 7.111111111111111 0.5 10.666666666666666 5.5 14.222222222222221 7.166666666666666 17.77777777777778 0.5 21.333333333333332 3.833333333333332 24.888888888888886 10.5 28.444444444444443 7.166666666666666 32 12.166666666666666" stroke="#169c81" stroke-width="1" stroke-linecap="square"></polyline></svg>
                        <h5><strong>28</strong> 关注</h5>
                    </div>
                    <div class="col-md-4">
                        <span class="bar" style="display: none;">5,3,2,-1,-3,-2,2,3,5,2</span><svg class="peity" height="16" width="32"><rect fill="#1ab394" x="0" y="0" width="2.3" height="10"></rect><rect fill="#d7d7d7" x="3.3" y="4" width="2.3" height="6"></rect><rect fill="#1ab394" x="6.6" y="6" width="2.3" height="4"></rect><rect fill="#d7d7d7" x="9.899999999999999" y="10" width="2.3" height="2"></rect><rect fill="#1ab394" x="13.2" y="10" width="2.3" height="6"></rect><rect fill="#d7d7d7" x="16.5" y="10" width="2.3" height="4"></rect><rect fill="#1ab394" x="19.799999999999997" y="6" width="2.3" height="4"></rect><rect fill="#d7d7d7" x="23.099999999999998" y="4" width="2.3" height="6"></rect><rect fill="#1ab394" x="26.4" y="0" width="2.3" height="10"></rect><rect fill="#d7d7d7" x="29.7" y="6" width="2.3" height="4"></rect></svg>
                        <h5><strong>240</strong> 粉丝</h5>
                    </div>
                </div>
                <div class="user-button">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-default btn-sm btn-block"><i class="fa fa-coffee"></i> Buy a coffee</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>
    <script>
        $(document).ready(function(){

            $("#form").validate({
                rules: {
                    oldPas: {
                        required: true,
                        minlength: 3
                    },
                    newPas: {
                        required: true,
                        minlength: 3
                    },
                    comPas: {
                        required: true,
                        minlength: 3,
                        equalTo: '#newPas'
                    }
                }
            });
        });

        Vue.component('user-detail-app', {
            template:'#user-detail-template',
            props:['list']
        })
        new Vue({
            el:'#wrapper'
        })

        if('{{ session()->has('status') }}') {
            if('{{ session('status') == 'success' ? '1' : false }}')
                toastr.success('恭喜你','修改密码成功')
            else
                toastr.error('修改密码失败','原因：'+ '{{ session('status') }}')
        }


    </script>
@stop