<?php
$record = $getState();
?>
<div class="w-full my-4 p-6 text-black dark:text-gray-200 rounded-lg shadow-lg">
    <div class="flex justify-between items-center">
        <span class="font-light text-gray-600">{{$record->created_at}}</span>
    </div>
    <div class="mt-2">
        <a class="text-2xl font-bold block" href="#">{{$record->title}}</a><br/>
        <?php
        if(strpos($record->image, 'image') !== false){
        ?>
        <img src='{{$record->image}}' class="w-auto relative"/>
        <?php
        } else {
            ?>
            
        <img src='https://{{ $_SERVER['SERVER_NAME'] }}/storage/{{$record->image}}' class="w-auto relative"/>
        <?php
        }
        ?>
        <p class="mt-2 ">{{$record->body}}</p>
    </div>
    <div class="flex justify-between items-center mt-4">
        <a class="text-blue-600 hover:underline" href="#"></a>
        <div>
            <a class="flex items-center gap-4" href="#">
            <?php
                $words = explode(" ", $record->doctor->name);
                $acronym = "";
                
                foreach ($words as $w) {
                $acronym .= mb_substr($w, 0, 1);
                }
                ?>
                <img class="mx-4 w-10 h-10 object-cover rounded-full hidden sm:block" src="https://placehold.co/100x100?text={{$acronym}}" alt="avatar">
                <h1 class="font-bold">{{$record->doctor->name}}</h1>
            </a>
        </div>
    </div>
</div>