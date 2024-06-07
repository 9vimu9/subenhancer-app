<x-dashboard.layout>
    <x-dashboard.header>
        <x-slot:title>New Enhancement</x-slot:title>
    </x-dashboard.header>
    <form action="{{route('submitEnhancement')}}" method="POST" enctype="multipart/form-data" >
        @csrf

    <h3 class="text-1xl font-extrabold text-gray-800 dark:text-white mt-10 mb-2">Title</h3>
    <div class="w-full mb-10">
        <div class="relative">
            <input type="text" id="name" name="name" value="{{old('name')}}" placeholder="Give a title for your enhancement" class="block w-full p-4 ps-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
        </div>
        @error('name')
        <div class="flex p-1 text-sm text-red-800 dark:text-red-400">{{ $message }}</div>
        @enderror
    </div>
    <h3 class="text-1xl font-extrabold dark:text-white text-gray-900 mt-4 mb-2">Upload Subtitle File</h3>
        <p class="mb-1 text-sm text-gray-500 dark:text-gray-300" id="video_url_help">Max File Size is 2MB</p>
    <input  id="subtitle_file" name="subtitle_file" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="subtitle_file_help">
        @error('subtitle_file')
            <div class="flex p-1 text-sm text-red-800 dark:text-red-400">{{ $message }}</div>
        @enderror
    <div class="mt-6 flex flex-row">
        <x-dashboard.header>
            <x-slot:title>Or</x-slot:title>
        </x-dashboard.header>
    </div>

    <h3 class="text-1xl font-extrabold text-gray-800 dark:text-white mt-2 mb-2">Copy Video URL</h3>
    <div class="w-full">
        <p class="mb-1 text-sm text-gray-500 dark:text-gray-300" id="video_url_help">URL must be a valid YouTube link</p>
        <div class="relative">
            <input type="text" id="video_url" name="video_url" value="{{old('video_url')}}" class="block w-full p-4 ps-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Copy Your URL here" />
        </div>
        @error('video_url')
        <div class="flex p-1 text-sm text-red-800 dark:text-red-400">{{ $message }}</div>
        @enderror
    </div>

    <div class="container mt-5 mx-0 min-w-full flex flex-col items-center">
        <button type="submit" name="start_enhance_btn" class="pl-10 pr-10 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-2xl hover:font-bold  px-5 py-2.5 text-center me-2 mb-2">Start Enhance</button>
    </div>
    </form>


    @if(session()->has('toast'))
        <div id="toast-default"
             class="z-50 fixed top-10 right-10 flex items-center w-full max-w-xs p-4 text-red-500 bg-white rounded-lg shadow dark:text-black-400 dark:bg-green-800"
             role="alert">
            {{--        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">--}}
            {{--            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">--}}
            {{--                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.147 15.085a7.159 7.159 0 0 1-6.189 3.307A6.713 6.713 0 0 1 3.1 15.444c-2.679-4.513.287-8.737.888-9.548A4.373 4.373 0 0 0 5 1.608c1.287.953 6.445 3.218 5.537 10.5 1.5-1.122 2.706-3.01 2.853-6.14 1.433 1.049 3.993 5.395 1.757 9.117Z"/>--}}
            {{--            </svg>--}}
            {{--            <span class="sr-only">Fire icon</span>--}}
            {{--        </div>--}}
            <div class="ms-3 text-sm font-normal">{{session()->get('toast')['message']}}</div>
            <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#toast-default" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

</x-dashboard.layout>
