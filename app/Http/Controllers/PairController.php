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
        $date = date('l, d-F-Y');
        $time = date('H:i A');
        $cohorts = Cohort::where('status', 1)->latest()->get();
        $pairs = Pair::orderBy('cohort_id')->orderBy('topic_id')->orderBy('student_one_fname')->latest()->paginate(5);
        return view('pair.index', compact('time','date', 'cohorts', 'pairs'));
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

    public function pairing()
    {
        $date = date('l, d-F-Y');
        $time = date('H:i A');
        return view('pair.pairing', compact('time','date'));
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
        $date = date('l, d-F-Y');
        $time = date('H:i A');

        // Validate data requests
        $data = $request->validate([
            'cohort' => 'required'
        ]);

        $students = Student::where('cohort_id', '=', $request->cohort)->get();

        $track = Cohort::where('id', '=', $request->cohort)->first();
        $track_id = $track->track_id;

        $topics = Topic::where('track_id', '=', $track_id)->get();

        return view('pair.pair', compact('students', 'topics', 'date', 'time'));

    }


    public function mappairs(Request $request)
    {

        $cohort = Cohort::where('id', '=',$request->cohort_id)->first();
        $cohort_name = $cohort->name;

        $topic = Topic::where('id', '=', $request->topic_id)->first();
        $topic_title = $topic->title;

       // CHECK IF STUDENTS HAVE BEEN PAIRED FOR THE TOPIC

            $student_one = $request->student_one;
            $student_two = $request->student_two;

            $pairExist = Pair::where('topic_id', '=', $request->topic_id)
                ->where(function ($query) use($student_one,$student_two)
                {
                    $query->where('student_one', '=', $student_one)
                    ->where('student_two', '=', $student_two);
            })->first();


            if($pairExist)
            {
                $msgExists = [

                    'success'=> true,

                    'pairExists' => ' Oh No!! <b>'.$request->student_one_fname .' </b>& <b>'
                    . $request->student_two_fname.' </b> already exists for <b>'.$topic_title.'</b>'
                ];

                return response()->json($msgExists);
            }

        //INSERT  PAIR &  NECCESARY DETAILS
        $statusPair = Pair::create([
                'student_one' => $request->student_one,
                'student_two' => $request->student_two,
                'topic_id' => $request->topic_id,
                'cohort_id' => $request->cohort_id,
                'student_one_fname' => $request->student_one_fname,
                'student_two_fname' => $request->student_two_fname,
                'cohort_name' => $cohort_name,
                'topic_title' => $topic_title
        ]);
        if($statusPair)
        {
         $msg = [

            'success'=> true,

            'successmsg' => ' Done!! <b>'.$request->student_one_fname .' </b>& <b>'
            . $request->student_two_fname.' </b> were successfully paired for <b>'.$topic_title.'</b>'
        ];

            return response()->json($msg);
        }


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
        Pair::find($id)->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
