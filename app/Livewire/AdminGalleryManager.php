<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AdminGalleryManager extends Component
{
    use WithFileUploads;

    public $photo;
    public $title;

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|max:2048', // 2MB Max
            'title' => 'nullable|string|max:255',
        ]);

        $path = $this->photo->store('gallery', 'public');

        Gallery::create([
            'image_path' => $path,
            'title' => $this->title,
            'is_active' => true,
        ]);

        $this->reset(['photo', 'title']);
    }

    public function delete($id)
    {
        $gallery = Gallery::find($id);
        if ($gallery) {
            if (Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $gallery->delete();
        }
    }

    public function toggleActive($id)
    {
        $gallery = Gallery::find($id);
        if ($gallery) {
            $gallery->is_active = !$gallery->is_active;
            $gallery->save();
        }
    }

    public function render()
    {
        return view('livewire.admin-gallery-manager', [
            'images' => Gallery::latest()->get()
        ]);
    }
}
