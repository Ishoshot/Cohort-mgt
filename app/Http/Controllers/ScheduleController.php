<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;
use App\Track;
use App\Cohort;
use App\Schedule;


class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function generate(Request $request)
    {
        //
        $cohort = Cohort::findorfail($request->id);
        $topics = $cohort->track->topics;
        $dataSet = [];
        $newStart_date = '';
        foreach($topics as $topic)
        {
            if($topic->first()) {
                $start_date = strtotime($cohort->start_date);
                // dd(($topic->duration));
                $end_date = date('Y-m-d',$start_date)->addDays(2);
            }
            else{
                $start_date = $newStart_date;
                $end_date = $start_date + $topic->duration;
            }

            $newStart_date = $end_date + 1;

            $dataSet[] = [
            'cohort_id' => $request->id,
            'title' => $topic->title,
            'topic_id' => $topic->id,
            'duration' => $topic->duration,
            'track' => $cohort->track->title,
            'start_date' => $start_date,
            'end_date' => $end_date,
            ];
        }

        Schedule::insert($dataSet);

         return redirect('/cohorts/'.$request->id);


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
