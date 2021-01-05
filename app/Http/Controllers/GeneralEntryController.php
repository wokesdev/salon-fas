<?php

namespace App\Http\Controllers;

use App\Models\GeneralEntry;
use App\Models\GeneralEntryDetail;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GeneralEntryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(!empty($request->from_date))
            {
                if ($request->from_date === $request->to_date) {
                    $from_date = $request->from_date;
                    $generalEntryDetail = GeneralEntryDetail::query()->orderBy('general_entry_details.id', 'ASC')->with(['account_detail', 'general_entry'])->whereHas('general_entry', function ($query) use($from_date) {
                        return $query->whereDate('tanggal', '=', $from_date);
                    })->get();
                }

                else {
                    $from_date = $request->from_date;
                    $to_date = $request->to_date;
                    $generalEntryDetail = GeneralEntryDetail::query()->orderBy('general_entry_details.id', 'ASC')->with(['account_detail', 'general_entry'])->whereHas('general_entry', function ($query) use($from_date, $to_date) {
                        return $query->whereBetween('general_entries.tanggal', array($from_date, $to_date));
                    })->get();
                }
            }

            else
            {
                $generalEntryDetail = GeneralEntryDetail::query()->orderBy('general_entry_details.id', 'ASC')->with(['general_entry', 'account_detail']);
            }
            return DataTables::of($generalEntryDetail)->make(true);
        }
        return view('laporan.jurnal-umum.index');
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
     * @param  \App\Models\GeneralEntry  $generalEntry
     * @return \Illuminate\Http\Response
     */
    public function show(GeneralEntry $generalEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GeneralEntry  $generalEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(GeneralEntry $generalEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneralEntry  $generalEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralEntry $generalEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneralEntry  $generalEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeneralEntry $generalEntry)
    {
        //
    }
}
