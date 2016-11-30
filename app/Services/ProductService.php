<?php

namespace App\Services;

use App\Mode\ProductType;

class ProductService extends Server {
    protected $items = '';

    public function __construct()
    {
        $items = \App\Mode\ProductType::all(['id','name','parent_id'])->toArray();
        $this->items = $items;
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
    public static function editName($id,$name)
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

}