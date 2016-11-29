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

    public static function getThree($items = '') {
        if(!$items) {
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

}