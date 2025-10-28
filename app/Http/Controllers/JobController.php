<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Inertia\Inertia;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company')
            ->where('is_active', true)
            ->latest()
            ->paginate(10);

        return Inertia::render('Jobs/Index', [
            'jobs' => $jobs,
        ]);
    }

    public function show(Job $job)
    {
        $job->load('company');
        return Inertia::render('Jobs/Show', [
            'job' => $job,
        ]);
    }
}