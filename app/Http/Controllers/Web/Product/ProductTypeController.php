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
        $tree = ProductService::getThree();
        $tree = collect($tree)->toJson();
        return view('backstage.product.type', compact('tree'));
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
        $type = ProductService::editName($id,$request->get('name', ''));

        if($type['code'] === 0) {
            return response()->json(['code'=>0,'msg'=>'success']);
        }
        return response()->json(['code'=>1,'msg'=>$type['msg']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = ProductService::deleteType($id);
        if($result['code'] === 0) {
            return response()->json(['code'=>0, 'msg'=>$result['msg'], 'data'=>$result['data']]);
        }
        return response()->json(['code'=>1, 'msg'=>$result['msg']]);
    }

    /**
     * 添加分类名字
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProductType(Request $request) {
        if(!$request->has('name') || strlen($request->get('name')) === 0) {
            return response()->json(['code'=>1,'msg'=>'参数非法']);
        }

        $type = ProductService::addType($request->get('name'));
        if($type['code'] === 0) {
            return response()->json(['code'=>0, 'msg'=>'success', 'data'=>$type['data']]);
        }
        return response()->json(['code'=>$type['code'], 'msg'=>$type['msg']]);
    }
}
