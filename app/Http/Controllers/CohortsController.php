<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;
use App\Cohort;
use App\Track;
use App\Student;
use App\Schedule;


class CohortsController extends Controller
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
        $date = date('l, d-F-Y');
        $time = date('H:i A');

        $tracks = Track::with('cohorts')->where('status', 1)->latest()->get();

        $cohorts = Cohort::orderBy('track_id')->orderBy('name')->latest()->paginate(5);

        return view('cohorts.index',compact('date','time','tracks','cohorts'));
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

    public function cohortStatus(Request $request)
    {
        $change = Cohort::find($request->cohort_id);
        $change->status = $request->status;
        $change->save();

        return response()->json(['success'=>'Status change successfully.']);
    }


    public function store(Request $request)
    {
        // $date =

        $data = $request->validate([
            'name' => ['required','min:5','string','unique:cohorts'],
            'track' => ['required'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date','after:start_date'],
            'duration' => ['required'],
            'status' => ['required'],
            'location' => ['required'],
        ]);

        Cohort::create([
            'name' => $data['name'],
            'track_id' => $data['track'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'duration' => $data['duration'],
            'status' => $data['status'],
            'location' => $data['location']
        ]);

        return redirect('/cohorts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cohort $cohort)
    {
        $date = date('l, d-F-Y');
        $time = date('H:i A');

        // $schedules = Schedule::where('cohort_id', '=', $cohort->id)->paginate(5);

        $schedules = $cohort->schedule;

        return view('cohorts.show', compact('cohort','date','time','schedules'));
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
        Cohort::find($id)->delete();
        Student::where('cohort_id', '=', $id)->delete();
        Schedule::where('cohort_id','=',$id)->delete();

         return response()->json([
             'success' => 'Record deleted successfully!'
         ]);
    }
}
