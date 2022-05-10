<?php

namespace App\Http\Controllers;

use App\Coa;
use Illuminate\Http\Request;

class CoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.account.index',  ['accounts'=>Coa::paginate(10),'headAccounts'=>Coa::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $accounts = Coa::when($request->headAccount>0, function($query) use ($request){
            $query->where('parent_code',$request->headAccount);
        })
        ->when($request->code, function($query) use ($request){
            $query->where('code','like','%'.$request->code.'%');
        })
        ->when($request->name, function($query) use ($request){
            $query->where('name','like','%'.$request->name.'%');
        })
        ->when($request->accountNormal, function($query) use ($request){
            $query->where('account_normal',$request->accountNormal);
        })
        ->when($request->accountType, function($query) use ($request){
            $query->where('account_type',$request->accountType);
        })
        ->paginate(10);
        $headAccounts = Coa::all();
         return view('master.account.index',  compact('accounts','headAccounts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function show(Coa $coa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function edit(Coa $coa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coa $coa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coa  $coa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coa $coa)
    {
        //
    }

    public function updateStatus(Coa $coa)
    {
        $status = 1;
        if($coa->status==1){
            $status = 2;
        }
        Coa::where('id', $coa->id)->update([
            'status' => $status
        ]);

        return redirect('/account')->with('status','Status Akun Berhasil Diupdate !');
    }
}
