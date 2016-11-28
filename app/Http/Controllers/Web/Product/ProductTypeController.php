<?php

namespace App\Http\Controllers\Web\Product;

use App\Mode\ProductType;
use App\Services\ProductService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{

    protected $three = [];

    protected $inster = 'insert into shop_product_type (id,name,parent_id,path)';

    protected $update = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = \App\Mode\ProductType::all(['id','name','parent_id'])->toArray();
        $tree = $this->getThree($items);

        $tree = collect($tree)->toJson();
        return view('backstage.product.type', compact('tree'));
        //
        $json = '[{"id":7},{"id":4,"children":[{"id":5,"children":[{"id":3}]}]},{"id":9,"children":[{"id":6,"children":[{"id":8}]}]},{"id":1,"children":[{"id":2}]}]';
        $trees = json_decode($json,true);
        dd(ProductService::editProductType($trees));


//        dd(array_dot($trees));
//        dd(collect($tree)->toArray());
//        $tree = $this->getThree($items);
//        dd($tree);
//        dd(array_dot($tree));
//        dd(array_diff($trees,$tree));

    }

    protected function getThree($items) {
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if($request->get('data') !== '') {
                $trees = json_decode($request->get('data'),true);
                ProductService::editProductType($trees);
            }

            return response()->json(['code'=>0,'msg'=>'修改成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
