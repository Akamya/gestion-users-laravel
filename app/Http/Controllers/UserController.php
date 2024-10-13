<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Récupérer le paramètre 'search' depuis la requête
        $search = $request->input('search');

        // Construire la requête de base
        $query = User::query();

        // Si un terme de recherche est fourni, appliquer un filtre insensible à la casse
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(email) like ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Paginer les résultats (10 utilisateurs par page)
        $users = $query->paginate(10);

        // Retourner la vue avec les utilisateurs
        return view('users.index', ['users' => $users, 'search' => $search]);
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // Utilisation de la méthode findOrFail pour obtenir un utilisateur par son ID
        $user = User::findOrFail($id);

        // dd($user);

        // Retourne la vue avec les informations de l'utilisateur
        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
        // compact('user') = ['user' => $user]
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Valider les données d'entrée
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id, // Éviter le conflit d'email avec soi-même
        // Ajouter d'autres champs de validation si nécessaire
    ]);

    // Récupérer l'utilisateur à modifier
    $user = User::findOrFail($id);

    // Mettre à jour les informations de l'utilisateur avec les données validées
    $user->update($validatedData);

    // Rediriger vers la liste des utilisateurs avec un message de succès
    return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Utilisation de findOrFail pour s'assurer que l'utilisateur existe
    $user = User::findOrFail($id);

    // Suppression de l'utilisateur
    $user->delete();

    // Redirection avec un message de succès
    return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
}

}
