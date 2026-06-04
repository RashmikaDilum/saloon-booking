<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <!-- Add New Stylist Form -->
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900">Add New Stylist</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Create an account for a new stylist.
                </p>
            </div>
            
            <form wire:submit="save" class="mt-5">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6 space-y-4">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="name" class="mt-1 focus:ring-charcoal-500 focus:border-charcoal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('name') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model="email" class="mt-1 focus:ring-charcoal-500 focus:border-charcoal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('email') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" wire:model="phone" class="mt-1 focus:ring-charcoal-500 focus:border-charcoal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('phone') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea wire:model="bio" rows="3" class="mt-1 focus:ring-charcoal-500 focus:border-charcoal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            @error('bio') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Initial Password</label>
                            <input type="password" wire:model="password" class="mt-1 focus:ring-charcoal-500 focus:border-charcoal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('password') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Services</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-200 rounded-md p-3 bg-gray-50">
                                @foreach($services as $service)
                                    <div class="flex items-center">
                                        <input type="checkbox" wire:model="selectedServices" value="{{ $service->id }}" id="service_{{ $service->id }}" class="focus:ring-charcoal-500 h-4 w-4 text-charcoal-600 border-gray-300 rounded">
                                        <label for="service_{{ $service->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                                            {{ $service->name }} <span class="text-xs text-gray-500">({{ ucfirst($service->category->value) }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedServices') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-charcoal-900 hover:bg-charcoal-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-charcoal-500">
                            Create Stylist
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Stylists List -->
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Current Stylists</h3>
                    
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Contact
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($stylists as $stylist)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $stylist->name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $stylist->email }}</div>
                                                        <div class="text-sm text-gray-500">{{ $stylist->phone }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <button wire:click="delete({{ $stylist->id }})" wire:confirm="Are you sure you want to remove this stylist?" class="text-red-600 hover:text-red-900">
                                                            Remove
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500 text-sm">
                                                        No stylists found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
