<!doctype html>
<html>
    <head>
            <title>Community | Asdvisor</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
            <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            @vite('resources/css/app.css')
            @livewireStyles
    </head>
    <body class="bg-white">
        <span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="openSidebar()">
            <i class="fa-solid fa-bars text-xl px-3 py-2 bg-gray-900 rounded-md"></i>
        </span>
        
        <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-900">
            <div class="text-gray-100 text-xl">
                <div class="p-2.5 mt-1 flex items-center">
                    <i class="fa-solid fa-house px-2 py-2 rounded-md bg-blue-600"></i>
                    <h1 class="font-bold text-gray-200 text-[15px] ml-3">Asdvisor</h1>
                    <i class="fa-solid fa-xmark cursor-pointer absolute right-4"
                        onclick="openSidebar()"
                        ></i>
                </div>
                <div class="my-2 bg-gray-600 h-[1px]"></div>
            </div>
            <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/web" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <i class="fa-solid fa-house"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Back to Home</span>
            </a>
            <div class="my-4 bg-gray-600 h-[1px]"></div>
            <!--<a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/community/create" class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">-->
            <!--    <i class="fa-solid fa-file"></i>-->
            <!--    <span class="text-[15px] ml-4 text-gray-200 font-bold">Create Post</span>-->
            <!--</a>-->
            <!--<div class="my-4 bg-gray-600 h-[1px]"></div>-->
            
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
                onclick="dropdown()"
                >
                <i class="fa-solid fa-list"></i>
                <div class="flex justify-between w-full items-center">
                    <span class="text-[15px] ml-4 text-gray-200 font-bold">Categories</span>
                    <span class="text-sm rotate-180" id="arrow">
                    <i class="fa-solid fa-caret-down"></i>
                    </span>
                </div>
            </div>
            <div
                class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold"
                id="submenu"
                >
                <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/community">
                    <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                        All
                    </h1>
                </a>
                <?php
                    $categories = \App\Models\Category::get();
                ?>
                @foreach($categories as $category)
                <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/community?category={{$category->id}}">
                    <h1 class="cursor-pointer p-2 hover:bg-blue-600 rounded-md mt-1">
                        {{$category->name}}
                    </h1>
                </a>
                @endforeach
            </div>
            <div class="my-4 bg-gray-600 h-[1px]"></div>
            <span class="font-bold text-white mb-4 block">Hello, {{auth()->user()->name}}!</span>
            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="my-auto"
            >
                @csrf

                <x-filament::button
                    color="gray"
                    icon="heroicon-m-arrow-left-on-rectangle"
                    icon-alias="panels::widgets.account.logout-button"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                </x-filament::button>
            </form>
        </div>

        {{ $slot }}
  
        @livewireScripts

        <script type="text/javascript">
            function dropdown() {
                document.querySelector("#submenu").classList.toggle("hidden");
                document.querySelector("#arrow").classList.toggle("!rotate-0");
            }
            dropdown();

            function openSidebar() {
                document.querySelector(".sidebar").classList.toggle("hidden");
            }
            openSidebar();
        </script>
    </body>
</html>