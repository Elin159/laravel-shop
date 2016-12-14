<?php

namespace App\Services;

use App\Mode\Parameter;
use App\Mode\Product;
use App\Mode\ProductType;
use DB;

class ProductService extends Server {
    protected $items = '';

    public function __construct()
    {
        $items = \App\Mode\ProductType::all(['id','name','parent_id'])->toArray();
        $this->items = $items;
    }

    /**
     * 添加商品
     * @param array $date  商品数据
     * @param array $parameter 商品属性数据
     * @return array
     */
    public static function addProduct(array $date, array $parameter)
    {
        $validator = \Validator::make($date, [
            'product_name'      => 'required|min:3',
            'product_type_id'   => 'required|integer|exists:product_type,id',
            'price'             => 'required',
            'stock'             => 'required|integer',
            'describe'          => 'min:3',
            'is_up'             => 'required|boolean',
            'sales'             => 'integer',
            'see_num'           => 'integer',
            'avatar'            => 'required'
        ], [
            'product_name.required' => '商品名称必须填写',
            'product_name.min'      => '商品名称最少需要3位数',
            'product_type_id.required'  => '分类必须填写',
            'product_type_id.integer'   => '分类必须为整数',
            'product_type_id.exists'    => '该分类不存在',
            'price.required' => '价格必须填写',
            'stock.required' => '库存必须填写',
            'stock.integer'  => '库存必须是整数',
            'describe.min'   => '商品描述长度必须大于3',
            'is_up.required' => '上下架必须输入',
            'is_up.boolean'  => '上下架的值必须为布尔值',
            'sales.integer'  => '销售量必须为整数',
            'see_num.integer'  => '浏览量必须为整数',
            'avatar.required'  => '商品头像必须输入'
        ]);

        if($validator->fails()) {
            return self::render(1, $validator->errors()->first());
        }
        DB::beginTransaction();
        $product = Product::create($date);
        if($product) {
            $parameter = ProductService::addParameter($parameter, $product);
            if($parameter['code'] === 0) {
                DB::commit();
                return self::render(0, 'success', $product);
            }
            DB::rollBack();
            return self::render(2, $parameter['msg']);
        }
        DB::rollBack();
        return self::render(3, '系统繁忙');
    }

    /**
     * 添加商品属性
     * @param array $dates 商品属性数据
     * @param Product $product 商品数据model
     * @return array
     */
    public static function addParameter(array $dates, Product $product)
    {
        if(count($dates) === 0) {
            return self::render(1, '数据不能为空');
        }

        foreach($dates as $date) {
            if(is_numeric($date['name'])) {
                return self::render(2, '属性名不能为数字');
            }
            if(strlen($date['value']) === 0) {
                return self::render(3, '属性值不能为空');
            }
        }

        $json_date = json_encode($dates);
        $parameter = new Parameter();
        $parameter->attr_value = $json_date;
        $parameter->product()->associate($product);
        $parameter->save();

        return self::render(0, 'success', $parameter);
    }

    /**
     * 更新商品
     * @param array $date 商品表数据
     * @param array $parameters 属性表数据
     * @param $id 更新的商品id
     * @return array
     */
    public static function updateProduct($date, $parameters, $id)
    {
        if(strlen($id) === 0 || !is_numeric($id)) {
            return self::render(1, 'id参数有误');
        }

        $validator = \Validator::make($date, [
            'product_name'      => 'required|min:3',
            'product_type_id'   => 'required|integer|exists:product_type,id',
            'price'             => 'required',
            'stock'             => 'required|integer',
            'describe'          => 'min:3',
            'is_up'             => 'required|boolean',
            'sales'             => 'integer',
            'see_num'           => 'integer',
            'avatar'            => 'required'
        ], [
            'product_name.required' => '商品名称必须填写',
            'product_name.min'      => '商品名称最少需要3位数',
            'product_type_id.required'  => '分类必须填写',
            'product_type_id.integer'   => '分类必须为整数',
            'product_type_id.exists'        => '该分类不存在',
            'price.required' => '价格必须填写',
            'stock.required' => '库存必须填写',
            'stock.integer'  => '库存必须是整数',
            'describe.min'   => '商品描述长度必须大于3',
            'is_up.required' => '上下架必须输入',
            'is_up.boolean'  => '上下架的值必须为布尔值',
            'sales.integer'  => '销售量必须为整数',
            'see_num.integer'  => '浏览量必须为整数',
            'avatar.required'  => '商品头像必须输入'
        ]);

        if($validator->fails()) {
            return self::render(2, $validator->errors()->first());
        }

        if(count($parameters) === 0) {
            return self::render(3, '数据不能为空');
        }

        foreach($parameters as $parameter) {
            if(is_numeric($parameter['name'])) {
                return self::render(4, '属性名不能为数字');
            }
            if(strlen($parameter['value']) === 0) {
                return self::render(5, '属性值不能为空');
            }
        }
        $product = Product::where('id', $id)->updated($date);
        $json_date = json_encode($parameters);
        $parameter = Parameter::where('id', $id)->update(['attr_value'=>$json_date]);
        return self::render(0, 'success');
    }

    public static function deleteProduct($id)
    {
        if(strlen($id) === 0 || !is_numeric($id)) {
            return self::render(1, 'id参数有误');
        }

        Product::destroy($id);

        return self::render(0, 'success');

    }

