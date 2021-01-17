<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request->filled('department');
        $entries = [];
        if ($request->filled('department')) {
            $department = Department::where('name', $request->department)->first();
            if (!$department) {
                return redirect()->route('entries.index')->with('error', 'Department Not Found.');
            }
            $entries =  Entry::where('department_id', $department->id)->with('user')->orderBy('created_at', 'desc')->get();
        }
        $departments = Department::orderBy('created_at', 'desc')->get();
        return view('entries', compact('entries', 'departments') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('created_at', 'desc')->get();
        return view('create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'department_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $data = $request->all();

            // check if this user is already registered
            $user = User::where('email', $data['email'])->first();
            if ($user) {
                // check if this user has an entry in the selected department
                if (Entry::where('department_id', $data['department_id'])->where('user_id', $user->id)->first())
                    return redirect()->back()->with('error', 'This user [email] entry has already been captured for the selected department')->withInput();
            } else {
                $data['password'] = bcrypt('password'); // create password for user
                $user = User::create($data); // create user
            }
            
            $data['user_id'] = $user->id; // add user id to the collection
            Entry::create($data); //
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage())->withInput();

        }
        
        return redirect()->back()->with('success', 'Entry Created Successfully');
        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        //
    }
}
