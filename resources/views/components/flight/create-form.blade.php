<x-form modalId="create-flight-modal" :title="'Create Flight'" :formId="'create-flight-form'" :formName="'create-flight'" :action="'/api/flights'">
    @slot('inputs')
        <div class="grid grid-flow grid-rows-3 grid-cols-2 gap-8">
            <div class="col-span-full">
                <x-dropdown :optionsId="'create-flight-airline-options'" :buttonId="'create-flight-airline-btn'" :label="'Airline'" />
                <input type="hidden" name="airline_id" id="create-airline-hidden-input">
            </div>

            <div>
                <x-dropdown :optionsId="'create-flight-origin-options'" :buttonId="'create-flight-origin-btn'" :label="'Origin'" />
                <input type="hidden" name="departure_city_id" id="create-origin-hidden-input">
            </div>

            <div>
                <x-dropdown :optionsId="'create-flight-destination-options'" :buttonId="'create-flight-destination-btn'" :label="'Destination'" />
                <input type="hidden" name="arrival_city_id" id="create-destination-hidden-input">
            </div>
            <div class="relative">
                <input
                    name="departure_date"
                    type="datetime-local"
                    id="create-departure-date"
                    class="w-full px-3 py-2 !text-sm font-normal text-gray-400 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                <span class="absolute -top-2 left-2 px-1 bg-white text-xs text-gray-400">
                    Departure Date
                </span>
            </div>
            <div class="relative">
                <input
                    name="arrival_date"
                    type="datetime-local"
                    id="create-arrival-date"
                    class="w-full px-3 py-2 !text-sm font-normal text-gray-400 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                <span class="absolute -top-2 left-2 px-1 bg-white text-xs text-gray-400">
                    Arrival Date
                </span>
            </div>
        </div>
    @endslot
</x-form>

<script>
    const updateInputState = (input) => {
    if ($(input).val()) {
        $(input).addClass('text-gray-900 font-medium').removeClass('text-gray-400 font-normal');
    } else {
        $(input).addClass('text-gray-400 font-normal').removeClass('text-gray-900 font-medium');
    }
}

$(document).ready(async function() {
    selectedAirline = null;
    selectedOrigin = null;
    selectedDestination = null;
    const airlines = await getAllAirlines();
    populateAirlineDropdown(airlines, 'create');
    const cities = await getAllCities();
    populateOriginDropdown(cities, 'create');
    populateDestinationDropdown(cities, 'create');

    $('#create-departure-date, #create-arrival-date').on('change input focus blur keyup', function() {
        updateInputState(this);
    });

    $.validator.setDefaults({
        ignore: []
    });

    $("form[name='create-flight']").validate({
        errorClass: "text-red-500 text-sm mt-1",
        rules: {
            airline_id: "required",
            departure_city_id: "required",
            arrival_city_id: "required",
            departure_date: "required",
            arrival_date: "required"
        },
        messages: {
            airline_id: "Please choose an airline",
            departure_city_id: "Please choose an origin",
            arrival_city_id: "Please choose a destination",
            departure_date: "Please choose a departure date",
            arrival_date: "Please choose an arrival date",
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
                    airline_id: parseInt(formData.get('airline_id')),
                    departure_city_id: parseInt(formData.get('departure_city_id')),
                    arrival_city_id: parseInt(formData.get('arrival_city_id')),
                    departure_date: formatDate(formData.get('departure_date')),
                    arrival_date: formatDate(formData.get('arrival_date'))
                })
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(err => { throw err }); 
                }
                return res.json();
            })
            .then(data => {
                handleCreateFlight(); 
            })
            .catch(res => { 
                showErrorNotification(res.error);
            });
        }
        });
});

const handleCreateFlight = () => {
    loadFlights();
    resetFields('create');
    closeForm('create-flight-modal');
    showSuccessNotification('Flight successfully created.');
}

const resetFields = (formType) => {
    selectedAirline = null;
    selectedOrigin = null;
    selectedDestination = null;
    unselectOption('airline', 'create-flight-airline-btn', formType);
    unselectOption('origin', 'create-flight-origin-btn', formType);
    unselectOption('destination', 'create-flight-destination-btn', formType);
    $(`#${formType}-departure-date`).val('');
    $(`#${formType}-arrival-date`).val('');
}
</script>