    /**
     * 商品列表
     * @param array $options 查询条件
     * @param int $page 分页页码
     * @param int $count 每页显示数量
     * @return array
     */
    public static function productList($options = [], $page = 1, $count = 10)
    {
        $query = Product::where('id','>=', '1');
        if(isset($options['keyword']) && strlen($options['keyword']) > 0) {
            $query->where('product_name','like', '%'. $options['keyword'] . '%');
        }

        $total = Product::count();
        if($page > ceil($total/$count)) {
            $page = ceil($total/$count);
        }
        $product = $query->forPage($page, $count)->get();
        $result = [
            'list'  => $product,
            'page'  => $page,
            'total' => $total,
            'count' => $count,
            'isNext' => self::IsHasNextPage($total,$page, $count)
        ];

        return self::render(0, 'success', $result);
    }

    /**
     * 修改分类的父级元素
     * @param $tree 分号等级的数组
     * @return bool
     */
    public static function editProductType($tree)
    {
        $me = new static();

        $me->insThree($tree);
        return true;
    }

    /**
     * @param array $items 分好等级的数组
     * @param int $parent_id 父级id 非必须
     * @param string $path 路径 非必须
     */
    protected function insThree(array $items, $parent_id = 0, $path = '0,') {
        $ids = [];
        $arrIds = []; //该层哪些id值能被找到
        foreach($items as $item) {
            $ids[] = $item['id'];
        }
        $arrs = ProductType::whereIn('id', $ids)->get()->toArray();

        foreach($arrs as $arr) {
            $arrIds[] = $arr['id'];
        }

        //找到匹配的情况下
        if(count($arrIds)) {
            foreach($arrIds as $arrId) {
                foreach($items as $item) {
                    if($item['id'] == $arrId) {
                        if(array_key_exists('children',$item)) {
                            $this->insThree($item['children'], $arrId, $path.$arrId.',');
                        }
                        ProductType::where('id',$arrId)->update(['parent_id'=>$parent_id,'path'=>$path]);
                    }
                }
            }
        }
    }

    /**
     * 获取树状结构
     * @param array $items 一维数组
     * @return array
     */
    public static function getThree(array $items = []) {
        if(count($items) === 0) {
            $item = new static();
            $items = $item->items;
        }
        $tree = [];
        foreach($items as $key=>$value) {
            $tree[$value['id']] = $value;
            $tree[$value['id']]['check'] = false;
        }

        foreach($tree as $value) {
            $tree[$value['parent_id']]['children'][$value['id']] = &$tree[$value['id']];
            $tree[$value['parent_id']]['check'] = true;
        }
        unset($tree[0]);
        foreach($tree as $key => $value) {

            if($value['parent_id'] !== 0) {
                unset($tree[$key]);
            }
        }

        return $tree;
    }

    /**
     * 删除商品类型
     * @param $id 商品类型id
     * @return array
     */
    public static function deleteType($id)
    {
        if(strlen($id) === 0 || !is_numeric($id)) {
            return self::render(1, '用户id有误');
        }
        ProductType::destroy($id);
        $tree = ProductService::getThree();
        $trees = collect($tree)->toJson();
        return self::render(0, 'success', $trees);
    }

    /**
     * 添加分类
     * @param string $name 分类名字
     * @return array
     */
    public static function addType($name)
    {
        if(strlen($name) === 0) {
            return self::render(1, '参数有误');
        }

        if(!is_string($name) || is_numeric($name)) {
            return self::render(2,'参数必须为字符串');
        }

        $product = ProductType::create([
            'name' => $name,
            'parent_id' => 0,
            'path' => '0,',
        ]);

        if(!$product) {
            return self::render(3, '服务器繁忙');
        }

        return self::render(0, 'success', $product);

    }

    /**
     * 修改分类名
     * @param int $id 分类id
     * @param string $name 名字
     * @return array
     */
    public static function editName($id, $name)
    {
        if(strlen($id) === 0 || strlen($name) === 0) {
            return self::render(1, '参数有误');
        }

        if(!is_numeric($id)) {
            return self::render(2, '不存在id值');
        }

        if(!is_string($name) || is_numeric($name)) {
            return self::render(3, '名字必须是字符串');
        }

        $type = ProductType::where('id',$id)->update(['name'=>$name]);

        if($type) {
            return self::render(0, 'success');
        }

        return self::render(4, '服务器繁忙');
    }

    /**
     * 处理上传图片
     * @param $image base64_encode过的图片格式
     * @param string $path 要存储的路径(laravel自带的文件系统路径名称) 默认保存到商品图片
     * @param array $addType 需要添加的图片类型 (默认为jpg,png,jpeg,格式为['image/jpg'])
     * @return array
     */
    public static function uploadImage($image, $type = 1, $path = 'product', array $addType = [])
    {
        if(strlen($image) === 0) {
            return self::render(1, '上传数据错误');
        }

        $addType = ['image/jpg', 'image/gif', 'image/png', 'image/jpeg'] + $addType;
        if($type === 1) {
            $result = ProductService::base64Image($image, $path, $addType);
        } else {

        }
        return $result;
    }

    public static function sourceImage($image, $path, $type)
    {

    }

    public static function base64Image($image, $path, $type)
    {

        $image = explode(';', $image);

        $imgType = explode(':', $image[0]);
        if (in_array($imgType[1], $type)) {
            //获取base64格式后的数据
            $img = explode(',', $image[1]);
            //解析获取图片内容
            $imgContent = $img[1];
            $imgContent = base64_decode($imgContent);
            $name = ECoreService::rand_string(12);
            $name = date('YmdHi', time()) . $name . '.png';
            \Storage::disk($path)->put($name, $imgContent);
            return self::render(0, 'success', ['name'=>$name]);
        } else {
            return self::render(2, '上传文件类型不是图片格式');
        }
    }

}