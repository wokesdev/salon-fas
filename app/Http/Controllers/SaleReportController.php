<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SaleReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
                if ($request->from_date === $request->to_date) {
                    $from_date = $request->from_date;
                    $sales = Sale::query()->with('customer')->whereDate('tanggal', '=', $from_date)->get();
                }

                else {
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;
                    $sales = Sale::query()->with('customer')->whereBetween('tanggal', array($from_date, $to_date))->get();
                }
            }

            else {
                $sales = Sale::query()->with('customer')->get();
            }

            return DataTables::of($sales)->make(true);
        }
        return view('laporan.laporan-penjualan.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
