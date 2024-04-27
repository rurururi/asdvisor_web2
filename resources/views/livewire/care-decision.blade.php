<div>
    @if($category == "")
        <x-filament::button wire:click="setCategory('Speech Focused')" class="w-full block mb-4" style="padding: 30px 0px!important;">
            Speech Focused
        </x-filament::button>
        <x-filament::button wire:click="setCategory('Sensory Focused')"  class="w-full block mb-4" style="padding: 30px 0px!important;">
            Sensory Focused
        </x-filament::button>
        <x-filament::button wire:click="setCategory('Social Interaction')"  class="w-full block" style="padding: 30px 0px!important;">
            Social Interaction
        </x-filament::button>
    @endif

    @if($category != "")
        @if($modal == true)
        <div class="container mx-auto flex justify-center items-center px-4 md:px-10 py-20 mb-2 border-2 border-gray-800 dark:border-gray-800">
            <div class="px-3 md:px-4 py-12 flex flex-col justify-center items-center w-full">
                <h1 class="mt-8 md:mt-12 text-3xl lg:text-4xl font-semibold leading-10 text-center text-gray-800 text-center md:w-9/12 lg:w-7/12 dark:text-white mb-2">Result</h1>
                <p class="mt-10 text-base leading-normal text-center text-gray-600 md:w-9/12 lg:w-7/12 dark:text-white">{{$content}}</p>
                <div class="mt-12 md:mt-14 w-full flex justify-center">
                <button wire:click="close()" class="mt-3 dark:text-white dark:border-white w-full sm:w-auto border border-gray-800 text-base font-medium text-gray-800 py-5 px-14 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 hover:bg-gray-800 hover:text-white dark:hover:text-white dark:hover:bg-gray-700">Back to Care Decision</button>
                </div>
            </div>
        </div>
        @endif

        @if($modal != true)
        <div class="container mx-auto flex justify-center items-center px-4 md:px-10 py-20 flex-col border-2 border-gray-800 dark:border-gray-800">
            <div class="flex flex-row gap-2 mt-6">
                <x-filament::button wire:click="close()" class="mb-2">
                    <- Back to Care Decision
                </x-filament::button>
            </div>
            <div class="px-3 md:px-4 py-12 flex flex-col justify-center items-center w-full">
                {{$currentQuestionIndex + 1}}. {{$setQuestion}}
                <div class="flex flex-row gap-2 mt-2 mb-6">
                    <x-filament::button wire:click="nextQuestion('Yes')">
                        Yes
                    </x-filament::button>
                    <x-filament::button wire:click="nextQuestion('No')">
                        No
                    </x-filament::button>
                </div>
                
            </div>
        </div>
        @endif
    @endif
    
</div>
