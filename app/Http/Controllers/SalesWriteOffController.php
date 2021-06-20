<?php

namespace App\Http\Controllers;

use App\SalesWriteOff;
use App\Customer;
use App\SalesInvoice;
use Illuminate\Http\Request;

class SalesWriteOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.sales-writeoff.index',  ['salesWriteoffs'=>SalesWriteOff::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = SalesWriteOff::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='SWO-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $customers=Customer::all();
        return view('sales.sales-writeoff.create', compact('generatedCode','customers'));
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
            'code' => ['required', 'max:100'],
            'transaction_date' => ['required'],
            'customer_id' => ['required','not_in:0'],
            "checks" => ["required","array","min:1"],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'customer_id.not_in' => 'Pelanggan harus dipilih !',
            'checks.min' => 'Faktur harus dipilih !',
        ]);
        $salesWriteOff = SalesWriteOff::create($request->all());
        $checks = $request->input('checks', []);
        $invoices = $request->input('invoices', []);
        $remainders = $request->input('remainders', []);
        $totals = $request->input('totals', []);
        for ($i=0; $i < count($checks); $i++) {
            SalesInvoice::where('id',$invoices[$i])->update(['status'=>2,'settlement_total'=>$totals[$i]]);
            $salesWriteOff->salesWriteOffDetails()->create(
                [
                'sales_invoice_id'=> $invoices[$i],
                'write_off_total'=>$remainders[$i],
                ]);
        }
        return redirect('/sales-writeoff')->with('status','Data Penghapusan Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesWriteOff  $salesWriteOff
     * @return \Illuminate\Http\Response
     */
    public function show(SalesWriteOff $salesWriteoff)
    {
        return view('sales.sales-writeoff.show',compact('salesWriteoff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesWriteOff  $salesWriteOff
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesWriteOff $salesWriteOff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesWriteOff  $salesWriteOff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesWriteOff $salesWriteOff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesWriteOff  $salesWriteOff
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesWriteOff $salesWriteOff)
    {
        //
    }
}
