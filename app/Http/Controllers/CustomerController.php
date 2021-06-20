<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.customer.index',  ['customers'=>Customer::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = Customer::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='CT-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        return view('master.customer.create',compact('generatedCode'));
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
            'code.required' => 'Nama Pelanggan harus diisi !',
            'address.required' => 'Alamat harus diisi !',
            'phone.required' => 'Nomor Telepon harus diisi !',
            'phone.digits' => 'Nomor Telepon harus Angka 10 Sampai 13 Angka !',
            'email.required' => 'Email harus diisi !',
            'email.email' => 'Format Email Tidak Valid !'
        ]);
        $customer = Customer::create($request->all());



        return redirect('/customer')->with('status','Data Pelanggan Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('master.customer.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function updateStatus(Customer $customer)
    {
        $status = 1;
        if($customer->status==1){
            $status = 2;
        }
        Customer::where('id', $customer->id)->update([
            'status' => $status
        ]);

        return redirect('/customer')->with('status','Status Pelanggan Berhasil Diupdate !');
    }
}
