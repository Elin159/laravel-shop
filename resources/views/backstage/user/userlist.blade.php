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
                    <strong>用户列表</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <userlist-app :list="{{ $users['list'] }}"></userlist-app>
        <div class="text-center">
            <page-app :total="{{ $users['total'] }}" :page="{{ $users['page'] }}"
            :count="{{ $users['count'] }}" :isnext="{{ $users['isNext'] }}"></page-app>
        </div>
    </div>

@stop
@section('script')
@parent

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script type="text/x-template" id="page-template">
        <div class="btn-group">
            <button type="button" class="btn btn-white" v-on:click="fontPage(page,'font')"><i class="fa fa-chevron-left"></i></button>
            <button class="btn btn-white" :class="{ 'active': page==n }" v-on:click="fontPage(n,'children')" v-for="n in pageCount">@{{ n }}</button>
            <button type="button" class="btn btn-white" v-on:click="fontPage(page, 'next')" :class="{ 'active': !isnext }"><i class="fa fa-chevron-right"></i> </button>
        </div>
    </script>
    <script type="text/x-template" id="userList-template">
        <div class="row">
            <div class="col-lg-4" v-for="user in list">
                <div class="contact-box">
                    <a href="javascript:;">
                        <div class="col-sm-4">
                            <div class="text-center">
                                <img alt="image" class="img-circle m-t-xs img-responsive" v-bind:src="user.avatar">
                                <div class="m-t-xs font-bold">职位</div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3><strong>@{{ user.nickname }}</strong></h3>
                            <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                创建时间:@{{ user.created_at }}<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">联系电话:</abbr> (123) 456-7890
                            </address>
                            <div class="text-center">
                                <button class="btn btn-info " v-on:click="edit(user.id)" type="button"><i class="fa fa-paste"></i> 编辑</button>
                                <button class="btn btn-info btn-danger" v-on:click="deleteTo(user.id)" type="button"><i class="fa fa-paste"></i> 删除</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
        </div>
    </script>

    <script>

//        $(document).ready(function(){
//            $('.contact-box').each(function() {
//                animationHover(this, 'pulse');
//            });
//        });

        Vue.component('userlist-app', {
            template:'#userList-template',
            props:['list'],

            created:function() {
                console.dir(this.list)
            },
            methods: {
                edit(id) {
                    window.location.href = '{{ url('/admin/user') }}'+ '/' +id
                },
                deleteTo(id) {
                    alert(id)
                }
            }
        })
        Vue.component('page-app', {
            template:'#page-template',
            props:['total','page','count','isnext'],

            data() {
                return {
                    pageCount:Math.ceil(this.total/this.count)
                }
            },
            methods:{
                fontPage(page, type) {
                    if(page >= 1) {
                        if(type == 'font' && page > 1) {
                            page -= 1
                        } else if(type == 'next' && page < this.pageCount){
                            page += 1
                        } else if(type == 'children' && page >= 1 && page <= this.pageCount) {
                            page = page
                        } else {
                            return false;
                        }
                        var newUrl = '{{ url('/admin/userList') }}'+'?'


                        var Url = new UrlParse();
                        for(key in Url.GET)
                        {
                            if(key == 'page' && Url.GET[key]) {
                                newUrl += 'page=' + page + '&'
                                continue
                            } else if(Url.GET[key]) {
                                newUrl += key + '=' + Url.GET[key] + '&'
                            }
                        }
                        if(!GetQueryString('page')) {
                            newUrl += 'page=' + page + '&'
                        }
                        window.location.href = newUrl
                    }
                },
            }
        })
        new Vue({
            el:'#wrapper'
        })
    </script>
@stop
