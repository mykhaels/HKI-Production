<?php

namespace App\Http\Controllers;

use App\ReturSales;
use App\SalesDeliveryNote;
use App\Customer;
use App\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.retur-sales.index',  ['returSales' => ReturSales::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $object = ReturSales::latest()->first();
        $id = 0;
        if ($object == null) {
            $id++;
        } else {
            $id = $object->id;
            $id++;
        }
        $generatedCode = 'RTS-' . str_pad($id, 5, '0', STR_PAD_LEFT);
        $customers = Customer::all();
        return view('sales.retur-sales.create', compact('generatedCode', 'customers'));
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
            'customer_id' => ['required', 'not_in:0'],
            'sales_delivery_note_id' => ['required', 'not_in:0'],
            'quantities.*' => ['lte:qtySJ.*']
        ], [
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
            'customer_id.not_in' => 'Customer harus dipilih !',
            'sales_delivery_note_id.not_in' => 'Kode SJ harus dipilih !',
            'quantities.*.lte' => 'Qty tidak bole melebihi Qty SJ !',
        ]);
        try {
            DB::beginTransaction();
            $returSales = ReturSales::create($request->all());
            $uoms = $request->input('uoms', []);
            $qtys = $request->input('quantities', []);
            $products = $request->input('products', []);
            for ($i = 0; $i < count($uoms); $i++) {
                if ($uoms[$i] != '') {
                    $returSales->returSalesDetails()->create(
                        [
                            'product_id' => $products[$i],
                            'qty' => $qtys[$i],
                            'uom_id' => $uoms[$i]
                        ]
                    );
                }
            }
            SalesDeliveryNote::where('id', $request->input('sales_delivery_note_id'))->update(['status' => 2]);
            $journal = Journal::create([
                'code'=>$request->code,
                'transaction_date'=>$request->transaction_date
            ]);
            $journal->journalDetails()->createMany([
                [
                    'coa_id' => 607,
                    'account' => 'Kredit',
                    'total' => 0
                ],
                [
                    'coa_id' => 554,
                    'account' => 'Debit',
                    'total' => 0
                ]
            ]);
            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
        }
        return redirect('/retur-sales')->with('status', 'Data Retur Penjualan Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturSales  $returSales
     * @return \Illuminate\Http\Response
     */
    public function show(ReturSales $returSale)
    {
        $journal = Journal::where('code',$returSale->code)->first();
        return view('sales.retur-sales.show', compact('returSale','journal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturSales  $returSales
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturSales $returSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturSales  $returSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturSales $returSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturSales  $returSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturSales $returSales)
    {
        //
    }

    public function getListSJCustomer(Request $request)
    {
        if ($request->ajax()) {
            $salesDeliveryNotes = SalesDeliveryNote::where('customer_id', $request->id)->where('status', 1)->orderBy('id')->get();
            return compact('salesDeliveryNotes');
        }
    }

    public function getSalesDeliveryNote(Request $request)
    {
        if ($request->ajax()) {
            $salesDeliveryNote = SalesDeliveryNote::find($request->id);
            return response()->json($salesDeliveryNote);
        }
    }
}
