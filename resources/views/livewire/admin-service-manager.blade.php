<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Services List -->
    <div class="lg:col-span-2">
        <h3 class="font-serif text-2xl text-charcoal-900 mb-6 border-b border-cream-200 pb-2">Service Catalog</h3>
        
        <div class="bg-cream-100 border border-cream-200 shadow-sm overflow-x-auto">
            <table class="w-full text-left text-sm text-charcoal-900">
                <thead class="bg-cream-50 text-xs tracking-widest uppercase text-charcoal-700 border-b border-cream-200">
                    <tr>
                        <th class="px-6 py-4 font-medium">Service Name</th>
                        <th class="px-6 py-4 font-medium">Category</th>
                        <th class="px-6 py-4 font-medium">Price/Time</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-200">
                    @foreach($services as $service)
                        <tr class="hover:bg-cream-50 transition-colors {{ !$service->is_active ? 'opacity-50' : '' }}">
                            <td class="px-6 py-4 font-serif text-lg">
                                {{ $service->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ ucfirst($service->category->value) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="block">LKR {{ number_format($service->price, 2) }}</span>
                                <span class="text-xs text-charcoal-700">{{ $service->duration_minutes }} min</span>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleActive({{ $service->id }})" class="text-xs tracking-wider uppercase font-medium rounded-full px-2 py-1 {{ $service->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    {{ $service->is_active ? 'Active' : 'Disabled' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="edit({{ $service->id }})" class="text-charcoal-700 hover:text-charcoal-900 uppercase tracking-widest text-xs font-medium underline underline-offset-2">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Form -->
    <div>
        <div class="bg-cream-100 border border-cream-200 p-6 shadow-sm sticky top-6">
            <h3 class="font-serif text-xl text-charcoal-900 mb-6 border-b border-cream-200 pb-2">
                {{ $isEditing ? 'Edit Service' : 'Add New Service' }}
            </h3>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-xs uppercase tracking-widest text-charcoal-700 mb-1">Name</label>
                    <input type="text" wire:model="name" class="w-full border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-50" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-widest text-charcoal-700 mb-1">Category</label>
                    <select wire:model="category" class="w-full border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-50" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->value }}">{{ $cat->label() }}</option>
                        @endforeach
                    </select>
                    @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-charcoal-700 mb-1">Price (LKR)</label>
                        <input type="number" step="0.01" wire:model="price" class="w-full border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-50" required>
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-charcoal-700 mb-1">Duration (Min)</label>
                        <input type="number" step="15" wire:model="duration_minutes" class="w-full border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-50" required>
                        @error('duration_minutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase tracking-widest text-charcoal-700 mb-1">Description (Optional)</label>
                    <textarea wire:model="description" rows="3" class="w-full border-cream-200 focus:border-charcoal-900 focus:ring-0 p-2 text-sm bg-cream-50"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_active" id="is_active" class="border-cream-200 text-charcoal-900 focus:ring-charcoal-900">
                    <label for="is_active" class="ml-2 text-sm text-charcoal-700">Service is active and visible</label>
                </div>

                <div class="pt-4 flex space-x-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-charcoal-900 text-cream-50 hover:bg-charcoal-800 text-xs tracking-widest uppercase transition-colors">
                        {{ $isEditing ? 'Update Service' : 'Save Service' }}
                    </button>
                    @if($isEditing)
                        <button type="button" wire:click="resetForm" class="px-4 py-2 border border-charcoal-900 text-charcoal-900 hover:bg-cream-100 text-xs tracking-widest uppercase transition-colors">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>
