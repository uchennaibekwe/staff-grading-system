<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class EntryController extends Controller
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
    public function index(Request $request)
    {
        // only admins can see entries 
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('entries.create');
        }

        $entries = [];
        if ($request->filled('department')) {
            $department = Department::where('name', $request->department)->first();
            if (!$department) {
                return redirect()->route('entries.index')->with('error', 'Department Not Found.');
            }
            $entries =  Entry::where('department_id', $department->id)->with('user')->orderBy('updated_at', 'desc')->get();
        }
        $departments = Department::orderBy('created_at', 'desc')->get();
        return view('entries', compact('entries', 'departments') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $user = auth()->user();
        if (auth()->user()->isAdmin()) {
            // to edit a particular user's entry
            if (!$request->filled('user')) {
                // the user parameter wasn't sent
                return redirect()->back()->with('error', 'Only users can create appraisal entries!');
            }
            // else
            $user = User::find($request->user);
        }

        $entry = [];
        if ($request->filled('department')) {
            $department = Department::where('name', $request->department)->first();
            if (!$department) {
                return redirect()->route('entries.create');
            }
            $entry =  Entry::where('department_id', $department->id)->where('user_id', $user->id)->first();
        } else {
            if ($department = Department::latest('updated_at')->first()) {
                $entry =  Entry::where('department_id', $department->id)->where('user_id', $user->id)->first();
                return redirect()->to('/entries/create?department=' . strtolower($department->name));
            }
        }

        $departments = Department::orderBy('created_at', 'desc')->get();
        return view('create', compact('departments', 'entry', 'user'));
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
            'user_id' => 'required|numeric',
            'department_id' => 'required',
        ]);
        
        try {
            
            $data = $request->except(['comment', 'closed']);

            if (auth()->user()->isAdmin()) {
                // only admin can comment and close an appraisal
                $data['comment'] = $request->comment;
                if ($request->filled('closed')) 
                    $data['closed'] = true;
                else 
                    $data['closed'] = false;
                // return redirect()->back()->with('error', 'Only users can create appraisal entries!');
            }

            $total = 0;
            $fields = ['punctuality', 'professionalism', 'innovation', 'respect', 'communication', 'management', 'leadership', 'delivery', 'inclusiveness', 'appearance'];
            foreach ($fields as $field) {
                $total += $request->$field;
            }

            $data['total'] = $total;
 
            // check if entry has already been created or not
            // $check = Entry
            $data['user_id'] = $request->user_id; // add user id to the collection
            // Entry::create($data); //
            Entry::updateOrCreate(
                ['user_id' => $request->user_id, 'department_id' => $data['department_id']],
                $data
            );

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
        
        return redirect()->back()->with('success', 'Entry Created Successfully');
        // return $request->all();
    }

    public function markAsClosed(Request $request) {
        $request->validate([
            'id' => 'required|numeric',
            'comment' => 'required',
        ]);

        $entry = Entry::find($request->id);
        $entry->comment = $request->comment;
        $entry->closed = true;

        if ($entry->save()) {
            return redirect()->back()->with('success', 'Entry marked as completed!');
        }
    }
}
