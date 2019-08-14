<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;
use App\Track;
use App\Cohort;
use App\Schedule;

class TopicsController extends Controller
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

        $tracks = Track::with('topics')->where('status', 1)->latest()->get();

        $topics = Topic::orderBy('track_id')->orderBy('index')->paginate(5);

        return view('topics.index',compact('date','time','tracks','topics'));
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
        $data = $request->validate([
            'title' => ['required','min:5','string','unique:topics'],
            'track' => ['required'],
            'duration' => ['required'],
            'index' => ['required'],
        ]);

        $exists = Topic::where([
            ['index', '=', $data['index']],
            ['track_id', '=', $data['track']]
            ])->get();

        // dd($exists);

        if(count($exists) >= 1 ){
            return redirect()->back()->with('message', 'Duplicate Entry: The selected index number has been assigned to an existing topic in the selected track.');
        }
        else{

            Topic::create([
                'title' => $data['title'],
                'track_id' => $data['track'],
                'duration' => $data['duration'],
                'index' => $data['index']
            ]);

            return redirect('/topics');
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
    public function update(Topic $topic)
    {
        $data = request()->validate([
            'start_date' => ['required','date'],
            'end_date' => ['required','date'],
        ]);

        $topic->update([
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);

        return back();

        // dd('Hello');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Topic::find($id)->delete($id);
        Schedule::where('topic_id', '=', $id)->delete();

        return response()->json([
         'success' => 'Record deleted successfully!'
        ]);
    }
}
