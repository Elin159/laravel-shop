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
    <type-tree-app :list="{{ $tree }}"></type-tree-app>
@stop

@section('script')
    @parent
    <script src="{{ asset('js/plugins/nestable/jquery.nestable.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script type="text/x-template" id="type-from-template">

    </script>
    <script type="text/x-template" id="type-tree-template">
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
                        <div class="dd" id="nestable3">
                            <ol class="dd-list first">
                                <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(one,index) in users">
                                    <div class="dd-handle dd3-handle">Drag</div>
                                    <div class="dd3-content">
                                        <span v-if="tel.check && tel.id==one.id"><input type="text" v-model="pushname" v-bind:value="one.name"></span>
                                        <span v-else>@{{ one.name }}</span>
                                        <div class="pull-right">
                                            <a href="javascript:;" v-if="tel.check && tel.id==one.id" v-on:click="pushType(one.id)">提交</a>
                                            <a href="javascript:;" v-else v-on:click="edit(index,one.name)">编辑</a>
                                            <a href="javascript:;" v-if="!one.check" v-on:click="deleteType(index,one.name)">&nbsp;&nbsp;删除</a>
                                        </div>
                                    </div>
                                    <ol class="dd-list" v-if="one.check">
                                        <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(two,index) in one.children">
                                            <div class="dd-handle dd3-handle">Drag</div>
                                            <div class="dd3-content">
                                                <span v-if="tel.check && tel.id==two.id"><input type="text" v-model="pushname" v-bind:value="two.name"></span>
                                                <span v-else>@{{ two.name }}</span>
                                                <div class="pull-right">
                                                    <a href="javascript:;" v-if="tel.check && tel.id==two.id" v-on:click="pushType(two.id)">提交</a>
                                                    <a href="javascript:;" v-else v-on:click="edit(index,two.name)">编辑</a>
                                                    <a href="javascript:;" v-if="!two.check" v-on:click="deleteType(index,two.name)">&nbsp;&nbsp;删除</a>
                                                </div>
                                            </div>
                                            <ol class="dd-list" v-if="two.check">
                                                <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(three,index) in two.children">
                                                    <div class="dd-handle dd3-handle">Drag</div>
                                                    <div class="dd3-content">
                                                        <span v-if="tel.check && tel.id==three.id"><input type="text" v-model="pushname" v-bind:value="three.name"></span>
                                                        <span v-else>@{{ three.name }}</span>
                                                        <div class="pull-right">
                                                            <a href="javascript:;" v-if="tel.check && tel.id==three.id" v-on:click="pushType(three.id)">提交</a>
                                                            <a href="javascript:;" v-else v-on:click="edit(index,three.name)">编辑</a>
                                                            <a href="javascript:;" v-if="!three.check" v-on:click="deleteType(index,three.name)">&nbsp;&nbsp;删除</a>
                                                        </div>
                                                    </div>
                                                    <ol class="dd-list" v-if="three.check">
                                                        <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(four,index) in three.children">
                                                            <div class="dd-handle dd3-handle">Drag</div>
                                                            <div class="dd3-content">
                                                                <span v-if="tel.check && tel.id==four.id"><input type="text" v-model="pushname" v-bind:value="four.name"></span>
                                                                <span v-else>@{{ four.name }}</span>
                                                                <div class="pull-right">
                                                                    <a href="javascript:;" v-if="tel.check && tel.id==four.id" v-on:click="pushType(four.id)">提交</a>
                                                                    <a href="javascript:;" v-else v-on:click="edit(index,four.name)">编辑</a>
                                                                    <a href="javascript:;" v-if="!four.check" v-on:click="deleteType(index,four.name)">&nbsp;&nbsp;删除</a>
                                                                </div>
                                                            </div>
                                                            <ol class="dd-list" v-if="four.check">
                                                                <li class="dd-item dd3-item" v-bind:data-id="index" v-for="(five,index) in four.children">
                                                                    <div class="dd-handle dd3-handle">Drag</div>
                                                                    <div class="dd3-content">
                                                                        <span v-if="tel.check && tel.id==five.id"><input type="text" v-model="pushname" v-bind:value="five.name"></span>
                                                                        <span v-else>@{{ five.name }}</span>
                                                                        <div class="pull-right">
                                                                            <a href="javascript:;" v-if="tel.check && tel.id==five.id" v-on:click="pushType(five.id)">提交</a>
                                                                            <a href="javascript:;" v-else v-on:click="edit(index,five.name)">编辑</a>
                                                                            <a href="javascript:;" v-if="!five.check" v-on:click="deleteType(index,five.name)">&nbsp;&nbsp;删除</a>
                                                                        </div>
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
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>添加分类</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" @submit.prevent="submit">
                            <p>添加的分类名默认为顶级</p>
                            <div class="form-group"><label class="col-lg-2 control-label">分类名</label>

                                <div class="col-lg-10">
                                    <input type="text" placeholder="分类名字" v-model="name" class="form-control" data-form-un="1480476325436.1128">
                                    <span class="help-block m-b-none">请输入您要添加的分类名</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-sm btn-white" type="submit" data-form-sbm="1480476325436.1128">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </script>
    <script>
        $(document).ready(function(){
            var old = '';

            Vue.component('type-tree-app', {
                template:'#type-tree-template',
                props:['list'],
                data() {
                    return {
                        users:this.list,
                        name:'',
                        tel:{check:false,id:''},
                        pushname:''
                    }
                },
                methods:{
                    go() {
                        if(this.tel.check) {
                            toastr.error('提交失败','请提交修改数据')
                            return false
                        }
                        if(old && !JSON.parse(old).context)
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

                    },
                    submit:function() {
                        if(!this.name) {
                            toastr.error('添加失败','提交的数据为空')
                        } else {
                            this.$http.post('{{ url('admin/addType') }}', {name:this.name}).then((response) => {
                                var result = response.data
                                if(result.code === 0) {
                                    window.location.reload()
                                    this.name = ''
                                    old = ''
                                } else {
                                    toastr.error('修改失败',result.msg)
                                }
                            }, (response) => {
                                toastr.error('修改失败','系统出错')
                                // error callback
                            }).bind(this);
                        }
                    },
                    edit(id,name) {
                        this.tel.check = !this.tel.check
                        this.tel.id = id
                        this.pushname = name
                        old = ''
                        console.dir(old)
                    },
                    pushType(id) {
                        if(this.pushname && id) {
                            this.$http.put('{{ url('admin/productType') }}'+'/'+id, {name:this.pushname}).then((response) => {
                                var result = response.data
                                if(result.code === 0) {
                                    this.pushname = ''
                                    this.tel.check = false
                                    this.tel.id    = ''
                                    window.location.reload()
                                } else {
                                    toastr.error('修改名字失败',result.msg)
                                }

                            }, (response) => {
                                toastr.error('修改名字失败','服务器繁忙')
                            })
                        }
                    }
                }
            })
            var vm = new Vue({
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