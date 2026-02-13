<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Survey::where('user_id', Auth::id());

        // Obtener todas las fechas donde hay encuestas (para el calendario)
        $surveyDates = Survey::where('user_id', Auth::id())
            ->pluck('start_date')
            ->map(function ($date) {
                // Asegurarse de tener solo la parte de fecha Y-m-d
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        // Filtro por Fecha de Inicio (Desde)
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('status') && $request->status != 'Todas') {
            $isActive = $request->status == 'Activas';
            $query->where('is_active', $isActive);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $surveys = $query->orderBy('created_at', 'desc')->get();

        return view('surveys.index', compact('surveys', 'surveyDates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'settings' => 'array',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.required' => 'nullable',
        ]);

        // Asegurar que questions sea un array indexado (lista) y procesar checkboxes
        $questions = array_values($validated['questions']);
        foreach ($questions as &$question) {
            $question['required'] = isset($question['required']); // Convertir "on" a boolean
        }
        $validated['questions'] = $questions;

        // Procesar settings (checkboxes no enviados si no están marcados)
        $defaultSettings = [
            'anonymous' => false,
            'collect_names' => false,
            'collect_emails' => false,
            'allow_multiple' => false,
        ];
        $validated['settings'] = array_merge($defaultSettings, $request->input('settings', []));
        // Convertir valores de settings a boolean
        foreach ($validated['settings'] as $key => $value) {
            $validated['settings'][$key] = (bool) $value;
        }

        $survey = new Survey($validated);
        $survey->user_id = Auth::id();
        $survey->is_active = true; // Por defecto activa
        $survey->save();

        return redirect()->route('surveys.index')->with('success', 'Encuesta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        return view('surveys.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'settings' => 'array',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.required' => 'nullable',
        ]);

        // Asegurar que questions sea un array indexado (lista) y procesar checkboxes
        $questions = array_values($validated['questions']);
        foreach ($questions as &$question) {
            $question['required'] = isset($question['required']); // Convertir "on" a boolean
        }
        $validated['questions'] = $questions;

        // Procesar settings
        $defaultSettings = [
            'anonymous' => false,
            'collect_names' => false,
            'collect_emails' => false,
            'allow_multiple' => false,
        ];
        $validated['settings'] = array_merge($defaultSettings, $request->input('settings', []));
        // Convertir valores de settings a boolean
        foreach ($validated['settings'] as $key => $value) {
            $validated['settings'][$key] = (bool) $value;
        }

        $survey->update($validated);

        return redirect()->route('surveys.index')->with('success', 'Encuesta actualizada exitosamente.');
    }

    /**
     * Toggle status (Habilitar/Inhabilitar)
     */
    public function toggleStatus(Survey $survey)
    {
        $survey->is_active = !$survey->is_active;
        $survey->save();

        $status = $survey->is_active ? 'habilitada' : 'inhabilitada';
        return back()->with('success', "Encuesta {$status} correctamente.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'Encuesta eliminada.');
    }
}
