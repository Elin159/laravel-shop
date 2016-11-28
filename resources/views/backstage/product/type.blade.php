@extends('layouts.appNew')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div id="nestable-menu">
                <button type="button" data-action="expand-all" class="btn btn-white btn-sm">Expand All</button>
                <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">Collapse All</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>商品分类列表</h5>
                </div>
                <div class="ibox-content">

                    <p  class="m-b-lg">
                        <strong>注意</strong> 拖动操作进行分类的层级排列
                    </p>
                    <type-tree-app :list="{{ $tree }}"></type-tree-app>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    @parent
    <script src="{{ asset('js/plugins/nestable/jquery.nestable.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script type="text/x-template" id="type-tree-template">
        <div class="dd" id="nestable">
            <ol class="dd-list">
                <li class="dd-item" v-bind:data-id="index" v-for="(one,index) in list">
                    <div class="dd-handle">@{{ one.name }}</div>
                    <ol class="dd-list" v-if="one.check">
                        <li class="dd-item" v-bind:data-id="index" v-for="(two,index) in one.children">
                            <div class="dd-handle">@{{ two.name }}</div>
                            <ol class="dd-list" v-if="two.check">
                                <li class="dd-item" v-bind:data-id="index" v-for="(three,index) in two.children">
                                    <div class="dd-handle">@{{ three.name }}</div>
                                    <ol class="dd-list" v-if="three.check">
                                        <li class="dd-item" v-bind:data-id="index" v-for="(four,index) in three.children">
                                            <div class="dd-handle">@{{ four.name }}</div>
                                            <ol class="dd-list" v-if="four.check">
                                                <li class="dd-item" v-bind:data-id="index" v-for="(five,index) in four.children">
                                                    <div class="dd-handle">@{{ five.name }}</div>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </li>
                    </ol>
                </li>
            </ol>
            <p></p>
            <div class="text-center">
                <button class="btn btn-outline btn-primary dim" type="button" v-on:click="go()"><i class="fa fa-check"></i>提交</button>
            </div>
        </div>
    </script>
    <script>
        $(document).ready(function(){

            var old = '';

            Vue.component('type-tree-app', {
                template:'#type-tree-template',
                props:['list'],
                created:function() {
                    console.dir(this.list)
                },
                methods:{
                    go() {
                        if(old != '')
                            this.$http.post('{{ url('admin/productType') }}',{data:old}).then((response) => {
                                // success callback
                                var result = response.data
                                if(result.code === 0) {
                                    toastr.success('恭喜你','修改分类成功')
                                    old = ''
                                } else {
                                    toastr.error('修改失败',result.msg)
                                }
                            }, (response) => {
                                toastr.error('修改失败','系统出错')
                                // error callback
                            });
                        else
                            toastr.success('恭喜你','修改分类成功')
                    }
                }
            })
            new Vue({
                el:'#wrapper'
            })

            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target),
                        output = list.data('output');
                if (window.JSON) {
//                    output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                    old = window.JSON.stringify(list.nestable('serialize'))
                    if(old === '{}')
                        old = ''
                } else {
                    output.val('JSON browser support required for this demo.');
                }
            };
            // activate Nestable for list 1
            $('#nestable').nestable({
                group: 1
            }).on('change', updateOutput);

            // activate Nestable for list 2
            $('#nestable2').nestable({
                group: 1
            }).on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));

            $('#nestable-menu').on('click', function (e) {
                var target = $(e.target),
                        action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });

    </script>
@stop