@extends('layouts.appNew')

@section('style')
    <style>
        .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;

            background: #fafafa;

            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);

            background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);

            background:         linear-gradient(top, #fafafa 0%, #eee 100%);

            -webkit-border-radius: 3px;

            border-radius: 3px;

            box-sizing: border-box; -moz-box-sizing: border-box;

        }

        .dd3-content:hover { color: #2ea8e5; background: #fff; }



        .dd-dragel > .dd3-item > .dd3-content { margin: 0; }



        .dd3-item > button { margin-left: 30px; }



        .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;

            border: 1px solid #aaa;

            background: #ddd;

            background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);

            background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);

            background:         linear-gradient(top, #ddd 0%, #bbb 100%);

            border-top-right-radius: 0;

            border-bottom-right-radius: 0;

        }

        .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }

        .dd3-handle:hover { background: #ddd; }
    </style>
@stop

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
                    <type-tree-app :list="{{ $tree }}" ></type-tree-app>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加分类</h5>
                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>

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
        <div class="dd" id="nestable3">
            <ol class="dd-list">
                <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(one,index) in list">
                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">@{{ one.name }}
                        <a href="javascript:;" class="pull-right" v-if="!one.check" v-on:click="deleteType(index)">删除</a>
                    </div>
                    <ol class="dd-list" v-if="one.check">
                        <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(two,index) in one.children">
                            <div class="dd-handle dd3-handle">Drag</div>
                            <div class="dd3-content">@{{ two.name }}
                                <a href="javascript:;" class="pull-right" v-if="!two.check" v-on:click="deleteType(index,two.name)">删除</a>
                            </div>
                            <ol class="dd-list" v-if="two.check">
                                <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(three,index) in two.children">
                                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">@{{ three.name }}
                                        <a href="javascript:;" class="pull-right" v-if="!three.check" v-on:click="deleteType(index)">删除</a>
                                    </div>
                                    <ol class="dd-list" v-if="three.check">
                                        <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(four,index) in three.children">
                                            <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">@{{ four.name }}
                                                <a href="javascript:;" class="pull-right" v-if="!four.check" v-on:click="deleteType(index)">删除</a>
                                            </div>
                                            <ol class="dd-list" v-if="four.check">
                                                <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(five,index) in four.children">
                                                    <div class="dd-handle dd3-handle">Drag</div><div class="dd3-content">@{{ four.name }}
                                                        <a href="javascript:;" class="pull-right" v-if="!five.check" v-on:click="deleteType(index)">删除</a>
                                                    </div>
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
                <button class="btn btn-primary " v-on:click="go()" type="button"><i class="fa fa-check"></i>&nbsp;提交</button>

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
                    },
                    deleteType(id, name) {
//                        this.list.splice(this.list,)
                        if(confirm("确定要删除分类:"+ name +"  这条数据吗？"))
                        {
                            this.$http.delete('{{ url('admin/productType') }}'+ '/' + id,{}).then((response) => {
                                // success callback
                                var result = response.data
                                if(result.code === 0) {
                                    toastr.success('恭喜你','删除分类成功')
                                    $('li[data-id="'+ id +'"]').remove()
                                    old = ''
                                } else {
                                    toastr.error('修改失败',result.msg)
                                }
                            }, (response) => {
                                toastr.error('修改失败','系统出错')
                                // error callback
                            });
                            }

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

            $('#nestable3').nestable({
                group: 1
            }).on('change', updateOutput)

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));

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


        $('li').mousedown(function(event){
            event.stopPropagation();
        });
    </script>
@stop