@props(['modalId', 'title', 'formId', 'formName', 'action'=>null])
<div id={{ $modalId }} class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
  
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
            <div class="flex flex-col gap-8">
            <h2 class="text-3xl font-semibold">{{ $title }}</h2>
            <form id="{{ $formId }}" name="{{ $formName }}" class="bg-white" action="{{ $action }}" method="POST">
                @csrf
                {{ $inputs }}
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="button" class="text-sm/6 font-semibold text-gray-900" onclick="closeForm('{{ $modalId }}')">Cancel</button>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>
        </div>
         </div>
        </div>
      </div>
    </div>
  </div>