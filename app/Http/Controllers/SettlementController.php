<?php

namespace App\Http\Controllers;

use App\Settlement;
use App\Supplier;
use App\Invoice;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchasing.settlement.index',  ['settlements'=>Settlement::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = Settlement::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='ST-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $suppliers=Supplier::all();
        return view('purchasing.settlement.create', compact('generatedCode','suppliers'));
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
            'total' => ['numeric','not_in:0','lte:total-invoice'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'supplier_id.not_in' => 'Supplier harus dipilih !',
            'checks.min' => 'Faktur harus dipilih !',
            'total.lte' => 'Nilai Pelunasan tidak bole melebihi Nilai Total !',
            'total.not_in' => 'Nilai Pelunasan tidak bole 0 !',
        ]);
         $settlement = Settlement::create($request->all());
        $checks = $request->input('checks', []);
        $invoices = $request->input('invoices', []);
        $remainders = $request->input('remainders', []);
        $totals = $request->input('totals', []);
        $settlements = $request->input('settlementTotals', []);
        $total = $request->input('total');
        for ($i=0; $i < count($checks); $i++) {
            if(($total-$remainders[$i])>=0){
                 Invoice::where('id',$invoices[$i])->update(['status'=>2,'settlement_total'=>$totals[$i]]);
                $total-=$remainders[$i];
            }else{
                $settlementTotal = $settlements[$i]+$total;
                 Invoice::where('id',$invoices[$i])->update(['settlement_total'=>$settlementTotal]);
            }
            $settlement->settlementDetails()->create(
                [
                'invoice_id'=> $invoices[$i],
                'settlement_total'=>$remainders[$i],
                ]);
        }
        return redirect('/settlement')->with('status','Data Pelunasan Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function show(Settlement $settlement)
    {
        return view('purchasing.settlement.show',compact('settlement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function edit(Settlement $settlement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settlement $settlement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settlement  $settlement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settlement $settlement)
    {
        //
    }

    public function getNotSettledInvoice(Request $request){
        if($request->ajax()){
            $invoices = Invoice::where('supplier_id',$request->id)->where('status',1)->orderBy('id')->get();
            return response()->json($invoices);
        }
    }
}
