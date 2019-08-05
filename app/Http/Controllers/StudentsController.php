<?php

namespace App\Http\Controllers;
use App\Cohort;
use App\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**;
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $date = date('l, m-F-Y');
        $time = date('H:i A');

        $cohorts = Cohort::where('status', 1)->latest()->get();
        $students = Student::orderBy('lastname')->orderBy('cohort_id')->paginate(5);

        return view('students.index', compact('date', 'time', 'cohorts','students'));
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
            'firstname' => ['required','min:3','string'],
            'lastname' => ['required', 'min:3', 'string'],
            'email' => ['required', 'min:3', 'string'],
            'phone' => ['required', 'min:3', 'string'],
            'username' => ['required', 'min:3', 'string'],
            'cohort' => ['required'],
            'e_contact' => ['required', 'min:3', 'string'],
            'e_phone' => ['required', 'min:3', 'string']
        ]);

        Student::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'cohort_id' => $data['cohort'],
            'e_contact' => $data['e_contact'],
            'e_phone' => $data['e_phone']
        ]);

        return redirect('/students');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
        $date = date('l, m-F-Y');
        $time = date('H:i A');

        return view('students.show', compact('student','date','time'));
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
        Student::find($id)->delete($id);
        return response()->json([
         'success' => 'Record deleted successfully!'
        ]);
    }
}
