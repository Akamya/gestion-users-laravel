<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les tâches de l'utilisateur authentifié et les paginer
        $tasks = auth()->user()->tasks()->paginate(10);

        return view('tasks.index', ['tasks' => $tasks]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $validatedData = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // $validatedData['user_id'] = auth()->id();

        Task::create([
            'name' => $validatedData['name'],
            'user_id' => $userId,
            'done' => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Utilisation de findOrFail pour s'assurer que l'utilisateur existe
    $task = Task::findOrFail($id);

    // Suppression de l'utilisateur
    $task->delete();

    // Redirection avec un message de succès
    return redirect()->route('tasks.index')->with('success', 'Task supprimé avec succès');
}
}
