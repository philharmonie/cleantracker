<div>
    <input type="text" wire:model="task" name="task" placeholder="Was?"
        class="rounded p-4 w-full bg-gray-100 border-none ">
    @if (count($tasks) > 0)
        <div class="bg-white rounded-xl w-full mt-2">
            @foreach ($tasks as $task)
                <div class="p-2 rounded hover:bg-gray-200 cursor-pointer" wire:click="selectTask({{ $task->id }})">
                    {{ $task->name }}
                </div>
            @endforeach
        </div>
    @endif
</div>
