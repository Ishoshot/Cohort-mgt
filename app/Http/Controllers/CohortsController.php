<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;
use App\Cohort;
use App\Track;

class CohortsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('l, m-F-Y');
        $time = date('H:i A');

        $tracks = Track::where('status', 1)->latest()->get();

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
            'name' => ['required','min:5','string'],
            'track' => ['required'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date','after:start_date'],
            'duration' => ['required'],
            'status' => ['required'],
        ]);

        $exists = Cohort::where([
            ['name', '=', $data['name']],
            ['track_id', '=', $data['track']]
            ])->get();

        // dd($exists);

        if(count($exists) >= 1 ){
            return redirect()->back()->with('message', 'Duplicate Entry: This cohort already offers the selected track.');
        }
        else
        {

            Cohort::create([
                'name' => $data['name'],
                'track_id' => $data['track'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'duration' => $data['duration'],
                'status' => $data['status']
            ]);

            return redirect('/cohorts');
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
        Cohort::find($id)->delete($id);

         return response()->json([
             'success' => 'Record deleted successfully!'
         ]);
    }
}
