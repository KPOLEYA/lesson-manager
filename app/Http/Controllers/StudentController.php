<?php

namespace App\Http\Controllers;

use App\Http\Resources\Student as StudentResource;
use App\Http\Resources\Level as LevelResource;
use App\Level;
use App\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Student::class);

        $students = Student::with(['parents', 'level']);

        if ($request->wantsJson()) {

            if($request->filled('name')) {
                $students = $students->where('name', 'like', '%' . $request->get('name') . '%');
            }

            if($request->filled('level')) {
                $students = $students->where('level_id', $request->get('level'));
            }

            if($request->filled('status')) {
                $students = $students->where('is_active', $request->get('status'));
            }

            return StudentResource::collection($students->paginate(10));
        }

        return Inertia::render('students/Index',[
            'levels' => LevelResource::collection(Level::all()),
            'statutes' => Student::STATUTES,
        ]);
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
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
