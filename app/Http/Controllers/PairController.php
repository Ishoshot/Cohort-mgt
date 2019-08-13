<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Cohort;
use App\Track;
use App\Topic;
use App\Pair;


class PairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $date = date('l, m-F-Y');
        $time = date('H:i A');
        $cohorts = Cohort::where('status', 1)->latest()->get();
        return view('pair.index', compact('time','date', 'cohorts'));
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


    }


    /**
     * fetches all students of the selected cohort  in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        // Display date and time
        $date = date('l, m-F-Y');
        $time = date('H:i A');
        // dd($_SERVER['REMOTE_ADDR']);
        // // Validate data requests
        // $data = $request->validate([
        //     'cohort' => 'required'
        // ]);

        $students = Student::where('cohort_id', '=', $request->cohort)->get();
        $track = Cohort::where('id', '=', $request->cohort)->first();
        // dd($track);
        $track_id = $track->track_id;
        $topics = Topic::where('track_id', '=', $track_id)->get();

        return view('pair.pair', compact('students', 'topics', 'date', 'time'));

    }


    public function mappairs(Request $request)
    {

        // $input = $request->all();

        $cohort = Cohort::where('id', '=',$request->cohort_id)->first();
        $cohort_name = $cohort->name;


        $topic = Topic::where('id', '=', $request->topic_id)->first();
        $topic_title = $topic->title;

        Pair::create([
            'student_one' => $request->student_one,
            'student_two' => $request->student_two,
            'topic_id' => $request->topic_id,
            'cohort_id' => $request->cohort_id,
            'student_one_fname' => $request->student_one_fname,
            'student_two_fname' => $request->student_two_fname,
            'cohort_name' => $cohort_name,
            'topic_title' => $topic_title
        ]);
        return response()->json(['success'=>'Pairing Done Successfully!!']);

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
