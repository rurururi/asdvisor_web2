<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class PostList extends Component
{
    use WithPagination;

    public $category;
    public $body;

    public function save() 
    {
        if (Post::where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->exists()) {
            return redirect()->to('/community?errorOnePost')->with('status', 'You have already made a post today.');
        }
        
        if($this->body == "" || $this->category == "") {
            return redirect()->to('/community?error')->with('status', 'Post created!');
        }

        if($this->category == "1" || $this->category == "2" || $this->category == "3") {
            
            Post::create([
                'body' => $this->body,
                'category_id' => $this->category,
                'user_id' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            return redirect()->to('/community?success')->with('status', 'Post created!');
        } else {
            abort(403);
        }
    }

    public function render()
    {
        $this->category = $_GET['category'] ?? NULL;
        $post = null;
        if($this->category == "1" || $this->category == "2" || $this->category == "3") {
            $post = Post::where('category_id', $this->category)->orderBy('id', 'DESC')->paginate(10);
        } else {
            $post = Post::orderBy('id', 'DESC')->paginate(10);
        }

        return view('livewire.post-list', [
            'posts' => $post
        ]);
    }
}
