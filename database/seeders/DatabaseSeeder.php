<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Créer des utilisateurs patients
        User::factory(10)->state(['role' => 'patient'])->create();

        // Créer 3 médecins
        User::factory(3)->doctor()->create();

        // Services médicaux
        $services = [
            ['name' => 'Consultation Générale', 'description' => 'Consultation généraliste', 'price' => 50.00],
            ['name' => 'Bilan Complet', 'description' => 'Bilan médical complet', 'price' => 120.00],
            ['name' => 'Radiographie', 'description' => 'Radiographie X', 'price' => 75.00],
            ['name' => 'Analyse Sang', 'description' => 'Prise de sang et analyse', 'price' => 40.00],
            ['name' => 'Vaccination', 'description' => 'Service de vaccination', 'price' => 30.00],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $patients = User::where('role', 'patient')->get();
        $doctors = User::where('role', 'doctor')->get();
        $serviceIds = Service::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            Appointment::create([
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'service_id' => $serviceIds[array_rand($serviceIds)],
                'appointment_date' => now()->addDays(rand(1, 30)),
                'status' => ['pending', 'confirmed', 'cancelled'][array_rand(['pending', 'confirmed', 'cancelled'])],
                'notes' => rand(0, 1) ? 'Notes importantes du rendez-vous' : null,
            ]);
        }
    }
}
