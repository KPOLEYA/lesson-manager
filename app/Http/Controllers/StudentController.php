<?php

namespace App\Http\Controllers;

use App\Http\Resources\Student as StudentResource;
use App\Http\Resources\Level as LevelResource;
use App\Http\Requests\Student\Store as StoreRequest;
use App\Level;
use App\Student;
use App\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $this->authorize('viewAny', Student::class);

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
        $this->authorize('create', Student::class);

        return Inertia::render('students/Create', [
            'levels' => LevelResource::collection(Level::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('create', Student::class);

        DB::beginTransaction();
        try {
            $student = new Student($request->only(['name', 'firstname', 'birth_date',
                    'phone', 'email', 'class_option']));
            $student->level()->associate($request->get('level'));

            if($request->boolean('add_parents')){
                $parents = new Parents([
                    'name' => $request->get('name_parents'),
                    'firstname' => $request->get('firstname_parents'),
                    'phone' => $request->get('phone_parents'),
                    'email' => $request->get('email_parents'),
                    ]);
                $parents->save();
                $student->parents()->associate($parents);
            }

            $student->save();

            DB::commit();
            return redirect()->route('students.index')->with('success', "Élève créé avec succès");
        } catch (\Exception $ex) {
            DB::rollBack();
            logger()->error('[StudentController@create] - ' . $ex->getMessage());
            return redirect()->back()->with('error', "Impossible de créer l'élève");
        }
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
        $this->authorize('update', $student);

        return Inertia::render('students/Edit', [
            'student' => new StudentResource($student->load(['level', 'parents'])),
            'levels' => LevelResource::collection(Level::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, Student $student)
    {
        $this->authorize('update', $student);

        DB::beginTransaction();
        try {
            $student->update($request->only(['name', 'firstname', 'birth_date',
                    'phone', 'email', 'class_option']));
            $student->level()->associate($request->get('level'));

            if($request->boolean('add_parents')){
                if($student->parents) {
                    $student->parents->update([
                        'name' => $request->get('name_parents'),
                        'firstname' => $request->get('firstname_parents'),
                        'phone' => $request->get('phone_parents'),
                        'email' => $request->get('email_parents'),
                    ]);
                }
                else {
                    $parents = new Parents([
                        'name' => $request->get('name_parents'),
                        'firstname' => $request->get('firstname_parents'),
                        'phone' => $request->get('phone_parents'),
                        'email' => $request->get('email_parents'),
                        ]);
                    $parents->save();
                    $student->parents()->associate($parents);
                }
            }

            $student->save();

            DB::commit();
            return redirect()->route('students.index')->with('success', "Élève modifié avec succès");
        } catch (\Exception $ex) {
            DB::rollBack();
            logger()->error('[StudentController@update] - ' . $ex->getMessage());
            return redirect()->back()->with('error', "Impossible de modifier l'élève");
        }
    }

    /**
     * Enable the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request, Student $student)
    {
        $this->authorize('enable',$student);

        DB::beginTransaction();
        try {
            $student->is_active = true;
            $student->save();

            DB::commit();
            return redirect()->route('students.index')->with('success', "Élève activé avec succès");
        } catch (\Exception $ex) {
            DB::rollBack();
            logger()->error('[StudentController@enable] - ' . $ex->getMessage());
            return redirect()->back()->with('error', "Impossible d'activer l'élève");
        }
    }

    /**
     * Enable the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request, Student $student)
    {
        $this->authorize('disable',$student);

        DB::beginTransaction();
        try {
            $student->is_active = false;
            $student->save();

            DB::commit();
            return redirect()->route('students.index')->with('success', "Élève désactivé avec succès");
        } catch (\Exception $ex) {
            DB::rollBack();
            logger()->error('[StudentController@disable] - ' . $ex->getMessage());
            return redirect()->back()->with('error', "Impossible de désactiver l'élève");
        }
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
