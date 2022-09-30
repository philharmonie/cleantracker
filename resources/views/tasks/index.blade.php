<x-app-layout>

    <div class="flex items-center justify-between p-8 mb-8 bg-white shadow-xl rounded-xl">

        <div class="grid w-12 h-12 p-2 font-bold text-white bg-red-800 rounded-full place-content-center">
            {{ Str::substr(auth()->user()->name, 0, 1) }}
        </div>

        <div class="text-2xl font-bold">
            {{ auth()->user()->points }} : {{ auth()->user()->partner->points }}
        </div>

        <div class="grid w-12 h-12 p-2 font-bold text-white bg-red-800 rounded-full place-content-center">
            {{ Str::substr(auth()->user()->partner->name, 0, 1) }}
        </div>

    </div>

    <form method="post" action="{{ Route('tasks.store') }}" class="p-8 mb-8 bg-white shadow-xl rounded-xl">
        @csrf
        @error('task')
            <div class="text-sm text-red-500">Bitte eine Aufgabe angeben</div>
        @enderror
        <livewire:input-search />
        <div class="flex items-center justify-between mt-4">
            <label class="cursor-pointer">
                <input type="radio" name="points" value="1" class="hidden peer" checked>
                <div
                    class="px-8 py-2 text-gray-400 bg-gray-200 rounded peer-checked:bg-red-800 peer-checked:text-white peer-checked:font-bold">
                    1
                </div>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="points" value="2" class="hidden peer">
                <div
                    class="px-8 py-2 text-gray-400 bg-gray-200 rounded peer-checked:bg-red-800 peer-checked:text-white peer-checked:font-bold">
                    2
                </div>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="points" value="3" class="hidden peer">
                <div
                    class="px-8 py-2 text-gray-400 bg-gray-200 rounded peer-checked:bg-red-800 peer-checked:text-white peer-checked:font-bold">
                    3
                </div>
            </label>
        </div>
        @push('scripts')
            <script src="https://unpkg.com/flowbite@1.5.3/dist/datepicker.js"></script>
        @endpush
        @push('styles')
            <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
        @endpush
        @error('date')
            <div class="relative mt-2 text-sm text-red-500 -bottom-4">Bitte ein Datum wählen</div>
        @enderror
        <div class="relative mt-4">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input datepicker datepicker-autohide datepicker-format="dd.mm.yyyy" type="text" name="date"
                class="block w-full p-4 pl-10 text-center bg-gray-100 border border-none rounded-lg sm:text-sm"
                placeholder="Datum wählen" value="{{ now()->format('d.m.Y') }}">
        </div>
        <button type="submit"
            class="w-full p-4 mt-4 font-semibold tracking-wide text-white bg-red-800 rounded-md hover:bg-red-700">+
            Hinzufügen</button>
    </form>

    <div class="flex justify-end pr-4 mb-8 text-gray-500">
        <div>
            Sortieren nach: <a href="{{ Route('tasks.index', ['sort' => 'date']) }}"
                class="font-bold text-red-800">Datum</a> | <a href="{{ Route('tasks.index', ['sort' => 'latest']) }}"
                class="font-bold text-red-800">Neuste</a>
        </div>
    </div>

    @forelse ($tasks as $task)
        <div class="flex items-stretch justify-between mb-8 shadow-xl rounded-xl">
            <div class="flex items-center justify-between w-full p-4 bg-white rounded-l-xl">
                <div class="flex items-center">
                    <div
                        class="grid w-8 h-8 p-2 mr-2 font-bold text-white bg-red-800 rounded-full place-content-center">
                        {{ Str::substr($task->user->name, 0, 1) }}
                    </div>
                    <div class="font-bold">
                        {{ $task->name }}
                    </div>
                </div>
                <div>
                    {{ $task->date->format('d.m.Y') }}
                </div>

            </div>
            <div class="grid flex-1 p-2 font-bold text-white bg-red-800 rounded-r-xl place-content-center">
                +{{ $task->points }}
            </div>
        </div>

    @empty
        Keine Aufgaben vorhanden.
    @endforelse

    {{ $tasks->links() }}

    <div class="mb-16"></div>

</x-app-layout>
