<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class InputSearch extends Component
{

    public $task = "";

    public $tasks = [];

    public function updatedTask()
    {
        $this->tasks = Task::where('name', 'like', '%' . $this->task . '%')->get();
        $this->tasks = Task::where('name', 'like', '%' . $this->task . '%')->get()->unique('name');
        if ($this->task === '') {
            $this->tasks = [];
        }
    }

    public function selectTask($id)
    {
        $this->task = Task::find($id)->name;
        $this->tasks = [];
    }

    public function render()
    {
        return view('livewire.input-search');
    }
}
