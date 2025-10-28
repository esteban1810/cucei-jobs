<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Job $job): RedirectResponse
    {
        $data = $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        // Verifica si ya existe una postulación
        $alreadyApplied = JobApplication::where('user_id', Auth::id())
            ->where('job_id', $job->id)
            ->exists();



        if ($alreadyApplied) {
            return back()->with('error', 'Ya has aplicado a esta vacante.');
        }



        JobApplication::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'cover_letter' => $data['cover_letter'] ?? null,
            'status' => 'applied',
        ]);

        return back()->with('success', 'Has aplicado a esta vacante.');
    }
}
