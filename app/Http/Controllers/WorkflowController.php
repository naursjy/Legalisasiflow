<?php

namespace App\Http\Controllers;

use App\Models\Stages;
use App\Models\User;
use App\Models\Workflows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{

    public function dash()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }
    public function dashboard()
    {
        $workflows = Workflows::all();
        return view('admin.dashboard', compact('workflows'));
        // return view('admin.dashboard');
    }
    public function index()
    {
        $workflows = Workflows::all();
        return view('admin.dashboard', compact('workflows'));
    }
    public function create()
    {
        return view('admin.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);
        Workflows::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id()
        ]);
        return redirect()->route('admin.dashboard');
    }

    public function destroy(Workflows $workflow)
    {
        // $workflow = Workflows::findOrFail($id);
        $workflow->delete(); // akan hapus stages & evidences otomatis

        return redirect()->route('admin.dashboard')
            ->with('success', 'berhasil dihapus');
    }

    public function createStage(Workflows $workflow)
    {
        // dd($workflow->stages);
        return view('admin.stages.create', compact('workflow'));
    }
    public function storeStage(Request $request, Workflows $workflow)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'order' => 'required|integer',
            'required_evidence_type' => 'required|in:document,image'
        ]);
        Stages::create([
            'workflow_id' => $workflow->id,
            'name' => $request->name,
            'description' => $request->description,
            'order' => $request->order,
            'required_evidence_type' => $request->required_evidence_type
        ]);
        return redirect()->route('admin.workflows.show', $workflow);
    }
    public function destroyStage(Stages $stage)
    {
        // $stage = Stages::findOrFail($id);
        $stage->delete(); // Cascade akan hapus evidences otomatis

        return back()->with('success', 'berhasil dihapus');
    }

    public function assign(Workflows $workflow)
    {
        $users = User::where('role', 'user')->get();
        return view('admin.assign', compact('workflow', 'users'));
    }
    public function storeAssign(Request $request, Workflows $workflow)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $workflow->assignedUsers()->attach($request->user_id);
        return redirect()->route('admin.workflows.index');
    }
    public function show(Workflows $workflow)
    {
        // $workflows = Workflows::with('stages')->get();
        // $stages = Stages::all();
        // dd($workflow->stages);
        return view('admin.show', compact('workflow'));
    }
}
