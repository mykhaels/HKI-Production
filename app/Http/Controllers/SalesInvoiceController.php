<?php

namespace App\Http\Controllers;

use App\Coa;
use App\SalesInvoice;
use App\SalesDeliveryNote;
use App\Customer;
use App\Journal;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.sales-invoice.index',  ['salesInvoices'=>SalesInvoice::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = SalesInvoice::latest()->first();
        $id=0;
        if($object==null){
            $id++;
        }else{
            $id=$object->id;
            $id++;
        }
        $generatedCode='IN-'. str_pad($id, 5, '0', STR_PAD_LEFT);
        $customers=Customer::all();
        return view('sales.sales-invoice.create', compact('generatedCode','customers'));
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
            'sales_delivery_note_id' => ['required','not_in:0'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'customer_id.not_in' => 'Pelanggan harus dipilih !',
            'sales_delivery_note_id.not_in' => 'Kode SJ harus dipilih !',
        ]);

        try {
            DB::beginTransaction();

            $salesInvoice = SalesInvoice::create($request->all());

            $uoms = $request->input('uoms', []);
            $qtys = $request->input('quantities', []);
            $products = $request->input('products', []);
            $prices = $request->input('prices', []);
            $discounts = $request->input('discounts', []);
            $taxs = $request->input('taxs', []);
            $totals = $request->input('totals', []);
            for ($i=0; $i < count($uoms); $i++) {
                if ($uoms[$i] != '') {
                    $salesInvoice->salesInvoiceDetails()->create(
                        [
                        'product_id'=> $products[$i],
                        'qty'=>$qtys[$i],
                        'uom_id'=>$uoms[$i],
                        'price'=>$prices[$i],
                        'discount'=>$discounts[$i],
                        'tax_status'=>$taxs[$i],
                        'total'=>$totals[$i]
                        ]);
                }
            }

            SalesDeliveryNote::where('id',$request->input('sales_delivery_note_id'))->update(['status'=>3]);

            $journal = Journal::create([
                'code'=>$request->code,
                'transaction_date'=>$request->transaction_date
            ]);
            $journal->journalDetails()->createMany([
                [
                    'coa_id' => 550,
                    'account' => 'Debit',
                    'total' => $request->total
                ],
                [
                    'coa_id' => 578,
                    'account' => 'Kredit',
                    'total' => $request->total
                ]
            ]);
            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
        }
        return redirect('/sales-invoice')->with('status','Data Faktur Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesInvoice  $sales-invoice
     * @return \Illuminate\Http\Response
     */
    public function show(SalesInvoice $salesInvoice)
    {
        $journal = Journal::where('code',$salesInvoice->code)->first();
        return view('sales.sales-invoice.show',compact('salesInvoice','journal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesInvoice  $sales-invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesInvoice $salesInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesInvoice  $sales-invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesInvoice $salesInvoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesInvoice  $sales-invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesInvoice $salesInvoice)
    {
        //
    }

    public function getListSJCustomer(Request $request){
        if($request->ajax()){
            $salesDeliveryNotes = SalesDeliveryNote::where('customer_id',$request->id)->where('status','<>','3')->orderBy('id')->get();
            return compact('salesDeliveryNotes');
        }
    }

    public function getSalesDeliveryNoteSO(Request $request){
        if($request->ajax()){
            $salesDeliveryNote = SalesDeliveryNote::find($request->id);
            if($salesDeliveryNote->salesRetur!=null){
                foreach($salesDeliveryNote->salesDeliveryNoteDetails as $gd){
                    foreach($salesDeliveryNote->salesRetur->salesReturDetails as $rt){
                        if($gd->product->id==$rt->product->id){
                            $gd->qty = $gd->qty-$rt->qty;
                        }
                    }
                }
            }

             return response()->json($salesDeliveryNote);
         }
    }

    public function updateStatus(SalesInvoice $salesInvoice){
        SalesInvoice::where('id',$salesInvoice->id)->update(['status'=>3]);
        return redirect('/sales-invoice')->with('status','Faktur Berhasil dibatalkan !');
    }

    public function getSalesReport(Request $request){
        $request->validate([
            'transaction_date_start' => ['required','date'],
            'transaction_date_end' => ['required','date','after_or_equal:transaction_date_start'],

        ],[
            'transaction_date_start.required' => 'Tanggal awal harus dipilih !',
            'transaction_date_end.required' => 'Tanggal akhir harus dipilih !',
            'transaction_date_end.after' => 'Tanggal akhir tidak bole kurang dari Tanggal Awal',
        ]);
        $status='Data Berhasil Ditampilkan !';
        $reportSales = SalesInvoice::whereBetween('transaction_date',[$request->transaction_date_start,$request->transaction_date_end])->where('status',1)->paginate(10);
        if($reportSales->count()<1)return redirect('/report/sales-report')->with('status','Data tidak ditemukan !');
        return redirect('/report/sales-report')->with('status',$status)->with('reportSales',$reportSales);
    }

    public function print($transaction_date_start,$transaction_date_end){
        echo($transaction_date_start+"-"+$transaction_date_end);
    }

    public function downloadPDF(Request $request) {
        $mytime = Carbon::now();
        $reportSales = SalesInvoice::whereBetween('transaction_date',[$request->startDate,$request->endDate])->where('status',1)->get();
        $pdf = PDF::loadView('/sales/report/print-sales-report' , ['reportSales'=>$reportSales,'startDate'=>$request->startDate,'endDate'=>$request->endDate]);
        $date = $mytime->format("YmdHis");
        return $pdf->download("laporan_penjualan_".$date.".pdf");

    }
}
