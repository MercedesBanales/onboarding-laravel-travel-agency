<x-form modalId="edit-flight-modal" :title="'Edit Flight'" :formId="'edit-flight-form'" :formName="'Edit-flight'">
    @slot('inputs')
        <div class="grid grid-flow grid-rows-3 grid-cols-2 gap-8">
            <div class="col-span-full">
                <x-dropdown :optionsId="'edit-flight-airline-options'" :buttonId="'edit-flight-airline-btn'" :label="'Airline'" />
                <input type="hidden" name="airline_id" id="edit-airline-hidden-input">
            </div>

            <div>
                <x-dropdown :optionsId="'edit-flight-origin-options'" :buttonId="'edit-flight-origin-btn'" :label="'Origin'" />
                <input type="hidden" name="departure_city_id" id="edit-origin-hidden-input">
            </div>

            <div>
                <x-dropdown :optionsId="'edit-flight-destination-options'" :buttonId="'edit-flight-destination-btn'" :label="'Destination'" />
                <input type="hidden" name="arrival_city_id" id="edit-destination-hidden-input">
            </div>
            <div class="relative">
                <input
                    name="departure_date"
                    type="datetime-local"
                    id="edit-departure-date"
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
                    id="edit-arrival-date"
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
    $(document).ready(async function() {
        const airlines = await getAllAirlines();
        populateAirlineDropdown(airlines, 'edit');
        const cities = await getAllCities();
        populateOriginDropdown(cities, 'edit');
        populateDestinationDropdown(cities, 'edit');

        $('#departure-date, #arrival-date').on('change input focus blur keyup', function() {
            updateInputState(this);
        });

        $.validator.setDefaults({
            ignore: []
        });

        $("form[name='Edit-flight']").validate({
            errorClass: "text-red-500 text-sm mt-1",
            submitHandler: function(form, event) {
                event.preventDefault()
                const formData = new FormData(form);
                
                fetch($(form).attr('action'), {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: 'PATCH',
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
                    handleEditFlight(); 
                })
                .catch(res => { 
                    showErrorNotification(res.error);
                });
            }
            });
});

const handleEditFlight = () => {
    loadFlights();
    showSuccessNotification('Flight successfully edited.')
}

</script>