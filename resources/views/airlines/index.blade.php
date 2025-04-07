<x-layout.layout :title="'Airlines'">
    @slot('filters')
        <div class="flex w-full justify-between items-center">
            <div>
                <div class="mx-auto max-w-7xl sm:flex sm:items-center">
                    <h3 class="text-sm font-medium text-gray-500">
                        Filters
                    </h3>
                <div aria-hidden="true" class="hidden h-5 w-px bg-gray-300 sm:ml-4 sm:block"></div>
        
                <div class="mt-2 sm:mt-0 sm:ml-4">
                    <div id="active-filter-options" class="-m-1 flex flex-wrap items-center"></div>
                </div>
                </div>
            </div>
            <div>
                <div class="mx-auto flex max-w-7xl items-center justify-end">
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
                                <div id="filter-options-body" class="p-4 gap-2 flex flex-col" role="none"></div>
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
    </div>
    @endslot()

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
    const filterByNumFlights = debounce((numActiveFlights) => {
        $('#active-filter-options').find('.active-num-flights').remove();
        const filterObjectId = `${numActiveFlights}-active-num-flights`
        if (numActiveFlights.trim()!=='') {
            numActiveFlightsFilter = numActiveFlights;
            $('#active-filter-options').append(setFilterObject(filterObjectId, numActiveFlights, 'active-num-flights'));
        } else {
            numActiveFlightsFilter = null;
        }
        loadAirlines()
    });


     $(document).ready(async function() {
        await loadFilterOptions();
    });

    const setFilterObject = (objectId, filterValue, classValue, cityId=null) => {
        return `<span id="${objectId}" class="m-1 inline-flex items-center rounded-full border border-gray-200 bg-white py-1.5 pr-2 pl-3 text-sm font-medium text-gray-900 ${classValue}">
                    <span>${filterValue}</span>
                    <button type="button" class="ml-1 inline-flex size-4 shrink-0 rounded-full p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-500" data-city="${filterValue}" onclick="unselectFilter(${cityId}, '${objectId}')">
                        <span class="sr-only">Remove filter for Objects</span>
                        <svg class="size-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                    </button>
            </span>`
    }

    const setCityFilterOption = (city) => {
        return `<div class="flex gap-3">
                  <div class="flex h-5 shrink-0 items-center">
                    <div class="group grid size-4 grid-cols-1">
                      <input id="${city.id}-city" value=${city.name} onclick="selectCityFilter(this.id, ${city.id}, '${city.name}')" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                      <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                        <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </div>
                  </div>
                  <label class="text-sm text-gray-500">${city.name}</label>
                </div>
        `
    }

    const selectCityFilter = (inputId, cityId, cityName) => {
        const filterObjectId = `${cityId}-active-city`
        if (cityFilterIds.includes(cityId)) {
            $(`#${filterObjectId}`).remove()
            cityFilterIds = cityFilterIds.filter(ids => ids != cityId);
        } else {
            $('#active-filter-options').append(setFilterObject(filterObjectId, cityName, 'active-city', cityId));
            cityFilterIds.push(cityId);
        }
        loadAirlines();

    }

    const unselectFilter = (cityId, filterDivId) => {
        if (cityId) {
            cityFilterIds = cityFilterIds.filter(id => id != cityId)
        } else {
            numActiveFlightsFilter = null;
            $('#num-active-flights-input').val('');

        }
        $(`#${filterDivId}`).remove();
        loadAirlines();
    }

    const loadFilterOptions = async () => {
        const response = await getCities(null, '', '');
        let options = '';
        response.data.forEach(city => {
            options += setCityFilterOption(city);
        });
        $('#filter-options-body').html(options);
      }; 
</script>

