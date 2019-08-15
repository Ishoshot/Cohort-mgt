<?php

namespace App\Http\Controllers;
use App\Http\Requests;

use App\Cohort;
use App\Schedule;
use App\Student;
use App\Topic;
use App\Track;
use App\Attendance;
use App\Pair;

use Illuminate\Http\Request;
use App\Http\Resources\Cohort as CohortResource;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
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


    public function cohort()
    {
        $cohorts = Cohort::all();

        return CohortResource::collection($cohorts);
    }

    
    public function submit(Request $request) {

        $data = $request->validate([
           'username' => ['required'],
            'cohort' => ['required']
        ]);

        $system_ip = $request->ip();
        
        $username = trim($data['username']);

        $cohort_id = $data['cohort'];
        
        $cohort = Cohort::findorfail($cohort_id);

        if ($cohort->status !== 1) {
            $message = 'Oops! The Cohort selected is not active';
            return response()->json(['message'=> $message]);        
        }

        $student = Student::where('username', '=', $username)->first();

        if (!$student) {
            $message = 'Invalid Username! Check your username and try again';
            return response()->json(['message'=> $message]);        
        }

        if ($student->cohort_id !== $cohort->id) {
            $message = 'Oops! You just selected the wrong cohort';
            return response()->json(['message'=> $message]);       
        } 


        //To get schedule 
        $schedule = $cohort->schedule;

        if ($schedule == null) {
            $message = '[Schedule] There was a problem while taking the Attendance! If problem persists, kindly call the attention of your co-ordinator.';
            return response()->json(['message' => $message]);
        }

        //To get topic from schedule
        $topic = $schedule->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))->first();

        if (!$topic) {
            $message = '[Topic] There was a problem while taking the Attendance! If problem persists, kindly call the attention of your co-ordinator.';
            return response()->json(['message' => $message]);
        }

        //To check if exists
        $exists = Attendance::where('username', '=', $student->username)
        ->whereDate('created_at', '=', date('Y-m-d'))->first();

        if ($exists) {
            $message = $student->lastname.', Your attendance for today has been taken. If not you, kindly call the attention of your co-ordinator.';
            return response()->json(['message' => $message]);
        }

        // To fetch pair's details
        
        
        $matchThese = [
            'cohort_id' => $cohort->id,
            'topic_title' => $topic->title,
        ];

        $user = $student->username;

        $pair = Pair::where($matchThese)
            ->where(function ($query) use($user)
            {
                $query->where('student_one', '=', $user)
                ->orWhere('student_two', '=', $user);
            })
            ->first();
    
        if (!$pair) {
            $message = $student->lastname.", You have not been paired for today's topic yet, and cannot take Attendance. If problem persists, kindly call the attention of your co-ordinator.";
            return response()->json(['message' => $message]);
        }

        if ($pair->student_one == $user) {
            $pair_username = $pair->student_two;
            $pair_fullname = $pair->student_two_fname;
        }
        else{
            $pair_username = $pair->student_one;
            $pair_fullname = $pair->student_one_fname;
        }

        //Create/Insert to DB
        $status = Attendance::create([
        'student_id' => $student->id,
        'username' => $student->username,
        'fullname' => $student->firstname.' '.$student->lastname,
        'pair' => $pair_username,
        'pair_fullname' => $pair_fullname,
        'topic' => $topic->title,
        'cohort' => $cohort->name,
        'system_ip' => $system_ip
        ]);


        //Response for Attendance
        if ($status) {
        $success = $student->lastname.', You have successfully registered your attendance for today !';
        $pairInfo = 'You have been paired with'.' '.$pair_fullname;
        return response()->json(['success' => $success, 'pairInfo' => $pairInfo]);
        }
    
        // return response()->json(null, 200);
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
