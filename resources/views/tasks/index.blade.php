<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Todo List</h1>

        <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
            @csrf  <!-- N'oublie pas d'ajouter le token CSRF -->
            <h2 class="text-1xl font-bold">Tâche</h2>
            <div class="flex items-center">
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Un truc à faire"
                    class="border border-gray-300 px-3 py-2 mr-2 w-1/3"
                    required
                >
            </div>
            <button type="submit" class="border border-2 border-sky-500 text-black bg-sky-500 px-4 py-2 rounded">
                Ajouter
            </button>
        </form>



        <h1 class="text-2xl font-bold">Liste des tâches</h1>
        <ul class="min-w-full bg-white border border-gray-200">
            @foreach ($tasks as $task)
            <li class="flex items-center py-2 px-4 border-b">
                @if($task->done)
                <input type="checkbox" class="mr-2" id="task-{{ $task->id }}" checked>
                @else
                <input type="checkbox" class="mr-2" id="task-{{ $task->id }}">
                @endif
                <label for="task-{{ $task->id }}">{{ $task->name }}</label>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-black px-4 py-2 rounded hover:bg-red-600">Supprimer</button>
                </form>
            </li>
            @endforeach
        </ul>
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    </div>
</x-app-layout>
