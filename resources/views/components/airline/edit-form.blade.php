<x-form modalId="edit-airline-modal" :title="'Edit Airline'" :formId="'edit-airline-form'" :formName="'edit-airline'">
    @slot('inputs')
        <div class="flex flex-col justify-start gap-6">
            <div class="flex flex-col w-full">
                <label for="name" class="text-sm/6 font-medium text-gray-900">Name</label>
                <div class="mt-2">
                    <input id="edit-airline-name" type="text" name="name" id="name" autocomplete="name" class="w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                </div>
            </div>
            <div class="flex flex-col w-full">
                <label for="description" class="text-sm/6 font-medium text-gray-900">Description</label>
                <div class="mt-2">
                    <textarea id="edit-airline-description" rows="4" name="description" id="description" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                </div>
            </div> 
            <div class="flex flex-col">
                <div id="enabled-cities-div-edit" class="flex items-center gap-4 w-full">
                    <label class="text-sm/6 font-medium text-gray-900">Enabled cities:</label>
                    <div class="relative inline-block group">
                        <button type="button" class="inline-flex w-full justify-between gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true" onclick="toggleCityOptions('#enabled-cities-options-edit')">
                            Choose
                            <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="enabled-cities-options-edit" class="absolute z-20 left-0 mt-2 p-4 w-56 h-30 origin-top-right divide-y divide-gray-100 rounded-md bg-white ring-1 shadow-lg ring-black/5 hidden overflow-y-auto focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div id="options-body-edit" class="space-y-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endslot
  </x-form>

  <script>
    $(document).ready(function() {
    $("form[name='edit-airline']").validate({
        highlight: function(element) {
        $(element).closest('.group').removeClass('has-success').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.group').addClass('has-success').removeClass('has-error');
    },
    errorClass: "text-red-500 text-sm mt-1",
    rules: {
        "enabled_cities_ids[]": "required"
    },
    messages: {
        "enabled_cities_ids[]": "At least one city must be selected"
    },
    errorPlacement: function(error, element) {
        if (element.attr("name") === "enabled_cities_ids[]") {
            error.insertAfter("#enabled-cities-div-edit"); 
        } else {
            error.insertAfter(element); 
        }
    },
    submitHandler: function(form, event) {
        event.preventDefault()
        const formData = new FormData(form);

        if (formData.get('name').trim() === '') formData.delete('name');
        if (formData.get('description').trim() === '') formData.delete('description');
        
        fetch($(form).attr('action'), {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'PATCH',
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
        .then(res => {
            handleSuccess(res.data.name, res.data.description); 
        })
        .catch(res => { 
            showErrorNotification(res.error);
        });
    }
    });
})

const handleSuccess = (name, description) => {
    loadAirlines();
    $('#edit-airline-name').attr('placeholder', name);
    $('#edit-airline-description').attr('placeholder', description);
    clearEditFields();
    showSuccessNotification('Airline successfully updated.')
}

const clearEditFields = () => {
    const form = $('#edit-airline-form');
    $('#edit-airline-name').val('');
    form.find('textarea').val('');
    $('#enabled-cities-options-edit').addClass('hidden');
}
</script>





  