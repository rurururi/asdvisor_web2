<div class="container mx-auto">
  <div class="mx-4 md:mx-auto my-20 max-w-md md:max-w-2xl flex flex-col">
        @if(isset($_GET['success']))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Good job!</strong>
                <span class="block sm:inline">Successfully posted!</span>
            </div>
            <br/>
        @endif
        @if(isset($_GET['error']))You have already made a post today.
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">Must put the data to the body or category!</span>
            </div>
            <br/>
        @endif
        @if(isset($_GET['errorOnePost']))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">You have already made a post today.</span>
            </div>
            <br/>
        @endif
        <form wire:submit="save" class="px-4 py-6 flex items-start flex-col mb-10 w-auto rounded-lg shadow-lg bg-white dark:bg-gray-900 text-black dark:text-white"> 
            <textarea id="body" wire:model="body" placeholder="What's on your mind?" class="mb-2 px-3 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required=""></textarea>
            
            <label for="category" class="block">Category:</label>
            <select id="category" wire:model="category" class="px-3 w-[25   0px] text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required="">
                <?php
                    $categories = \App\Models\Category::get();
                ?>
                <option>Please select the category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="mt-2 inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">Create</button>
        </form>
        @if(count($posts) != 0)
            @foreach ($posts as $post)
                <?php
                $words = explode(" ", $post->user->name);
                $acronym = "";
                
                foreach ($words as $w) {
                $acronym .= mb_substr($w, 0, 1);
                }
                ?>
                <div class="px-4 py-6 flex items-start mb-10 w-auto rounded-lg shadow-lg bg-white dark:bg-gray-900 text-black dark:text-white" key="{{$post->id}}">
                    <div class="w-16 h-16 mr-4">
                        <img src="https://placehold.co/100x100?text={{$acronym}}" class="rounded-full shadow object-cover"/>
                    </div>
                    <div class="w-full">
                        <div class="flex items-center justify-start">
                            <h2 class="-mt-1 mr-1 text-lg text-gray-900 dark:text-white font-semibold">{{$post->user->name}} 
                            ({{$post->user->account_level == "Parents" ? "Parent" :$post->user->account_level}})</h2>
                        </div>
                        <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y h:i A') }} </div>
                        <div class="mt-3 text-sm text-gray-700 dark:text-white border-slate-100 border-solid border-b-2 pb-2">{{$post->body}}</div>
                        
                        <div class="my-2">
                            <livewire:comments :model="$post"/>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $posts->links() }}
        @endif
        @if(count($posts) == 0)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Holy smokes!</strong>
                <span class="block sm:inline">No results found.</span>
            </div>
        @endif
    </div>    
</div>