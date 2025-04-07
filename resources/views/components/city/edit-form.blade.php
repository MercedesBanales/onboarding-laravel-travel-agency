<x-form modalId="edit-city-modal" :title="'Edit City'" :formId="'edit-city-form'" :formName="'edit-city'">
  @slot('inputs')
    <div class="space-y-12">
      <div class="pb-6">
          <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="col-span-full">
              <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
              <div class="mt-2">
              <input id="edit-city-name" type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
              </div>
          </div>
          <div class="col-span-full">
              <label for="timezone" class="block text-sm/6 font-medium text-gray-900">Timezone</label>
              <div class="mt-2">
              <input id="edit-city-timezone" type="text" name="timezone" id="timezone" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
              </div>
          </div>
          </div>
      </div>
      </div>
  @endslot
</x-form>

<script>
  $(document).ready(function() {
    $.validator.addMethod("validTimezone", function(value, element) {
            return this.optional(element) || /^[A-Za-z]+\/[A-Za-z_]+$/.test(value);
        }, "Please enter a valid timezone (e.g., 'America/New_York')");

        $("form[name='edit-city']").validate({
        errorClass: "text-red-500 text-sm mt-1",
        rules: {
            timezone: {
                validTimezone: true
            }
        },
        messages: {
            timezone: {
                validTimezone: "Please enter a valid timezone (e.g., 'America/New_York')"
            }
        },
        submitHandler: function(form, event) {
          event.preventDefault();
          const formData = new FormData(form);
          formData.append('_method', 'PATCH');

          if (formData.get('name').trim() === '') formData.delete('name');
          if (formData.get('timezone').trim() === '') formData.delete('timezone');
          console.log($(form).attr('method'))

          $.ajax({
              url: $(form).attr('action'),
              type:  $(form).attr('method'),
              data: formData,
              contentType: false, 
              processData: false,
              success: function(response) {
                handleSubmit('City successfully updated');
                $('#edit-city-name').attr('placeholder', response.data.name);
                $('#edit-city-timezone').attr('placeholder', response.data.timezone);
                clearFormFields('#edit-city-form');
              },
              error: function(xhr) {
                  const error = xhr.responseJSON.error;
                  showErrorNotification(error);
                  clearFormFields('#edit-city-form');                  
              }
          });
      }
  
      });
  })
</script>




  