<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Uom;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.product.index',  ['products'=>Product::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = Product::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='PD-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $uoms =Uom::all();
        $productCategories = ProductCategory::all();
        return view('master.product.create',compact('uoms'),compact('productCategories','generatedCode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());

        $uoms = $request->input('uoms', []);
        $conversions = $request->input('conversions', []);
        $levels = $request->input('level', []);
        $prices = $request->input('price', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $product->uoms()->attach($uoms[$i], ['conversion' => $conversions[$i], 'level' => $levels[$i], 'price' =>$prices[$i]]);
            }
        }

        return redirect('/product')->with('status','Data Produk Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $uoms =Uom::all();
        $productCategories = ProductCategory::all();
        return view('master.product.show',compact('product','productCategories','uoms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function updateStatus(Product $product)
    {
        $status = 1;
        if($product->status==1){
            $status = 2;
        }
        Product::where('id', $product->id)->update([
            'status' => $status
        ]);

        return redirect('/product')->with('status','Status Produk Berhasil Diupdate !');
    }


}
