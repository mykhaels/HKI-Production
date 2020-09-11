<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductionOrder;
use App\Uom;
use Illuminate\Http\Request;

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('production.production-order.index',  ['productionOrders'=>ProductionOrder::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = ProductionOrder::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }

        $generatedCode='PO-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $uoms = Uom::all();
        return view('production.production-order.create', compact('uoms','generatedCode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productionOrder = ProductionOrder::create($request->all());

        $uoms = $request->input('uoms', []);
        $qtys = $request->input('quantities', []);
        $products = $request->input('products', []);
        for ($i=0; $i < count($uoms); $i++) {
            if ($uoms[$i] != '') {
                $productionOrder->productionOrderDetails()->create(
                    [
                    'product_id'=> $products[$i],
                    'qty'=>$qtys[$i],
                    'uom_id'=>$uoms[$i]
                    ]);
            }
        }

        return redirect('/production-order')->with('status','Data Order Produksi Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductionOrder $productionOrder)
    {
        return view('production.production-order.show',compact('productionOrder'));
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

    public function searchProduct(Request $request){
        $products=Product::all();
        if($request->ajax()){
            $products = Product::where([['name', 'like','%'.$request->search."%"],['product_type','=',$request->type]])->get();
        }
        return response()->json($products);
    }
}
