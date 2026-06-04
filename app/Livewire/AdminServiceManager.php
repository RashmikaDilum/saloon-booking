<?php

namespace App\Livewire;

use App\Enums\ServiceCategory;
use App\Models\Service;
use Livewire\Component;

class AdminServiceManager extends Component
{
    public $services;
    
    // Form State
    public $isEditing = false;
    public $serviceId = null;
    public $name = '';
    public $description = '';
    public $duration_minutes = 30;
    public $price = '';
    public $category = 'hair';
    public $is_active = true;

    public function mount()
    {
        $this->loadServices();
    }

    public function loadServices()
    {
        $this->services = Service::orderBy('category')->orderBy('sort_order')->get();
    }

    public function resetForm()
    {
        $this->isEditing = false;
        $this->serviceId = null;
        $this->name = '';
        $this->description = '';
        $this->duration_minutes = 30;
        $this->price = '';
        $this->category = 'hair';
        $this->is_active = true;
        $this->resetValidation();
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->description = $service->description ?? '';
        $this->duration_minutes = $service->duration_minutes;
        $this->price = $service->price;
        $this->category = $service->category->value;
        $this->is_active = $service->is_active;
        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'is_active' => 'boolean',
        ]);

        if ($this->serviceId) {
            $service = Service::findOrFail($this->serviceId);
            $service->update([
                'name' => $this->name,
                'description' => $this->description,
                'duration_minutes' => $this->duration_minutes,
                'price' => $this->price,
                'category' => $this->category,
                'is_active' => $this->is_active,
            ]);
        } else {
            Service::create([
                'name' => $this->name,
                'description' => $this->description,
                'duration_minutes' => $this->duration_minutes,
                'price' => $this->price,
                'category' => $this->category,
                'is_active' => $this->is_active,
                'sort_order' => 0, // Default sorting
            ]);
        }

        $this->resetForm();
        $this->loadServices();
    }

    public function toggleActive($id)
    {
        $service = Service::findOrFail($id);
        $service->is_active = !$service->is_active;
        $service->save();
        $this->loadServices();
    }

    public function render()
    {
        return view('livewire.admin-service-manager', [
            'categories' => ServiceCategory::cases()
        ]);
    }
}
