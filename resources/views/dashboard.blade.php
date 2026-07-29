<x-app-layout>
    <div class="flex h-screen bg-zinc-100 dark:bg-zinc-950">
        <aside id="sidebar-wrapper"
            class="bg-white dark:bg-zinc-900 shadow-lg w-64
           fixed lg:static inset-y-0 left-0
           h-full flex flex-col
           transform -translate-x-full lg:translate-x-0
           transition-[width,transform] duration-300 ease-in-out
           overflow-hidden
           z-40">
            <div class="w-full p-5 text-zinc-900 dark:text-white flex items-center justify-between gap-2">
                <div id="sidebar-brand" class="min-w-0 overflow-hidden whitespace-nowrap transition-opacity duration-150">
                    <h1 class="font-semibold text-sm">Management System</h1>
                    <h1 class="text-md md:text-md font-bold"></h1>
                </div>
                <button id="sidebar-collapse-toggle" type="button"
                    class="hidden lg:flex shrink-0 p-1.5 rounded-lg text-zinc-400 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-950/40 transition"
                    title="Collapse navigation">
                    <svg id="sidebar-collapse-icon" class="w-4 h-4 transition-transform duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
            </div>

            <div class="w-full flex flex-col justify-between flex-grow overflow-y-auto overflow-x-hidden">
                <nav id="sidebar-menu" class="p-4 space-y-2 font-semibold">
                </nav>

            </div>
        </aside>

        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 lg:hidden"></div>

        <div class="flex-1 flex flex-col min-w-0">
            <button id="sidebar-toggle"
                class="lg:hidden absolute top-2 left-2 px-2 py-4 bg-orange-500 text-white rounded z-10">
                ☰
            </button>
            <header
                class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 shadow-sm dark:shadow-black/40 px-6 py-4 flex justify-between items-center">
                <h2 id="page-title" class="text-xl font-semibold text-zinc-900 dark:text-white max-lg:pl-5">
                    Dashboard
                </h2>

                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" id="notificationIcon"
                            class="relative p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
                            <svg class="h-6 w-6 text-gray-800 dark:text-gray-200" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span id="notifcount"
                                class="absolute top-0 right-0 block h-5 w-5 text-white rounded-full text-sm bg-red-500"></span>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="
    fixed lg:absolute
    inset-x-4 top-20 lg:inset-auto lg:right-0 lg:top-auto
    lg:mt-2
    w-auto lg:w-96
    max-h-[32rem]
    overflow-y-auto
    rounded-xl shadow-lg
    bg-white dark:bg-gray-800
    border border-gray-200 dark:border-gray-700
    z-50
"
                            style="display: none;" id="notificationWrapper">
                            <div
                                class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Notifications</h3>
                                <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Mark all as
                                    read</button>
                            </div>
                            <div id="notificationsContainer" class="divide-y divide-gray-200 dark:divide-gray-700">


                            </div>
                            <div class="text-center py-3 border-t border-gray-200 dark:border-gray-700">
                                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    See all notifications
                                </a>
                            </div>
                        </div>

                    </div>
                    <x-dropdown align="right" width="w-auto">
                        <x-slot name="trigger">
                            <button class="text-zinc-700 dark:text-zinc-200">
                                <div class="flex flex-col items-center justify-center">
                                    @if (Auth::user()->profile_photo_url)
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Avatar"
                                            class="h-10 w-10 rounded-full object-cover">
                                    @else
                                        <div
                                            class="h-10 w-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-semibold">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>
            <main id="content"
                class="flex-1 w-full overflow-y-auto bg-zinc-100 dark:bg-zinc-950 text-zinc-800 dark:text-zinc-200">
            </main>

        </div>
    </div>



</x-app-layout>
