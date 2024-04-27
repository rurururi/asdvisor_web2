<div class="container mx-auto">
    <div class="mx-4 md:mx-auto my-20 max-w-md md:max-w-2xl flex flex-col">
        <div class="px-4 py-6 mb-10 w-auto rounded-lg shadow-lg bg-white dark:bg-gray-900 text-black dark:text-white">
            <h1 class="block text-2xl font-bold mb-2">Create Post</h1>
            <form wire:submit="save" class="block"> 
                <label for="body" class="block">Body:</label>
                <textarea id="body" wire:model="body" class="mb-2 px-3 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required=""></textarea>
                
                <label for="category" class="block">Category:</label>
                <select id="category" wire:model="category" class="px-3 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required="">
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

        </div>
    </div>
</div>
