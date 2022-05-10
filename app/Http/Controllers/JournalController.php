<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('journal.index',  ['journals'=>Journal::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('journal.create');
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
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
        ]);

        try {
            DB::beginTransaction();
            $journal = Journal::create($request->all());
            $coas = $request->input('coas', []);
            $totals = $request->input('totals', []);
            $accounts = $request->input('accounts', []);
            for ($i=0; $i < count($coas); $i++) {
                if($coas[$i]!=0||$totals[$i]!=0){
                    $journal->journalDetails()->create([
                        'coa_id'=>$coas[$i],
                        'account'=>$accounts[$i],
                        'total'=>$totals[$i]
                    ]);
                }
            }


            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
        }
        return redirect('/journal')->with('status','Data Jurnal Berhasil Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        return view('journal.show',compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        return view('journal.edit',compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        $request->validate([
            'code' => ['required', 'max:100'],
            'transaction_date' => ['required'],
        ],[
            'code.required' => 'Kode harus diisi !',
            'transaction_date.required' => 'Tanggal harus diisi !',
        ]);

        try {
            DB::beginTransaction();
            $journal->update($request->all());
            $journal->journalDetails()->delete();

            $coas = $request->input('coas', []);
            $totals = $request->input('totals', []);
            $accounts = $request->input('accounts', []);
            for ($i=0; $i < count($coas); $i++) {
                if($coas[$i]!=0||$totals[$i]!=0){
                    $journal->journalDetails()->create([
                        'coa_id'=>$coas[$i],
                        'account'=>$accounts[$i],
                        'total'=>$totals[$i]
                    ]);
                }
            }


            DB::commit();

        } catch (Throwable $e) {
            DB::rollback();
        }
        return redirect('/journal')->with('status','Data Jurnal Berhasil Diubah !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }

    public function searchAccount(Request $request){
        $coas=Coa::all();
        if($request->ajax()){
            $coas = Coa::where([['name', 'like','%'.$request->search."%"],['status','=',1]])->get();
        }
        return response()->json($coas);
    }
}
