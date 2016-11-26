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
                    <strong>Contacts</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <userlist-app :list="{{ $users }}"></userlist-app>
    </div>

@endsection
@section('script')
    @parent
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>



    <script type="text/x-template" id="userList-template">
        <div class="row">
            <div class="col-lg-4" v-for="user in list">
                <div class="contact-box">
                    <a href="profile.html">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <img alt="image" class="img-circle m-t-xs img-responsive" v-bind:src="user.avatar">
                                <div class="m-t-xs font-bold">@{{ user.nickname }}</div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3><strong>John Smith</strong></h3>
                            <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
        </div>
    </script>

    <script>
        $(document).ready(function(){
            $('.contact-box').each(function() {
                animationHover(this, 'pulse');
            });
        });

        Vue.component('userlist-app', {
            template:'#userList-template',
            props:['list']
        })
        new Vue({
            el:'#wrapper'
        })
    </script>
@endsection
