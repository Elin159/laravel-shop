@extends('layouts.appNew')

@section('style')
    <link href="{{ asset('css/plugins/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/cropper/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/summernote/summernote-bs3.css') }}" rel="stylesheet">
@stop

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
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>快速添加商品</h5>
                    </div>
                    <div class="ibox-content">

                        <form class="form-horizontal" @submit.prevent="submit">
                            <p>快速添加的商品请去详情页添加商品详情以及规格</p>

                            <div class="form-group"><label class="col-lg-2 control-label">商品名</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="输入商品名称" v-model="product_name" class="form-control" data-form-un="1480476325436.1128">
                                    <span class="help-block m-b-none">请输入您要添加的商品名</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">分类</label>
                                <div class="col-lg-10">
                                    <select-group :list="typenum"></select-group>
                                    <span class="help-block m-b-none">请选择分类</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">价格</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="请输入价格" v-model="price" class="form-control" data-form-un="1480476325436.1128">
                                    <span class="help-block m-b-none">请输入价格</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">库存</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="请输入库存" v-model="stock" class="form-control" data-form-un="1480476325436.1128">
                                    <span class="help-block m-b-none">请输入库存</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">商品描述</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="3" v-model="describe"></textarea>
                                    <span class="help-block m-b-none">请概括商品</span>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-2 control-label">添加商品头像</label>
                                <div class="col-lg-10 upload-father">
                                    <button class="btn btn-success dim upload" type="button"><i class="fa fa-upload"></i></button>
                                </div>
                            </div>

                                <div class="ibox float-e-margins" id="image">
                                        <div class="ibox-content">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="image-crop">
                                                        <img src="{{ asset('img/p3.jpg') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4>缩略图</h4>
                                                    <div class="img-preview img-preview-sm"></div>
                                                    <h4>常见的方法</h4>
                                                    <p>
                                                        你可以上传新的图片进行裁剪
                                                    </p>
                                                    <div class="btn-group">
                                                        <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                                            <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
                                                            上传新的图片
                                                        </label>
                                                        <label title="Donload image" id="download" class="btn btn-primary">提交确定</label>
                                                    </div>
                                                    <h4>其他选项</h4>
                                                    {{--<p>--}}
                                                        {{--You may set cropper options with <code>$({image}).cropper(options)</code>--}}
                                                    {{--</p>--}}
                                                    <div class="btn-group">
                                                        <button class="btn btn-white" id="zoomIn" type="button">放大</button>
                                                        <button class="btn btn-white" id="zoomOut" type="button">缩小</button>
                                                        <button class="btn btn-white" id="rotateLeft" type="button">左旋转45°</button>
                                                        <button class="btn btn-white" id="rotateRight" type="button">右旋转45°</button>
                                                        <button class="btn btn-warning" id="setDrag" type="button">进行裁剪</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <div class="form-group"><label class="col-lg-2 control-label">商品详情</label>
                                <div class="col-lg-10">
                                    <div class="ibox-content no-padding">
                                        <div id="summernote"></div>
                                    </div>
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
    </div>
@stop

