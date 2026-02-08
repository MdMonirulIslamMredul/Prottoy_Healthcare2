<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutContent;

class AboutContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'type' => 'about',
                'title' => 'Who We Are',
                'content' => 'Prottoy Healthcare is a pioneering healthcare management organization dedicated to revolutionizing healthcare accessibility across Bangladesh. Founded in 2020, we have grown from a vision of universal healthcare access to become one of the nation\'s most trusted healthcare management partners, serving over 500,000 members nationwide.

Our comprehensive healthcare management system seamlessly connects patients, healthcare providers, and service facilities through an innovative digital platform. We bridge the gap between quality healthcare services and those who need them most, ensuring that every citizen has access to timely, affordable, and professional medical care.

With a presence spanning all 8 divisions and 64 districts of Bangladesh, Prottoy Healthcare has established the largest healthcare network in the country. Our team of dedicated healthcare professionals, technology experts, and administrative staff work tirelessly to deliver exceptional service and support to our members 24/7.

We believe that healthcare is a fundamental right, not a privilege. This belief drives everything we do - from designing affordable healthcare packages to streamlining claims processing, from building partnerships with top-tier hospitals to implementing cutting-edge health technology solutions. Our commitment is to make quality healthcare accessible, affordable, and hassle-free for every Bangladeshi family.',
                'is_active' => true,
            ],
            [
                'type' => 'mission',
                'title' => 'Our Mission',
                'content' => 'To provide accessible, affordable, and quality healthcare services to every citizen of Bangladesh. We strive to create a comprehensive healthcare ecosystem that ensures timely medical assistance, seamless claims processing, and continuous support for all our members. Our mission is to bridge the gap between healthcare providers and patients, making quality healthcare a reality for everyone, regardless of their geographic location or economic status.',
                'is_active' => true,
            ],
            [
                'type' => 'vision',
                'title' => 'Our Vision',
                'content' => 'To become the most trusted and preferred healthcare management organization in Bangladesh by 2030. We envision a future where every individual has access to world-class healthcare services regardless of their location or economic status. Through innovation, technology, and unwavering commitment, we aim to set new standards in healthcare delivery and customer satisfaction across the nation, ultimately contributing to a healthier and more prosperous Bangladesh.',
                'is_active' => true,
            ],
        ];

        foreach ($contents as $contentData) {
            AboutContent::create($contentData);
        }
    }
}
