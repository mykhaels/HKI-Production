<?php

namespace App\Http\Controllers;

use App\WriteOff;
use App\Supplier;
use App\Invoice;
use Illuminate\Http\Request;

class WriteOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.writeoff.index',  ['writeoffs'=>WriteOff::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = WriteOff::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='WO-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $suppliers=Supplier::all();
        return view('purchasing.writeoff.create', compact('generatedCode','suppliers'));
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
            'supplier_id' => ['required','not_in:0'],
            "checks" => ["required","array","min:1"],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'supplier_id.not_in' => 'Supplier harus dipilih !',
            'checks.min' => 'Faktur harus dipilih !',
        ]);
        $writeOff = WriteOff::create($request->all());
        $checks = $request->input('checks', []);
        $invoices = $request->input('invoices', []);
        $remainders = $request->input('remainders', []);
        $totals = $request->input('totals', []);
        for ($i=0; $i < count($checks); $i++) {
            Invoice::where('id',$invoices[$i])->update(['status'=>2,'settlement_total'=>$totals[$i]]);
            $writeOff->writeOffDetails()->create(
                [
                'invoice_id'=> $invoices[$i],
                'write_off_total'=>$remainders[$i],
                ]);
        }
        return redirect('/writeoff')->with('status','Data Penghapusan Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WriteOff  $writeOff
     * @return \Illuminate\Http\Response
     */
    public function show(WriteOff $writeoff)
    {
        return view('purchasing.writeoff.show',compact('writeoff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WriteOff  $writeOff
     * @return \Illuminate\Http\Response
     */
    public function edit(WriteOff $writeOff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WriteOff  $writeOff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WriteOff $writeOff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WriteOff  $writeOff
     * @return \Illuminate\Http\Response
     */
    public function destroy(WriteOff $writeOff)
    {
        //
    }
}
