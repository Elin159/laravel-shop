@extends('layouts.appNew')


@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2>商品管理</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">首页</a>
                </li>
                <li>
                    商品
                </li>
                <li class="active">
                    <strong>商品管理</strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12 animated fadeInRight">
                <product-list-app :list="{{ $products['list'] }}"></product-list-app>
            </div>
        </div>
    </div>
@stop

@section('script')
    @parent
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script type="text/x-template" id="product-list-template">
        <div class="row">
            <div class="col-lg-12">

                <div class="file-box" v-for="product in list">
                    <div class="file">
                        <a href="#">
                            <span class="corner"></span>
                            <div class="image">
                                <img alt="image" class="img-responsive" v-bind:src="product.avatar">
                            </div>
                            <div class="file-name">
                                <div class="tooltip-demo">
                                    @{{ product.product_name }} (<span v-if="!product.is_up">已下架</span><span v-else>上架中</span>)
                                    <br>
                                    库存:@{{ product.stock }}
                                    <br>
                                    销售量:@{{ product.sales }}
                                    <br>
                                    点击量:@{{ product.see_num }}
                                    <br>
                                    收藏量:
                                    <br>
                                    描述:<small data-toggle="tooltip" data-placement="bottom" title="" v-bind:data-original-title="product.describe">@{{ desc(product.describe) }}</small>

                                </div>
                            </div>
                        </a>

                    </div>
                </div>


            </div>
            <div class="text-center">
                <page-app :total="{{ $products['total'] }}" :page="{{ $products['page'] }}"
                          :count="{{ $products['count'] }}" :isnext="{{ $products['isNext'] }}"></page-app>
            </div>
            </div>

    </script>
    <script type="text/x-template" id="page-template">
        <div class="btn-group">
            <button type="button" class="btn btn-white" v-on:click="fontPage(page,'font')"><i class="fa fa-chevron-left"></i></button>
            <button class="btn btn-white" :class="{ 'active': page==n }" v-on:click="fontPage(n,'children')" v-for="n in pageCount">@{{ n }}</button>
            <button type="button" class="btn btn-white" v-on:click="fontPage(page, 'next')" :class="{ 'active': !isnext }"><i class="fa fa-chevron-right"></i> </button>
        </div>
    </script>


    <script>

        $(document).ready(function(){
            Vue.component('product-list-app', {
                template:'#product-list-template',
                props:['list'],
                methods:{
                    desc(desc) {
                        var str = desc;
                        if(desc.length > 10) {
                            str = desc.substring(0,10) + '....'
                        }
                        return str;
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

                            if(page == this.page) {
                                return false;
                            }

                            if(type == 'font' && page > 1) {
                                page -= 1
                            } else if(type == 'next' && page < this.pageCount){
                                page += 1
                            } else if(type == 'children' && page >= 1 && page <= this.pageCount) {
                                page = page
                            } else {
                                return false;
                            }

                            var newUrl = '{{ url('/admin/product') }}'+'?'

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


            var vm = new Vue({
                el:'#wrapper',
            })



            $('.file-box').each(function() {
                animationHover(this, 'pulse');
            });
        });

        var selectTop = '<select data-placeholder="Choose a Country..." style="width:350px;" tabindex="2" class="chosen-select">' +
                '<option value="a" id="my">请选择</option>'
        var selectEnd = '</select>'
    </script>
@stop