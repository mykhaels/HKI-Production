<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.supplier.index',  ['suppliers'=>Supplier::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = Supplier::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='SP-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        return view('master.supplier.create',compact('generatedCode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required','digits_between:10,13'],
            'email' => ['required','email']
        ],[
            'code.required' => 'Nama Supplier harus diisi !',
            'address.required' => 'Alamat harus diisi !',
            'phone.required' => 'Nomor Telepon harus diisi !',
            'phone.digits' => 'Nomor Telepon harus Angka 10 Sampai 13 Angka !',
            'email.required' => 'Email harus diisi !',
            'email.email' => 'Format Email Tidak Valid !'
        ]);
        $supplier = Supplier::create($request->all());



        return redirect('/supplier')->with('status','Data Supplier Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('master.supplier.show',compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    public function updateStatus(Supplier $supplier)
    {
        $status = 1;
        if($supplier->status==1){
            $status = 2;
        }
        Supplier::where('id', $supplier->id)->update([
            'status' => $status
        ]);

        return redirect('/supplier')->with('status','Status Supplier Berhasil Diupdate !');
    }
}
