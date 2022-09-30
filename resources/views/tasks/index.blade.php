<x-app-layout>

    <div class="p-8 flex items-center justify-between bg-white shadow-xl rounded-xl mb-8">

        <div class="bg-red-800 text-white rounded-full p-2 w-12 h-12 grid place-content-center font-bold">
            {{ Str::substr(auth()->user()->name, 0, 1) }}
        </div>

        <div class="text-2xl font-bold">
            {{ auth()->user()->points }} : {{ auth()->user()->partner->points }}
        </div>

        <div class="bg-red-800 text-white rounded-full p-2 w-12 h-12 grid place-content-center font-bold">
            {{ Str::substr(auth()->user()->partner->name, 0, 1) }}
        </div>

    </div>

    <form method="post" action="{{ Route('tasks.store') }}" class="p-8 bg-white shadow-xl rounded-xl mb-8">
        @csrf
        @error('task')
            <div class="text-red-500 text-sm">Bitte eine Aufgabe angeben</div>
        @enderror
        <livewire:input-search />
        <div class="mt-4 flex items-center justify-between">
            <label class="cursor-pointer">
                <input type="radio" name="points" value="1" class="hidden peer" checked>
                <div
                    class="bg-gray-200 text-gray-400 px-8 py-2 rounded peer-checked:bg-red-800 peer-checked:text-white peer-checked:font-bold">
                    1
                </div>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="points" value="2" class="hidden peer">
                <div
                    class="bg-gray-200 text-gray-400 px-8 py-2 rounded peer-checked:bg-red-800 peer-checked:text-white peer-checked:font-bold">
                    2
                </div>
            </label>
            <label class="cursor-pointer">
                <input type="radio" name="points" value="3" class="hidden peer">
                <div
                    class="bg-gray-200 text-gray-400 px-8 py-2 rounded peer-checked:bg-red-800 peer-checked:text-white peer-checked:font-bold">
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
            <div class="text-red-500 text-sm mt-2 relative -bottom-4">Bitte ein Datum wählen</div>
        @enderror
        <div class="relative mt-4">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input datepicker datepicker-autohide datepicker-format="dd.mm.yyyy" type="text" name="date"
                class="bg-gray-100 border text-center border-none sm:text-sm rounded-lg block w-full pl-10 p-4"
                placeholder="Datum wählen" value="{{ now()->format('d.m.Y') }}">
        </div>
        <button type="submit"
            class="mt-4 w-full bg-red-800 text-white rounded-md p-4 hover:bg-red-700 font-semibold tracking-wide">+
            Hinzufügen</button>
    </form>

    @forelse ($tasks as $task)
        <div class="shadow-xl rounded-xl mb-8 flex justify-between items-stretch">
            <div class="flex items-center justify-between bg-white p-4 rounded-l-xl w-full">
                <div class="flex items-center">
                    <div
                        class="bg-red-800 text-white rounded-full p-2 w-8 h-8 grid place-content-center mr-2 font-bold">
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
            <div class="bg-red-800 p-2 rounded-r-xl text-white font-bold flex-1 grid place-content-center">
                +{{ $task->points }}
            </div>
        </div>

        {{-- if the date changes to a new week, add a divider with calender week --}}
        @if ($loop->last || $task->date->format('W') !== $tasks[$loop->index + 1]->date->format('W'))
            <div class="text-center text-gray-500 mb-4">
                Kalenderwoche {{ $task->date->weekOfYear - 1 }}
            </div>
        @endif

    @empty
        Keine Aufgaben vorhanden.
    @endforelse

    {{ $tasks->links() }}

    <div class="mb-16"></div>

</x-app-layout>
