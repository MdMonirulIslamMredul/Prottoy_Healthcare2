<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Customer Service',
                'description' => 'Dedicated support for all your healthcare queries. Our experienced team is available to assist you with any questions or concerns about your healthcare needs.',
                'icon' => 'bi bi-headset',
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=500',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Claims Processing',
                'description' => 'Fast and efficient claim approval process. We ensure your claims are processed quickly with minimal paperwork and maximum transparency.',
                'icon' => 'bi bi-file-earmark-check',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Healthcare Network',
                'description' => 'Extensive network of trusted healthcare providers. Access quality medical services across Bangladesh with our partner hospitals and clinics.',
                'icon' => 'bi bi-hospital',
                'image' => 'https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?w=500',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
