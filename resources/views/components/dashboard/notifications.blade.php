<button
    type="button"
    data-dropdown-toggle="notification-dropdown"
    class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
>
    <span class="sr-only">View notifications</span>
    <!-- Bell icon -->
    <svg
        aria-hidden="true"
        class="w-6 h-6"
        fill="currentColor"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
        ></path>
    </svg>
</button>
<div
    class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
    id="notification-dropdown"
>
    <div
        class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300"
    >
       Enhancements
    </div>

        <div
            x-data="{ enhancements: [{name:'enhancement 1',url:'https://www.youtube.com/watch?v=91fkcTxXkLI',duration:'2 days ago'},{name:'enhancement 2',url:'https://www.youtube.com/watch?v=5OzLrbk82zY',duration:'3 mins Ago'}]}"
            @custom-event.window="enhancements.unshift($event.detail.enhancement)"
        >

            <template x-for="enhancement in enhancements">
                <a href=""
                   x-bind:href="enhancement.url"
                   class="flex py-3 px-4 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600" >
                    <div class="pl-3 w-full">

                        <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                            Your Enhancement <span class="font-semibold text-gray-900 dark:text-white"
                            x-text="enhancement.name"
                            ></span> has been processed. Click here to enhance it.
                        </div>
                        <div
                            x-text="enhancement.duration"
                            class="text-xs font-medium text-primary-600 dark:text-primary-500" >
                        </div>
                    </div>
                </a>
            </template>
            <a
                href="#"
                class="block py-2 text-md font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline"
            >
                <div class="inline-flex items-center">
                    <svg
                        aria-hidden="true"
                        class="mr-2 w-4 h-4 text-gray-500 dark:text-gray-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        <path
                            fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    View all
                </div>
            </a>
        </div>
    </div>

<script type="module">
    const channel = 'user_channel-'+@json(auth()->user()->uuid);
    Echo.channel(channel).listen('.ResourceProcessed',(e) => {
        console.log(e);
        window.dispatchEvent(new CustomEvent('custom-event', { detail:{enhancement:{name:e.name,url:e.enhancementUrl,duration:e.duration}}}));
    });
</script>
