<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
    }

    public function assessJobRisk(string $title, string $description): array
    {
        $prompt = "Eres un auditor de ofertas laborales en México. Evalúa el riesgo (0-100) de extorsión, fraude o secuestro en esta vacante. Devuelve JSON con campos: risk_score (0-100) y risk_flags (array de strings con razones). Vacante:\nTitulo: {$title}\nDescripcion: {$description}\nResponde SOLO en JSON válido.";
        $res = Http::post($this->endpoint.'?key='.$this->apiKey, [
            'contents' => [[ 'parts' => [[ 'text' => $prompt ]]]],
        ]);
        if (!$res->successful()) {
            return ['risk_score' => null, 'risk_flags' => []];
        }
        $text = data_get($res->json(), 'candidates.0.content.parts.0.text', '{}');
        return json_decode($text, true) ?: ['risk_score' => null, 'risk_flags' => []];
    }

    public function generateCv(array $profile): string
    {
        $prompt = "Genera un CV en formato texto estructurado para un estudiante del CUCEI. Datos:\n".json_encode($profile, JSON_PRETTY_PRINT)."\nEl CV debe incluir: resumen, educación, habilidades, proyectos, experiencia (si existe), links. Devuelve solo el texto.";
        $res = Http::post($this->endpoint.'?key='.$this->apiKey, [
            'contents' => [[ 'parts' => [[ 'text' => $prompt ]]]],
        ]);
        if (!$res->successful()) return '';
        return data_get($res->json(), 'candidates.0.content.parts.0.text', '');
    }
}