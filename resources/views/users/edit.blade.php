<!-- resources/views/users/edit.blade.php -->

@component('layouts.app') <!-- Utilisation du layout avec $slot -->
    <h1>Modifier les informations de l'utilisateur</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nom de l'utilisateur -->
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 px-3 py-2">
        </div>

        <!-- Email de l'utilisateur -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 px-3 py-2">
        </div>

        <!-- Ajoute ici d'autres champs à modifier -->

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>



    </form>

    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>

    <!-- Lien pour retourner à la liste des utilisateurs -->
    <a href="{{ route('users.index') }}">Retour à la liste des utilisateurs</a>
@endcomponent
