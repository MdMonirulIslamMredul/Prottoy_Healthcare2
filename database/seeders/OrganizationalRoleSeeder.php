<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrganizationalRole;

class OrganizationalRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'title' => 'Managing Director',
                'subtitle' => 'Central Management & Oversight',
                'icon' => 'bi-person-badge',
                'level' => 1,
                'color_start' => '#667eea',
                'color_end' => '#764ba2',
                'responsibilities' => [
                    'Overall system administration and management',
                    'Create and manage all hierarchical levels (Divisional Chiefs, District Managers, etc.)',
                    'Monitor and oversee operations across all 8 divisions of Bangladesh',
                    'Generate comprehensive reports and analytics for strategic decision-making',
                    'Set policies, guidelines, and operational standards',
                    'Manage customer records and resolve escalated issues',
                    'Ensure data integrity and system security',
                    'Approve major operational changes and initiatives',
                ],
                'stats' => [
                    '8 Divisions',
                    'All Users',
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Divisional Chief',
                'subtitle' => 'Division-Level Management',
                'icon' => 'bi-diagram-3',
                'level' => 2,
                'color_start' => '#f093fb',
                'color_end' => '#f5576c',
                'responsibilities' => [
                    'Oversee healthcare operations within assigned division',
                    'Manage and coordinate with all District Managers in the division',
                    'Monitor district-level performance and service quality',
                    'Handle customer management for the entire division',
                    'Generate divisional reports and performance metrics',
                    'Ensure compliance with organizational policies and standards',
                    'Resolve inter-district issues and facilitate coordination',
                    'Report division-level insights to Managing Director',
                ],
                'stats' => [
                    '1 Division',
                    'Multiple Districts',
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'District Manager',
                'subtitle' => 'District-Level Operations',
                'icon' => 'bi-geo-alt',
                'level' => 3,
                'color_start' => '#4facfe',
                'color_end' => '#00f2fe',
                'responsibilities' => [
                    'Manage healthcare services within assigned district',
                    'Supervise all Upazila Supervisors in the district',
                    'Monitor upazila-level operations and performance',
                    'Manage customer records and service delivery in the district',
                    'Coordinate with Divisional Chief for resources and support',
                    'Generate district-level reports and analytics',
                    'Ensure quality standards across all upazilas',
                    'Address district-wide challenges and implement solutions',
                ],
                'stats' => [
                    '1 District',
                    'Multiple Upazilas',
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Upazila Supervisor',
                'subtitle' => 'Upazila-Level Coordination',
                'icon' => 'bi-building',
                'level' => 4,
                'color_start' => '#43e97b',
                'color_end' => '#38f9d7',
                'responsibilities' => [
                    'Oversee healthcare operations within assigned upazila',
                    'Manage and support all PHOs (Primary Healthcare Officers) in the upazila',
                    'Monitor PHO performance and customer satisfaction',
                    'Manage upazila-level customer records and services',
                    'Generate upazila reports for District Manager review',
                    'Ensure timely service delivery and quality care',
                    'Coordinate with healthcare providers in the upazila',
                    'Address local challenges and implement best practices',
                ],
                'stats' => [
                    '1 Upazila',
                    'Multiple PHOs',
                ],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'PHO (Primary Healthcare Officer)',
                'subtitle' => 'Frontline Customer Service',
                'icon' => 'bi-person-hearts',
                'level' => 5,
                'color_start' => '#fa709a',
                'color_end' => '#fee140',
                'responsibilities' => [
                    'Provide direct healthcare services and support to customers',
                    'Manage assigned customer portfolio and their healthcare needs',
                    'Process customer registrations and maintain records',
                    'Assist customers with claims and service requests',
                    'Ensure timely response to customer inquiries and issues',
                    'Coordinate with local healthcare providers for service delivery',
                    'Report customer feedback and service gaps to Upazila Supervisor',
                    'Maintain accurate documentation and service logs',
                    'Build strong relationships with customers and community',
                ],
                'stats' => [
                    'Direct Customer Contact',
                    'Frontline Service',
                ],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Customer',
                'subtitle' => 'Service Recipient',
                'icon' => 'bi-person',
                'level' => 6,
                'color_start' => '#667eea',
                'color_end' => '#764ba2',
                'responsibilities' => [
                    'Access healthcare services through designated PHO',
                    'View and manage personal profile and health information',
                    'Submit and track healthcare claims and requests',
                    'Receive notifications about services and updates',
                    'Contact support team for assistance and guidance',
                    'Access healthcare provider network in their area',
                    'View service history and documentation',
                    'Provide feedback to improve service quality',
                ],
                'stats' => [
                    'Service Recipient',
                    'Healthcare Beneficiary',
                ],
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($roles as $roleData) {
            OrganizationalRole::create($roleData);
        }
    }
}
