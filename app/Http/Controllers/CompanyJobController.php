<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CompanyJobController extends Controller
{
    public function index()
    {
        $companies = Company::where('user_id', Auth::id())->with('jobs')->get();
        return Inertia::render('Company/Jobs/Index', [
            'companies' => $companies,
        ]);
    }

    public function create()
    {
        $companies = Company::where('user_id', Auth::id())->get();
        return Inertia::render('Company/Jobs/Create', [
            'companies' => $companies,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'modality' => 'required|string|in:presencial,remoto,hibrido',
            'salary_min' => 'nullable|integer',
            'salary_max' => 'nullable|integer',
            'currency' => 'required|string|max:8',
        ]);

        // TODO: autorizar que la company pertenezca al usuario
        $job = Job::create($data);

        // TODO: evaluar riesgo con Gemini y actualizar risk_score/risk_flags

        return redirect()->route('company.jobs.index')->with('success', 'Vacante creada');
    }
}