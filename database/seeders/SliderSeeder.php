<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Welcome to Prottoy Healthcare',
                'subtitle' => 'Your trusted partner in comprehensive healthcare management across Bangladesh',
                'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1920',
                'button_text' => 'Learn More',
                'button_link' => '/about',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Quality Healthcare for Everyone',
                'subtitle' => 'Providing affordable and accessible healthcare services to communities nationwide',
                'image' => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=1920',
                'button_text' => 'Access Portal',
                'button_link' => '/login',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => '24/7 Healthcare Support',
                'subtitle' => 'Round-the-clock medical assistance and support whenever you need it',
                'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=1920',
                'button_text' => 'Get Support',
                'button_link' => '/customer-service',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
