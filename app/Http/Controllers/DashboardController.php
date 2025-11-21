<?php

namespace App\Http\Controllers;

use App\Models\Stages;
use App\Models\User;
use App\Models\Workflows;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dash()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    public function index()
    {
        // dd(auth()->user()->id, auth()->user()->assignedWorkflows);
        $workflows = auth()->user()->assignedWorkflows;
        // dd($workflows, get_class($workflows));

        return view('user.dashboard', compact('workflows'));
    }
    public function showWorkflow(Workflows $workflow)
    {
        if (!$workflow->assignedUsers()->where('user_id', auth()->id())->exists()) abort(403);
        // dd($workflow->stages);
        return view('user.show', compact('workflow'));
    }
    public function uploadEvidence(Request $request, Stages $stage)
    {
        $request->validate([
            'evidence' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);
        $file = $request->file('evidence');
        $path = $file->store('evidences', 'public');
        $stage->evidences()->create([
            'user_id' => auth()->id(),
            'file_path' => $path,
            'type' => $stage->required_evidence_type,
            'submitted_at' => now(),
        ]);
        // dd($stage->evidences());

        return back()->with('success', 'Evidence uploaded!');
    }
}
