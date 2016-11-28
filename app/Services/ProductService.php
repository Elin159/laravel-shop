<?php

namespace App\Services;

use App\Mode\ProductType;

class ProductService extends Server {

    public static function editProductType($tree)
    {
        $me = new static();
        $me->insThree($tree);
        return true;
    }

    protected function insThree($items, $parent_id = 0, $path = '0,') {
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

}