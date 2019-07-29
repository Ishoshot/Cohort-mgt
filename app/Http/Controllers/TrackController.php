<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Track;
 use App\Topic;
class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Displays the current date and time
        $date = date('l, m-F-Y');
        $time = date('H:i A');

        //Fetch latest tracks from DB
        $track = Track::latest()->paginate(10);

        //Get total count of tracks
        return view('track.index', compact('date', 'time', 'track', 'countTrack'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $change = Track::find($request->id);
        $change->status = $request->status;
        $change->save();

        return response()->json(['success'=>'Status change successfully.']);
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
        $data = $request->validate([
            'title' => ['required', 'unique:tracks', 'string'],
            'track_status' =>'required'
        ]);

        Track::create([
            'title' => $data['title'],
            'status' => $data['track_status']
        ]);
            return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {

    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         //Find Track ID and delete
        Track::find($id)->delete($id);
        Topic::where('track_id', '=', $id)->delete();

         return response()->json([
             'success' => 'Record deleted successfully!'
         ]);
    }
}
