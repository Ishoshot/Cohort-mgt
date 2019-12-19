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
            $message = 'Oops! [Inactive] The Cohort selected does not have permissions for Attendance. If problem persists, kindly call the attention of your co-ordinator. ';
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

        if (!(count($schedule) > 0)) {
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




    public function getPairedStudents(Request $request){

        $data = $request->validate([
             'cohort' => ['required']
         ]);

         $cohort_id = $data['cohort'];

         //To get schedule
         $cohort = Cohort::findorfail($cohort_id);
         $schedule = $cohort->schedule;

         //To get topic from schedule
         $topic = $schedule->where('start_date', '<=', date('Y-m-d'))
             ->where('end_date', '>=', date('Y-m-d'))->first();

        // Get Paired Students
         $pairedStudents = Pair::where('cohort_id', '=', $cohort_id)
             ->where('topic_id', '=', $topic->id)->get();

         if (count($pairedStudents) > 0) {
             return response()->json(['pairedStudents' => $pairedStudents]);
         }

    }




    public function mapPair(Request $request){
        [$one, $two] = $request->pairs;

        $cohort = Cohort::where('id', '=',$request->cohort_id)->first();
        $cohort_name = $cohort->name;

        $topic = Topic::where('id', '=', $request->topic_id)->first();
        $topic_title = $topic->title;

       // GET STUDENTS DETAILS

        $student_one = $one['username'];
        $student_one_fname = $one['firstname']." ".$one['lastname'];

        $student_two = $two['username'];
        $student_two_fname = $two['firstname']." ".$two['lastname'];

        // STUDENTS ONE EXISTS
        $StudentOneExist = Pair::where('topic_id', '=', $request->topic_id)
            ->where(function ($query) use($student_one)
            {
                $query->where('student_one', '=', $student_one)
                ->orWhere('student_two', '=', $student_one);
        })->first();

        if($StudentOneExist)
        {
            $StudentOneExist = [
                'message'=> " Oops!!! $student_one_fname have been paired with another Student on $topic_title"
            ];

            return response()->json($StudentOneExist);
        }


        // STUDENT TWO EXISTS
        $StudentTwoExist = Pair::where('topic_id', '=', $request->topic_id)
            ->where(function ($query) use($student_two)
            {
                $query->where('student_one', '=', $student_two)
                ->orWhere('student_two', '=', $student_two);
        })->first();

        if($StudentTwoExist)
        {
            $StudentTwoExist = [
                'message'=> "Oops!!! $student_two_fname have been paired with another Student for $topic_title"
            ];

            return response()->json($StudentTwoExist);
        }

        //INSERT  PAIR &  NECCESARY DETAILS
        $statusPair = Pair::create([
            'student_one' => $student_one,
            'student_two' => $student_two,
            'topic_id' => $request->topic_id,
            'cohort_id' => $request->cohort_id,
            'student_one_fname' => $student_one_fname,
            'student_two_fname' => $student_two_fname,
            'cohort_name' => $cohort_name,
            'topic_title' => $topic_title
        ]);

        if($statusPair)
        {
         $msg = [
            'success' => "Done!!! $student_one_fname & $student_two_fname were successfully paired for $topic_title"
        ];

            return response()->json($msg);
        }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


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

    public function loadCohorts()
    {
        $cohorts = Cohort::where('status', 1)->latest()->get();

        return response()->json(['cohorts' => $cohorts]);

    }


    public function getData(Request $request)
    {

        $students = Student::where('cohort_id', '=', $request->cohort)->get();

        $track = Cohort::where('id', '=', $request->cohort)->first();

        $track_id = $track->track_id;

        $topics = Topic::where('track_id', '=', $track_id)->get();

        return response()->json(['students' => $students, 'topics' => $topics]);

    }


}
