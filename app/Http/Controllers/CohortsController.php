<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;
use App\Cohort;
use App\Track;
use App\Student;
use App\Schedule;
use DateTime;
use PHPUnit\Framework\Constraint\Count;

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

        return view('cohorts.index', compact('date', 'time', 'tracks', 'cohorts'));
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

        return response()->json(['success' => 'Status change successfully.']);
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => ['required', 'min:5', 'string', 'unique:cohorts'],
            'track' => ['required'],
            'start_date' => ['required', 'date'],
            'status' => ['required'],
            'location' => ['required'],
        ]);

        // Get the total Duration for the Topics for this Cohort inorder to append to the end_date
        $Topicsduration = Topic::where('track_id', '=', $data['track'])->sum('duration');

        //Add some days to the end date based on the topics count
        $Topicscount = Topic::where('track_id', '=', $data['track'])->get();

        $totalCount = count($Topicscount) - 1;

        // The will automatically get the end_date using the start_date and topics_duration
        $end_date = date('Y-m-d', strtotime($data['start_date'] . ' + ' . intval($Topicsduration + $totalCount) . ' days'));

        // Converting end_date to a date
        $e_date = new DateTime($end_date);

        // Converting start_date to a date
        $s_date = new DateTime($data['start_date']);

        // Get the Duration in months for the Cohort
        $duration = ($e_date->diff($s_date)->m);

        // dd($Topicsduration, $end_date, $e_date, $s_date, $duration);

        // The above line of code was to not allow the Schedule for a Cohort greater than its Duration

        Cohort::create([
            'name' => $data['name'],
            'track_id' => $data['track'],
            'start_date' => $data['start_date'],
            'end_date' => $end_date,
            'duration' => $duration,
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

        return view('cohorts.show', compact('cohort', 'date', 'time', 'schedules'));
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
        Schedule::where('cohort_id', '=', $id)->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
