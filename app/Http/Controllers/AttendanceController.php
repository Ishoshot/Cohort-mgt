<?php

namespace App\Http\Controllers;
use App\Http\Requests;

use App\Cohort;
use App\Schedule;
use App\Student;
use App\Topic;
use App\Track;
use App\Attendance;

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
        
        $username = trim($data['username']);

        $cohort_id = $data['cohort'];
        
        $cohort = Cohort::find($cohort_id);

        $student = Student::where('username', '=', $username)->first();
        
        if ($cohort->status !== 1) {
            $message = 'Oops! The Cohort selected is not active';
            return response()->json(['message'=> $message]);        
        }

        if (!$student) {
            $message = 'Invalid Username! Check your username and try again';
            return response()->json(['message'=> $message]);        
        }

        if ($student->cohort_id !== $cohort->id) {
            $message = 'Oops! You just selected the wrong cohort';
            return response()->json(['message'=> $message]);       
        } 

        //To get topic 
        $query = $cohort->schedule;

        $topic = $query->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))->first();

        //To check if exists
        $exists = Attendance::where('username', '=', $student->username)
        ->whereDate('created_at', '=', date('Y-m-d'))->first();

        if ($exists) {
            $message = $student->lastname.', Your attendance for today has been taken. If not you, kindly call the attention your co-ordinator.';
            return response()->json(['message' => $message]);
        }

        //Create/Insert to DB
        $status = Attendance::create([
        'student_id' => $student->id,
        'username' => $student->username,
        'fullname' => $student->lastname.' '.$student->firstname,
        'pair' => 'Folly',
        'pair_fullname' => 'Adesanya Boiy',
        'topic' => $topic->title,
        'cohort' => $cohort->name,
        'system_ip' => '127.0.0.012.34.56.6.78.89'
        ]);

        //Response for Attendance
        if ($status) {
        $success = $student->lastname.', You have successfully registered your attendance for today!';
        return response()->json(['success' => $success]);
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
