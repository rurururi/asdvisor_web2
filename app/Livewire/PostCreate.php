<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostCreate extends Component
{
    public $body;
    public $category;

    public function save() 
    {
        abort(403);
        // if($this->category == "1" || $this->category == "2" || $this->category == "3") {
        //     Post::create([
        //         'body' => $this->body,
        //         'category_id' => $this->category,
        //         'user_id' => auth()->user()->id,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
    
        //     return redirect()->to('/community')->with('status', 'Post created!');
        // } else {
        //     abort(403);
        // }
    }

    public function render()
    {
        return view('livewire.post-create');
    }
}
