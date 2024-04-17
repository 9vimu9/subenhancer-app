<x-dashboard.layout>
    <x-dashboard.header>
        <x-slot:title>New Enhancement</x-slot:title>
    </x-dashboard.header>
    <form action="{{route('submitEnhancement')}}" method="POST" enctype="multipart/form-data" >
        @csrf
    <h3 class="text-1xl font-extrabold dark:text-white text-gray-900 mt-4 mb-2">Upload Subtitle File</h3>
    <input  id="subtitle_file" name="subtitle_file" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="subtitle_file_help">
        @error('subtitle_file')
            <div class="flex p-1 text-sm text-red-800 dark:text-red-400">{{ $message }}</div>
        @enderror
    <div class="mt-6 flex flex-row justify-center items-center">
        <x-dashboard.header>
            <x-slot:title>Or</x-slot:title>
        </x-dashboard.header>
    </div>

    <h3 class="text-1xl font-extrabold text-gray-800 dark:text-white mt-3 mb-2">Copy Video URL</h3>
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
        <button type="submit" class="pl-10 pr-10 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Start Enhance</button>
    </div>
    </form>


</x-dashboard.layout>
