<x-form modalId="create-airline-modal" :title="'Create Airline'" :formId="'create-airline-form'" :formName="'create-airline'" :action="'/api/airlines'">
    @slot('inputs')
        <div class="flex flex-col justify-start gap-6">
            <div class="flex flex-col w-full">
                <label for="name" class="text-sm/6 font-medium text-gray-900">Name</label>
                <div class="mt-2">
                    <input id="create-airline-name" type="text" name="name" id="name" autocomplete="name" class="w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                </div>
            </div>
            <div class="flex flex-col w-full">
                <label for="description" class="text-sm/6 font-medium text-gray-900">Description</label>
                <div class="mt-2">
                    <textarea id="create-airline-description" rows="4" name="description" id="description" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                </div>
            </div>
            <div class="flex flex-col">
                <div id="enabled-cities-div-create" class="flex items-center gap-4 w-full">
                    <label class="text-sm/6 font-medium text-gray-900">Enabled cities:</label>
                    <div class="relative inline-block group">
                        <button type="button" class="inline-flex w-full justify-between gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true" onclick="toggleCityOptions('#enabled-cities-options-create')">
                            Choose
                            <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="enabled-cities-options-create" class="absolute z-30 left-0 mt-2 p-4 w-56 h-30 origin-top-right divide-y divide-gray-100 rounded-md bg-white ring-1 shadow-lg ring-black/5 hidden overflow-y-auto focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div id="options-body-create" class="space-y-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endslot
  </x-form>

  <script>
    const toggleCityOptions = (optionsId) => {
    $(optionsId).toggleClass('hidden');
}

const setOption = (city, cityIsEnabled) => {
    return `<div class="flex gap-3">
                <div class="flex h-5 shrink-0 items-center">
                    <div class="group grid size-4 grid-cols-1">
                        <input name="enabled_cities_ids[]" value="${city.id}" type="checkbox" 
                            class="city-checkbox col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                            ${cityIsEnabled ? "checked" : ""}>
                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25" viewBox="0 0 14 14" fill="none">
                            <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <label for="enabled_cities_ids[]" class="text-sm text-gray-500">${city.name}</label>
            </div>`;
}

const loadOptions = async (optionsBodyId, enabledCities=null) => {
    const response = await getCities(null, '', '');
    let options = '';
    response.data.forEach(city => {
        const cityIsEnabled = enabledCities && enabledCities.some(c => c.id === city.id);
        options += setOption(city, cityIsEnabled);
    });
    
    $(optionsBodyId).html(options); 
}

const handleCreate = () => {
    loadAirlines();
    clearFields();
    closeForm('create-airline-modal');
    showSuccessNotification('Airline successfully created.')
}

const clearFields = () => {
    const form = $('#create-airline-form');
    form.find('input').val('');
    form.find('textarea').val('');
    $('#enabled-cities-options').find('input[type="checkbox"]').prop('checked', false);
    $('#enabled-cities-options').addClass('hidden');
}

$(document).ready(async function() {
    await loadOptions('#options-body-create');

    $.validator.setDefaults({
        ignore: []
    });

    $("form[name='create-airline']").validate({
        highlight: function(element) {
            $(element).closest('.group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.group').addClass('has-success').removeClass('has-error');
        },
        errorClass: "text-red-500 text-sm mt-1",
        rules: {
            name: "required",
            description: "required",
            "enabled_cities_ids[]": "required"
        },
        messages: {
            name: "Please enter the airline's name",
            description: "Please enter the airline's description",
            "enabled_cities_ids[]": "Please select at least one city"
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") === "enabled_cities_ids[]") {
                error.insertAfter("#enabled-cities-div"); 
            } else {
                error.insertAfter(element); 
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            const formData = new FormData(form);
            
            fetch($(form).attr('action'), {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: $(form).attr('method'),
                body: JSON.stringify({
                    name: formData.get('name'),
                    description: formData.get('description'),
                    enabled_cities_ids: formData.getAll('enabled_cities_ids[]')
                })
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err }); 
                }
                return res.json();
            })
            .then(data => {
                handleCreate(); 
            })
            .catch(res => { 
                showErrorNotification(res.error);
            });
        }
        });
})
</script>

  




  