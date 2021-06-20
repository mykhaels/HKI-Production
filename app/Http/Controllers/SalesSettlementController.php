<?php

namespace App\Http\Controllers;

use App\SalesSettlement;
use App\Customer;
use App\SalesInvoice;
use Illuminate\Http\Request;

class SalesSettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.sales-settlement.index',  ['salesSettlements'=>SalesSettlement::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = SalesSettlement::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='STS-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $customers=Customer::all();
        return view('sales.sales-settlement.create', compact('generatedCode','customers'));
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
            'total' => ['numeric','not_in:0','lte:total-invoice'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'customer_id.not_in' => 'Customer harus dipilih !',
            'checks.min' => 'Faktur harus dipilih !',
            'total.lte' => 'Nilai Pelunasan tidak bole melebihi Nilai Total !',
            'total.not_in' => 'Nilai Pelunasan tidak bole 0 !',
        ]);
        $salesSettlement = SalesSettlement::create($request->all());
        $checks = $request->input('checks', []);
        $invoices = $request->input('invoices', []);
        $remainders = $request->input('remainders', []);
        $totals = $request->input('totals', []);
        $salesSettlements = $request->input('salesSettlementTotals', []);
        $total = $request->input('total');
        for ($i=0; $i < count($checks); $i++) {
            if(($total-$remainders[$i])>=0){
                 SalesInvoice::where('id',$invoices[$i])->update(['status'=>2,'settlement_total'=>$totals[$i]]);
                $total-=$remainders[$i];
            }else{
                $salesSettlementTotal = $salesSettlements[$i]+$total;
                 SalesInvoice::where('id',$invoices[$i])->update(['settlement_total'=>$salesSettlementTotal]);
            }
            $salesSettlement->salesSettlementDetails()->create(
                [
                'sales_invoice_id'=> $invoices[$i],
                'settlement_total'=>$remainders[$i],
                ]);
        }
        return redirect('/sales-settlement')->with('status','Data Pelunasan Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesSettlement  $sales-settlement
     * @return \Illuminate\Http\Response
     */
    public function show(SalesSettlement $salesSettlement)
    {
        return view('sales.sales-settlement.show',compact('salesSettlement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesSettlement  $sales-settlement
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesSettlement $salesSettlement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesSettlement  $sales-settlement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesSettlement $salesSettlement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesSettlement  $sales-settlement
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesSettlement $salesSettlement)
    {
        //
    }

    public function getNotSettledSalesInvoice(Request $request){
        if($request->ajax()){
            $invoices = SalesInvoice::where('customer_id',$request->id)->where('status',1)->orderBy('id')->get();
            return response()->json($invoices);
        }
    }

    public function getPaymentReport(Request $request){
        $request->validate([
            'transaction_date_start' => ['required','date'],
            'transaction_date_end' => ['required','date','after:transaction_date_start'],

        ],[
            'transaction_date_start.required' => 'Tanggal awal harus dipilih !',
            'transaction_date_end.required' => 'Tanggal akhir harus dipilih !',
            'transaction_date_end.after' => 'Tanggal akhir tidak bole kurang dari Tanggal Awal',
        ]);
        $status='Data Berhasil Ditampilkan !';
        $reportPayment = SalesSettlement::whereBetween('transaction_date',[$request->transaction_date_start,$request->transaction_date_end])->paginate(10);
        if($reportPayment->count()<1)return redirect('/report/payment-report')->with('status','Data tidak ditemukan !');
        return redirect('/report/payment-report')->with('status',$status)->with('reportPayment',$reportPayment);
    }
}
