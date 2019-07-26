<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Topic;

use App\Track;

class TopicsController extends Controller
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

        $topics = Topic::orderBy('track_id')->latest()->paginate(5);

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
        ]);

        Topic::create([
            'title' => $data['title'],
            'track_id' => $data['track'],
            'duration' => $data['duration']
        ]);

        return redirect('/topics');

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
        Topic::find($id)->delete($id);
        return response()->json([
         'success' => 'Record deleted successfully!'
        ]);
    }
}
