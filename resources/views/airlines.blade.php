<x-layout.layout>
    <div class="flex flex-col w-full bg-white">
        <div class="flex w-full justify-end">
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none px-4 sm:px-6 lg:px-8 lg:pt-6">
                <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" onclick="openForm('#create-airline-modal')">
                  Create airline
                </button>
              </div>
        </div>
       
        <div class="bg-white">
        
            <!-- Filters -->
            <section aria-labelledby="filter-heading">
            <div class="border-b border-gray-200 bg-white pb-4">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                
                <div class="hidden sm:block">
                    <div class="flow-root">
                    <div class="-mx-4 flex items-center divide-x divide-gray-200">
                        <div class="relative inline-block px-4 text-left">
                        <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" aria-expanded="false">
                            <span>Number of active flights</span>
                            <span class="ml-1.5 rounded-sm bg-gray-200 px-1.5 py-0.5 text-xs font-semibold text-gray-700 tabular-nums">1</span>
                            <svg class="-mr-1 ml-1 size-5 shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
        
                        <div class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 ring-1 shadow-2xl ring-black/5 focus:outline-hidden hidden">
                            <form class="space-y-4">
                            <div class="flex gap-3">
                                <div class="flex h-5 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input id="filter-category-0" name="category[]" value="new-arrivals" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                    <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                </div>
                                <label for="filter-category-0" class="pr-6 text-sm font-medium whitespace-nowrap text-gray-900">All New Arrivals</label>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex h-5 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input id="filter-category-1" name="category[]" value="tees" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                    <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                </div>
                                <label for="filter-category-1" class="pr-6 text-sm font-medium whitespace-nowrap text-gray-900">Tees</label>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex h-5 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input id="filter-category-2" name="category[]" value="objects" type="checkbox" checked class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                    <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                </div>
                                <label for="filter-category-2" class="pr-6 text-sm font-medium whitespace-nowrap text-gray-900">Objects</label>
                            </div>
                            </form>
                        </div>
                        </div>
                        <div class="relative inline-block px-4 text-left">
                        <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" aria-expanded="false">
                            <span>City</span>
                            <svg class="-mr-1 ml-1 size-5 shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
        
                        <div class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 ring-1 shadow-2xl ring-black/5 focus:outline-hidden hidden">
                            <form class="space-y-4">
                            <div class="flex gap-3">
                                <div class="flex h-5 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input id="filter-color-0" name="color[]" value="white" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                    <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                </div>
                                <label for="filter-color-0" class="pr-6 text-sm font-medium whitespace-nowrap text-gray-900">White</label>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex h-5 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input id="filter-color-1" name="color[]" value="beige" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                    <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                </div>
                                <label for="filter-color-1" class="pr-6 text-sm font-medium whitespace-nowrap text-gray-900">Beige</label>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex h-5 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input id="filter-color-2" name="color[]" value="blue" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                    <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                                    <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                </div>
                                <label for="filter-color-2" class="pr-6 text-sm font-medium whitespace-nowrap text-gray-900">Blue</label>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        
            <!-- Active filters -->
            <div class="bg-gray-100">
                <div class="mx-auto max-w-7xl px-4 py-3 sm:flex sm:items-center sm:px-6 lg:px-8">
                <h3 class="text-sm font-medium text-gray-500">
                    Filters
                </h3>
        
                <div aria-hidden="true" class="hidden h-5 w-px bg-gray-300 sm:ml-4 sm:block"></div>
        
                <div class="mt-2 sm:mt-0 sm:ml-4">
                    <div class="-m-1 flex flex-wrap items-center">
                    <span class="m-1 inline-flex items-center rounded-full border border-gray-200 bg-white py-1.5 pr-2 pl-3 text-sm font-medium text-gray-900">
                        <span>Objects</span>
                        <button type="button" class="ml-1 inline-flex size-4 shrink-0 rounded-full p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-500">
                        <span class="sr-only">Remove filter for Objects</span>
                        <svg class="size-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                        </button>
                    </span>
                    </div>
                </div>
                </div>
            </div>
            </section>
        </div>
    </div>
        
    <x-airline.table />
    <div id="pagination-component" class="flex items-center justify-between px-8"></div>
</x-layout.layout>
<x-airline.create-form />

<script>
     
</script>

