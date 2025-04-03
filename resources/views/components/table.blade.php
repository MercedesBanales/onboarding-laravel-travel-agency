@props(['bodyId'])
<div {{ $attributes->merge(['class' => "px-4 sm:px-6 lg:px-8"])}}>
    <div class="flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden ring-1 shadow-sm ring-black/5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                    <div class="flex">
                      ID
                      {{ $sortById }}
                  </div>
                  </th>
                  {{ $remainingColumns }}
                  <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th>
                  <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                    <span class="sr-only">Delete</span>
                  </th>
                </tr>
              </thead>
              <tbody id="{{ $bodyId }}" class="divide-y divide-gray-200 bg-white"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>