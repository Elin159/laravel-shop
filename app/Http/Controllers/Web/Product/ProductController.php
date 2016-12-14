<?php

namespace App\Http\Controllers\Web\Product;

use App\Mode\Parameter;
use App\Mode\ProductType;
use App\Services\ProductService;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $options = [];
        $current_page = $request->get('page', 1);
        $page_size = $request->get('page_size', 10);
        if($request->has('search'))
            if(strlen($request->get('search')))
                $options['keyword'] = $request->get('search');
        $products = ProductService::productList($options, $current_page, $page_size);
        if($products['code'] === 0) {
            $products = $products['data'];
            return view('backstage.product.products', compact('products'));
        }
//        $arr = [
//            'product_name'      => $request->get('name', '帅啊hulu'),
//            'product_type_id'   => $request->get('type_id', '3'),
//            'price'     => $request->get('price', '123'),
//            'stock'     => $request->get('stock', '123'),
//            'describe'  => $request->get('describe', '123'),
//            'is_up'     => $request->get('is_up', '1'),
//            'avatar'    => $request->get('avatar', '1213')
//        ];
//        $parameter = [
//            ['name'=> '啦啦啦','value' => '良好'],
//            ['name' => '身高', 'value' => '非常高'],
//            ['name' => '你想', 'value' => '怎样']
//        ];
//        $product = ProductService::deleteProduct(9);
//        if($product['code'] === 0) {
//            dd($product);
//        }
//        dd($product);
//        $product = ProductService::productList($request->all());
//        dd($product);
//        dd($type->products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ProductType::where('parent_id',0)->get();
        return view('backstage.product.add', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function avatar(Request $request) {
        $img = $request->get('img', '');
        $result = ProductService::uploadImage($img);
        if($result['code'] === 0) {
            return response()->json(['code'=>0, 'msg'=>'success', 'data'=>$result['data']]);
        }
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
