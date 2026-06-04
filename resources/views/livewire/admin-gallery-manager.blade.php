<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900">Gallery Management</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Upload images to display on the public gallery page.
                </p>
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <!-- Upload Form -->
                    <form wire:submit="save">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Photo</label>
                                <input type="file" wire:model="photo" class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-charcoal-50 file:text-charcoal-700
                                  hover:file:bg-charcoal-100">
                                @error('photo') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label class="block text-sm font-medium text-gray-700">Title (Optional)</label>
                                <input type="text" wire:model="title" class="mt-1 focus:ring-charcoal-500 focus:border-charcoal-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('title') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-charcoal-900 hover:bg-charcoal-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-charcoal-500">
                                Upload Photo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Current Gallery Images</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($images as $image)
            <div class="bg-white shadow rounded-lg overflow-hidden flex flex-col">
                <div class="h-48 bg-gray-200 w-full relative">
                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->title }}" class="w-full h-full object-cover">
                    @if(!$image->is_active)
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <span class="text-white font-bold bg-red-600 px-2 py-1 rounded">Hidden</span>
                        </div>
                    @endif
                </div>
                <div class="p-4 flex-grow flex flex-col justify-between">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $image->title ?: 'Untitled' }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <button wire:click="toggleActive({{ $image->id }})" class="text-sm text-blue-600 hover:text-blue-900">
                            {{ $image->is_active ? 'Hide' : 'Show' }}
                        </button>
                        <button wire:click="delete({{ $image->id }})" class="text-sm text-red-600 hover:text-red-900">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
