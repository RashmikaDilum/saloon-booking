<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\ServiceCategory;
use App\Models\Availability;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::create([
            'name' => 'Admin Owner',
            'email' => 'admin@saheli.com',
            'password' => Hash::make('password'),
            'role' => UserRole::ADMIN,
            'phone' => '+1 (555) 123-4567',
        ]);

        // 2. Create Stylists
        $elena = User::create([
            'name' => 'Elena Rostova',
            'email' => 'elena@saheli.com',
            'password' => Hash::make('password'),
            'role' => UserRole::STYLIST,
            'phone' => '+1 (555) 234-5678',
            'bio' => 'Elena is an editorial hair stylist with over a decade of experience in modern cuts, effortless blowouts, and soft-wave styling.',
        ]);

        $amina = User::create([
            'name' => 'Amina Vance',
            'email' => 'amina@saheli.com',
            'password' => Hash::make('password'),
            'role' => UserRole::STYLIST,
            'phone' => '+1 (555) 345-6789',
            'bio' => 'Specializing in clean clinical skincare and modern minimalist nail art, Amina believes beauty routines should be both luxurious and therapeutic.',
        ]);

        // 3. Create Client
        $client = User::create([
            'name' => 'Sarah Connor',
            'email' => 'sarah@client.com',
            'password' => Hash::make('password'),
            'role' => UserRole::CLIENT,
            'phone' => '+1 (555) 987-6543',
        ]);

        // 4. Create Services
        $cut = Service::create([
            'name' => 'Signature Cut & Style',
            'slug' => 'signature-cut-style',
            'description' => 'A bespoke haircut tailored to your hair texture, face shape, and personal aesthetic. Includes a relaxing botanical shampoo and signature blowout.',
            'category' => ServiceCategory::HAIR,
            'duration_minutes' => 60,
            'price' => 85.00,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $blowout = Service::create([
            'name' => 'Gloss & Blowout',
            'slug' => 'gloss-blowout',
            'description' => 'Our signature styling service. A luxurious wash followed by a custom blowout, complete with a high-shine clear gloss finish.',
            'category' => ServiceCategory::HAIR,
            'duration_minutes' => 45,
            'price' => 55.00,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $manicure = Service::create([
            'name' => 'Minimalist Gel Manicure',
            'slug' => 'gel-manicure',
            'description' => 'Clean, dry manicure cuticle care followed by a premium builder gel overlay. Perfect for strong, beautiful, natural-looking nails.',
            'category' => ServiceCategory::NAILS,
            'duration_minutes' => 45,
            'price' => 45.00,
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $facial = Service::create([
            'name' => 'Editorial Glow Facial',
            'slug' => 'editorial-glow-facial',
            'description' => 'A targeted clinical facial utilizing dual-exfoliation and deep hydration to leave your skin visibly sculpted, plump, and glowing.',
            'category' => ServiceCategory::SKIN,
            'duration_minutes' => 75,
            'price' => 120.00,
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $brows = Service::create([
            'name' => 'Brow Lamination & Tint',
            'slug' => 'brow-lamination-tint',
            'description' => 'Re-shape and set your brows into a full, fluffy, perfectly groomed style. Includes mapping, precise tinting, and shaping.',
            'category' => ServiceCategory::BROWS,
            'duration_minutes' => 30,
            'price' => 65.00,
            'is_active' => true,
            'sort_order' => 5,
        ]);

        // 5. Associate Services with Stylists
        // Elena: Hair and Brows
        $elena->services()->attach([$cut->id, $blowout->id, $brows->id]);

        // Amina: Nails and Skin
        $amina->services()->attach([$manicure->id, $facial->id]);

        // 6. Seed Stylist Availabilities
        // Monday (1) to Friday (5), 9:00 AM to 5:00 PM
        $stylists = [$elena, $amina];
        foreach ($stylists as $stylist) {
            for ($day = 1; $day <= 5; $day++) {
                Availability::create([
                    'stylist_id' => $stylist->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'is_active' => true,
                ]);
            }
        }
    }
}
