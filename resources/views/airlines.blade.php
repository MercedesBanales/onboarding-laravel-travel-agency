<x-layout.layout>
    <div class="flex flex-col w-full bg-white">
        <div class="bg-white">
            <!-- Filters -->
            <section aria-labelledby="filter-heading">
            <div class="border-b border-gray-200 bg-white py-4">
                <div class="mx-auto flex max-w-7xl items-center justify-end px-4 sm:px-6 lg:px-8">
                <div class="hidden sm:block">
                    <div class="flow-root">
                    <div class="-mx-4 flex items-center divide-x divide-gray-200">
                        <div class="relative inline-block px-4 text-left w-fit">
                            <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" aria-expanded="false" onclick="toggleCityOptions('#filter-city-options')">
                                <span>City</span>
                                <svg class="-mr-1 ml-1 size-5 shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="filter-city-options" class="absolute left-0 z-10 mt-2 w-fit origin-top-left rounded-md h-28 overflow-y-auto bg-white ring-1 shadow-2xl ring-black/5 focus:outline-hidden hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div id="filter-options-body" class="py-1" role="none"></div>
                            </div>
                        </div>
                        <div class="relative inline-block px-4 text-left">
                            <div class="flex justify-center items-center gap-2">
                                <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" aria-expanded="false">
                                    <span>Number of active flights:</span>
                                </button>
                                <input id="num-active-flights-input" type="number" oninput="filterByNumFlights(this.value)" class="w-20 rounded-md border border-gray-300 px-3 py-2 text-sm" min="0"/>
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
                    <div id="active-filter-options" class="-m-1 flex flex-wrap items-center"></div>
                </div>
                </div>
            </div>
            </section>
        </div>
    </div>
    <div class="flex w-full justify-end">
        <div class="px-4 sm:px-6 lg:px-8">
            <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" onclick="openForm('create-airline-modal')">
              Create airline
            </button>
          </div>
    </div>
        
    <x-airline.table />
    <div id="pagination-component" class="flex items-center justify-between px-8"></div>
</x-layout.layout>
<x-airline.create-form />
<x-airline.edit-form />

<script>
    $(document).on("click", "#filter-options-body button", function () {
        let cityId = null;
        const activeFilter = $("#filter-options-body .active-city");
        $('#active-filter-options').find('.active-city').remove();
        if (!$(this).hasClass('active-city')) {
            cityId = parseInt($(this).attr('id').split('-')[0])
            $(this).addClass("text-gray-900 font-medium active-city");
            $('#active-filter-options').append(setFilterObject($(this).text().trim(), 'active-city'));
        }
        activeFilter.removeClass("text-gray-900 font-medium active-city");
        activeFilter.addClass("text-gray-500");
        $('#airline-table-component').attr('city-id-filter', cityId);
        loadAirlines();
    });

    $(document).on('click', '.remove-filter-btn', function () {
        const cityName = $(this).data('city');
        $(this).closest('span').remove();

        if (isNaN(cityName)) {

            $("#filter-options-body button").each(function () {
                if ($(this).text().trim() === cityName) {
                    $(this).removeClass("text-gray-900 font-medium"); 
                    $(this).addClass("text-gray-500")
                }
            });

            $('#airline-table-component').removeAttr('city-id-filter');
        } else {
            $('#num-active-flights-input').val('');
            $('#airline-table-component').removeAttr('num-active-flights-filter');
        }

        loadAirlines()
    });

    const filterByNumFlights = debounce((numActiveFlights) => {
        $('#airline-table-component').attr('num-active-flights-filter', numActiveFlights);
        $('#active-filter-options').find('.active-num-flights').remove();
        if (numActiveFlights.trim()!=='') {
            $('#active-filter-options').append(setFilterObject(numActiveFlights, 'active-num-flights'));
        }
        loadAirlines()
    });


     $(document).ready(function() {
        loadFilterOptions();
    });

    const setFilterObject = (filterValue, classValue) => {
        return `<span class="m-1 inline-flex items-center rounded-full border border-gray-200 bg-white py-1.5 pr-2 pl-3 text-sm font-medium text-gray-900 ${classValue}">
                    <span>${filterValue}</span>
                    <button type="button" class="ml-1 inline-flex size-4 shrink-0 rounded-full p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-500 remove-filter-btn" data-city="${filterValue}">
                        <span class="sr-only">Remove filter for Objects</span>
                        <svg class="size-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                    </button>
            </span>`
    }

    const setCityFilterOption = (city) => {
        return `
            <button id="${city.id}-city" class="w-full block px-4 py-2 text-sm text-start font-medium text-gray-500 whitespace-nowrap hover:bg-gray-100" role="menuitem" tabindex="-1" id="menu-item-0">
                ${city.name}
            </button>
        `
    }

    const loadFilterOptions = () => {
        getCities(null, '', '', function(response) {
          let options = '';

          response.data.forEach(city => {
            options += setCityFilterOption(city);
          });

          $('#filter-options-body').html(options);
      });
    } 
</script>

