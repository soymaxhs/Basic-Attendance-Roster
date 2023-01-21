<?php

namespace App\Http\Controllers;

use App\Models\Assists;
use Illuminate\Http\Request;

class AssistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Assists::get(['student_id AS id', 'status']);
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
        foreach ($request->data as $key => $studentAssist) {
            $recordAssist = Assists::where('student_id', $studentAssist['id'])->where('assist_date', $request->date)->first();
            if ($recordAssist === null) {
                $newRecordAssist = new Assists();
                $newRecordAssist->student_id = $studentAssist['id'];
                $newRecordAssist->assist_date = $request->date;
                $newRecordAssist->status = $studentAssist['status'];
                $newRecordAssist->save();
            } else {
                $recordAssist->status = $studentAssist['status'];
                $recordAssist->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($date)
    {
        return Assists::where('assist_date',$date)->get(['student_id AS id', 'status']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assists  $assists
     * @return \Illuminate\Http\Response
     */
    public function edit(Assists $assists)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assists  $assists
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assists $assists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assists  $assists
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assists $assists)
    {
        //
    }
}
