<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Services\GeminiService;

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

        // Verifica que la empresa pertenezca al usuario autenticado
        $company = Company::where('id', $data['company_id'])->where('user_id', Auth::id())->firstOrFail();

        // Crea la vacante
        $job = Job::create($data);

        // Llama a Gemini para evaluar el riesgo de la vacante
        $gemini = new GeminiService();
        $risk = $gemini->assessJobRisk($job->title, $job->description);

        // Actualiza el job con los datos de riesgo
        $job->risk_score = $risk['risk_score'] ?? null;
        $job->risk_flags = $risk['risk_flags'] ?? [];
        $job->save();

        return redirect()->route('company.jobs.index')->with('success', 'Vacante creada y evaluada por IA.');
    }
}