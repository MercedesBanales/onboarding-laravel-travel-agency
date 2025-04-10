<x-layout.layout :title="'Flights'">
    @slot('filters')
    @endslot()
    <div class="flex w-full justify-end px-4 sm:px-6 lg:px-8 lg:pt-6">
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" onclick="openForm('create-flight-modal')">
              Create flight
            </button>
          </div>
    </div>
    <x-flight.table />
    <div id="pagination-component" class="flex items-center justify-between px-8"></div>
</x-layout.layout>
<x-flight.create-form />
<x-flight.edit-form />

<script>
    let selectedAirline = null;
    let selectedOrigin = null;
    let selectedDestination = null;

    const populateAirlineDropdown = (airlines, formType) => {
        populateDropdown(`#${formType}-flight-airline-options`, airlines, 'airline', formType)
    }

    const populateOriginDropdown = (cities, formType) => {
        populateDropdown(`#${formType}-flight-origin-options`, cities, 'origin', formType)
    }

    const populateDestinationDropdown = (cities, formType) => {
        populateDropdown(`#${formType}-flight-destination-options`, cities, 'destination', formType)
    }

    const populateDropdown = (optionsDivId, data, entityType, formType) => {
        const optionsDiv = $(optionsDivId);
        optionsDiv.empty();
        data.forEach((item, index) => {
            const option = $(`<button id="${item.id}-${entityType}-${formType}" type="button" class="w-full text-start block px-4 py-2 text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 hover:outline-hidden" role="menuitem" tabindex="-1" id="menu-item-0" onclick="handleSelect(this, '${formType}')">${item.name}</button>`);
            optionsDiv.append(option);
        })
    }

    const toggleOptions = (optionsId) => {
        $(`#${optionsId}-div`).toggleClass('hidden');
    }

    const handleSelect = async (button, formType) => {
        const selectedEntityType = button.id.split('-')[1];
        const selectedEntityId = parseInt(button.id.split('-')[0]);
        const selectedEntityName = button.innerHTML;
        await selectOption(selectedEntityType, selectedEntityId, selectedEntityName, formType)
    }

    const selectOption = async (entityType, entityId, entityName, formType) => {
        $(`#${formType}-${entityType}-hidden-input`).val(entityId);
        setSelectedOption(entityType, entityName, formType);
        $(`#${formType}-flight-${entityType}-options-div`).addClass('hidden');
        if (entityType === 'airline') await selectAirline(entityId, entityName, formType);
        if (entityType === 'origin') await selectOrigin(entityId, entityName, formType);
        if (entityType === 'destination') await selectDestination(entityId, entityName, formType);
    }

    const setSelectedOption = (entityType, selectedValue, formType) => {
        const buttonId = `${formType}-flight-${entityType}-btn`;
        const button = $(`#${buttonId}`);
        const svg = button.find('svg.arrow').clone();
        const div = `<div class="flex w-full justify-between items-center border-r border-gray-300 pr-2">
                <label class="font-medium text-gray-900">${selectedValue}</label>
                <button type="button" onclick="unselectOption('${entityType}', '${buttonId}', '${formType}')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-gray-900">
                        <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                    </svg>
                </button>
            </div>`
        button.empty().append(div).append(svg);
    }

    const selectAirline = async (id, name, formType) => {
        const airlines = await getAllAirlines();
        selectedAirline = airlines.find(airline => airline.id === id);
        const filteredAirlines = airlines.filter(airline => airline.id !== id)
        populateAirlineDropdown(filteredAirlines, formType);
        if (selectedOrigin) {        
            const buttonId = `${formType}-flight-origin-btn`;
            unselectOption('origin', buttonId, formType);
            $(`#${formType}-flight-origin-options-div`).addClass('hidden');
        }

        if (selectedDestination) {
            const buttonId = `${formType}-flight-destination-btn`
            unselectOption('destination', buttonId, formType);
            $(`#${formType}-flight-destination-options-div`).addClass('hidden');
        }
        populateOriginDropdown(selectedAirline.enabledCities, formType);
        populateDestinationDropdown(selectedAirline.enabledCities, formType);
    }

    const selectOrigin = async (id, name, formType) => {
        let cities = selectedAirline?.enabledCities ?? await getAllCities();
        selectedOrigin = id;
        const filteredCities = cities.filter(city => city.id !== id && city.id !== selectedDestination);
        populateOriginDropdown(filteredCities, formType);
        populateDestinationDropdown(filteredCities, formType);
    }

    const selectDestination = async (id, name, formType) => {
        let cities = selectedAirline?.enabledCities ?? await getAllCities();
        selectedDestination = id;
        const filteredCities = cities.filter(city => city.id !== id && city.id !== selectedOrigin);
        populateOriginDropdown(filteredCities, formType);
        populateDestinationDropdown(filteredCities, formType);
    }

    const unselectOption = async (entityType, buttonId, formType) => {
        const button = $(`#${buttonId}`);
        const svg = button.find('svg.arrow').clone();
        $(`#${entityType}-hidden-input`).val('');
        button.empty().text(capitalizeFirstLetter(entityType)).append(svg);
        if (entityType==='airline') await unselectAirline(formType);
        if (entityType==='origin') await unselectOrigin(formType);
        if (entityType==='destination') await unselectDestination(formType);
    }

    const unselectAirline = async (formType) => {
        const cities = await getAllCities();
        selectedAirline = null;
        populateOriginDropdown(cities, formType);
        populateDestinationDropdown(cities, formType);
    }

    const unselectOrigin = async (formType) => {
        const cities = selectedAirline?.enabledCities ?? await getAllCities();
        const filteredCities = cities.filter(city => city.id !== selectedDestination)
        selectedOrigin = null;
        populateOriginDropdown(filteredCities, formType);
        populateDestinationDropdown(filteredCities, formType);
    }

    const unselectDestination = async (formType) => {
        const cities = selectedAirline?.enabledCities ?? await getAllCities();
        const filteredCities = cities.filter(city => city.id !== selectedOrigin)
        selectedDestination = null;
        populateOriginDropdown(filteredCities, formType);
        populateDestinationDropdown(filteredCities, formType);
    }

    const capitalizeFirstLetter = (str) => str.charAt(0).toUpperCase() + str.slice(1);

    const getAllAirlines = async () => {
        const response = await getAirlines(page=null);
        return response.data;
    }

    const getAllCities = async () => {
        const response = await getCities(null, '', '');
        return response.data;
    }

    function formatDate(input) {
        const date = new Date(input); 
        
        const pad = n => n.toString().padStart(2, '0');
        const day = pad(date.getDate());
        const month = pad(date.getMonth() + 1);
        const year = date.getFullYear();
        const hours = pad(date.getHours());
        const minutes = pad(date.getMinutes());
        const seconds = '00';

        return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
    }
</script>
