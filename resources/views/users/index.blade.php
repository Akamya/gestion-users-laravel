<x-app-layout>

<a href="{{ route('users.create') }}">Ajout</a>

<form action="{{ route('users.index') }}" method="GET" class="mb-4">
    <div class="flex items-center">
        <input
            type="text"
            name="search"
            value="{{ request()->input('search') }}"
            placeholder="Rechercher un utilisateur..."
            class="border border-gray-300 px-3 py-2 mr-2 w-1/3"
        >
        <button type="submit" class="btn btn-primary">
            Rechercher
        </button>
    </div>
</form>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Liste des Utilisateurs</h1>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nom</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Rôle</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->role }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('users.show', $user->id) }}" class="text-blue-500">Voir</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 ml-2">Modifier</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        @if($users->isEmpty())
        <p>Aucun utilisateur trouvé.</p>
        @endif


        <div class="mt-6">
            {{ $users->links() }}
        </div>


    </div>
</x-app-layout>