@section('script')
    @parent
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('js/plugins/cropper/cropper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/summernote/summernote.min.js') }}"></script>

    <script type="text/x-template" id="select-group-template">
        <div class="ibox-content">
            <div class="form-group" >
                <select-app :one="type" v-for="(type,index) in list"></select-app>
            </div>
        </div>
    </script>
    <script type="text/x-template" id="select-app-template">
        <div class="input-group">
            <select data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2">
                <option value="a" id="my">请选择</option>
                <option v-bind:value="type.id" v-for="type in select">@{{ type.name }}</option>
            </select>
        </div>
    </script>
    <script>
        $(document).ready(function(){


            Vue.component('select-group', {
                template:'#select-group-template',
                props:['list']
            })

            Vue.component('select-app', {
                template:'#select-app-template',
                props:['one'],
                methods:{
                    check(id) {
                        alert(id)
                    }
                },
                data:function() {
                    return {
                        select:this.one
                    }
                },
            })

            var vm = new Vue({
                el:'#wrapper',
                data:{
                    typenum:[JSON.parse('{!! $types !!} ')],
                    avatar:'p3.jpg',
                    choose:'',
                    product_name:'',
                    price:0,
                    stock:0,
                    describe:''
                },
                methods:{
                    submit:function() {
                        if( !this.choose || !this.product_name || !this.price || !this.stock || !this.describe ) {
                            toastr.error('填写有误，请查看您添加的商品')
                        } else {
                            var form = new FormData()
                            form.append('type_id', this.choose)
                            form.append('product_name', this.product_name)
                            form.append('price', this.price)
                            form.append('stock', this.stock)
                            this.$http.post('{{ url('admin/product/quick') }}',form).then((response) => {
                                var result = response.data
                                console.dir(result)
                            }, (response) => {

                            })
                        }
                    }
                }
            })

            var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }

            $('.chosen-select').chosen()

            var selectArr = []
            setInterval(function () {
                selectArr = []
            }, 1000000);
            $('.input-group').on('change','.chosen-select',function() {

                $(this).next().next().nextAll().remove()
                $(this).next().next().remove()
                var type_id = $(this).val()
                if(type_id === 'a') {
                    return false;
                }
                if(selectArr[type_id]) {
                    $('.input-group').append(
                            selectArr[type_id]
                    )
                    $('.chosen-select').chosen()
                } else {
                    Vue.http.post('{{ url('admin/type') }}',{id:type_id}).then((response) => {
                        vm.choose = ''
                        var result = response.data
                        if(result.code === 0) {
                            if(result.data.length) {
                                var types = result.data
                                var options = ''
                                for(var type in types) {
                                    options += '<option value="' + types[type].id + '">'+types[type].name+'</option>'
                                }
                                $('.input-group').append(
                                        selectTop + options + selectEnd
                                )
                                selectArr[type_id] = selectTop + options + selectEnd

                                $('.chosen-select').chosen()
                            } else {
                                vm.choose = type_id
                            }
                        } else {

                            toastr.success('查找失败')
                        }
                    }, (response) => {
                        console.dir(response)
                    })
                }
            })

            $('.upload').on('click', function() {
//                $(this).parent().parent().addClass('hidden')
                $('#image').removeClass('hidden')
            });

            var $image = $(".image-crop > img")
            $($image).cropper({
                aspectRatio: 1,
                preview: ".img-preview",
                done: function(data) {
                    // Output the result data for cropping image.
                }
            });

            var $inputImage = $("#inputImage");
            if (window.FileReader) {
                $inputImage.change(function() {
                    var fileReader = new FileReader(),
                            files = this.files,
                            file;

                    if (!files.length) {
                        return;
                    }

                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function () {
                            $inputImage.val("");
                            $image.cropper("reset", true).cropper("replace", this.result);
                        };
                    } else {
                        showMessage("Please choose an image file.");
                    }
                });
            } else {
                $inputImage.addClass("hide");
            }

            $("#download").click(function() {
//                window.open($image.cropper("getDataURL"));
//                return false

                $inputImage.addClass("hide")
                $('#image').addClass('hidden')
                Vue.http.post('{{ url('admin/product/avatar') }}',{img:$image.cropper("getDataURL")}).then((response) => {
                    var result = response.data;
                    if(result.code === 0) {
                        toastr.success('头像上传成功')
                        vm.avatar = result.data.name
                        if($('.upload').prevAll().length === 1) {
                            $('.upload').prev().remove()
                        }

                        $('.upload').before('<div class="img-preview-sm col-lg-5"><img width="200px" src="{{ asset('/') }}img/product/'+ result.data.name +'" alt=""></div>');
//                        $('.upload').eq(1).remove()
                    }
                }, (response) => {})
//                console.dir($image.cropper("getDataURL"))
            });

            $("#zoomIn").click(function() {
                $image.cropper("zoom", 0.1);
            });

            $("#zoomOut").click(function() {
                $image.cropper("zoom", -0.1);
            });

            $("#rotateLeft").click(function() {
                $image.cropper("rotate", 45);
            });

            $("#rotateRight").click(function() {
                $image.cropper("rotate", -45);
            });

            $("#setDrag").click(function() {
                $image.cropper("setDragMode", "crop");
            });

        });

        var selectTop = '<select data-placeholder="Choose a Country..." style="width:350px;" tabindex="2" class="chosen-select">' +
                '<option value="a" id="my">请选择</option>'
        var selectEnd = '</select>'
    </script>

    <script>
        $ = jQuery.noConflict()
        $(function() {
            $('#summernote').summernote({
                height: 300,
                placeholder: '请输入商品详情',
            });
        })

        function sendFile(file, editor, $editable){
            $(".note-toolbar.btn-toolbar").append('正在上传图片');
            var filename = false;
            try{
                filename = file['name'];
            } catch(e){filename = false;}
            if(!filename){$(".note-alarm").remove();}
//以上防止在图片在编辑器内拖拽引发第二次上传导致的提示错误
//            var ext = filename.substr(filename.lastIndexOf("."));
//            ext = ext.toUpperCase();
//            var timestamp = new Date().getTime();
//            var name = timestamp+"_"+$("#summernote").attr('aid')+ext;
//name是文件名，自己随意定义，aid是我自己增加的属性用于区分文件用户
            data = new FormData();
            data.append("file", file);
//            data.append("key",name);
//            data.append("token",$("#summernote").attr('token'));
//            $.ajax({
//                data: data,
//                type: "POST",
//                url: "http://upload.qiniu.com",
//                cache: false,
//                contentType: false,
//                processData: false,
//                success: function(data) {
//
//                    setTimeout(function(){$(".note-alarm").remove();},3000);
//                },
//                error:function(){
////                    $(".note-alarm").html("上传失败");
//                    setTimeout(function(){$(".note-alarm").remove();},3000);
//                }
//            });
        }
    </script>
@stop
