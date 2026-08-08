<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deactivate any previously seeded services that no longer match
        // the current 6 categories, without deleting history.
        Service::query()->update(['is_active' => false]);

        $categories = [
            [
                'slug' => 'office-admin-corporate-procurement',
                'name' => 'Office, Admin & Corporate Procurement',
                'icon' => 'fa-solid fa-briefcase',
                'short_description' => 'Everyday operational needs for corporate offices.',
                'description' => 'Everyday operational needs for corporate offices — recurring demand, quick turnaround. We source and deliver office supplies, equipment, furniture, and consumables so your workplace never has to wait.',
                'sort_order' => 1,
                'meta_title' => 'Office, Admin & Corporate Procurement',
                'meta_description' => 'Office supplies, equipment, furniture, and consumables procurement for corporate offices.',
                'details' => [
                    'Office Supplies & Stationery',
                    'Office Equipment (Printers, Scanners, Shredders)',
                    'Office Furniture & Workstations',
                    'Office Consumables (Toners, Cleaning Items, Batteries)',
                ],
            ],
            [
                'slug' => 'technology-it-procurement',
                'name' => 'Technology & Digital (IT) Procurement',
                'icon' => 'fa-solid fa-laptop',
                'short_description' => 'Supporting your technology infrastructure needs.',
                'description' => 'Supporting your technology infrastructure needs — from individual workstations to networked office systems, sourced and delivered reliably.',
                'sort_order' => 2,
                'meta_title' => 'Technology & Digital (IT) Procurement',
                'meta_description' => 'Computers, networking equipment, and software license procurement.',
                'details' => [
                    'Computers, Laptops, Monitors & Peripherals',
                    'Networking Equipment & Accessories',
                    'Printers & IT Office Equipment',
                    'Software Licenses & Digital Tools',
                ],
            ],
            [
                'slug' => 'construction-infrastructure-procurement',
                'name' => 'Construction & Infrastructure Procurement',
                'icon' => 'fa-solid fa-hard-hat',
                'short_description' => 'Light to medium construction and infrastructure sourcing, project by project.',
                'description' => 'Light to medium construction and infrastructure sourcing, project by project — materials, supplies, and coordination handled directly.',
                'sort_order' => 3,
                'meta_title' => 'Construction & Infrastructure Procurement',
                'meta_description' => 'Construction materials, electrical & plumbing supplies, and project-based sourcing.',
                'details' => [
                    'Construction Materials (Cement, Tiles, Paints, Roofing)',
                    'Electrical & Plumbing Supplies',
                    'Office Fit-Out & Renovation Materials',
                    'Project-Based Sourcing & Coordination',
                ],
            ],
            [
                'slug' => 'oil-gas-procurement',
                'name' => 'Oil & Gas Procurement & Consumables',
                'icon' => 'fa-solid fa-gas-pump',
                'short_description' => 'Sourcing for oil & gas operations, right-sized to where we are today.',
                'description' => 'Sourcing for oil & gas operations — right-sized to where we are today, growing with every engagement.',
                'sort_order' => 4,
                'meta_title' => 'Oil & Gas Procurement & Consumables',
                'meta_description' => 'Industrial consumables, safety materials, and technical equipment for oil & gas operations.',
                'details' => [
                    'Industrial Consumables & MRO Supplies',
                    'Safety Materials & PPE Supply',
                    'Tools & Technical Equipment',
                    'Facility Support Items',
                ],
            ],
            [
                'slug' => 'maritime-supply',
                'name' => 'Maritime Supply',
                'icon' => 'fa-solid fa-ship',
                'short_description' => 'Vessel supply for marine and offshore operations.',
                'description' => 'Vessel supply for marine and offshore operations — barges, tug boats, crew boats, and service boats.',
                'sort_order' => 5,
                'meta_title' => 'Maritime Supply',
                'meta_description' => 'Vessel supply for marine and offshore operations, including barges, tug boats, and crew boats.',
                'details' => [
                    'Supply of Barges',
                    'Supply of Tug Boats',
                    'Supply of Crew Boats',
                    'Supply of Service Boats',
                ],
            ],
            [
                'slug' => 'site-camp-welfare-supplies',
                'name' => 'Site & Camp Welfare Supplies',
                'icon' => 'fa-solid fa-bed',
                'short_description' => 'Everyday living essentials for men on site or on the rig.',
                'description' => 'Everyday living essentials for men on site or on the rig — so working away from home doesn\'t mean going without.',
                'sort_order' => 6,
                'meta_title' => 'Site & Camp Welfare Supplies',
                'meta_description' => 'Mattresses, bedding, and personal welfare supplies for site and camp accommodation.',
                'details' => [
                    'Mattresses, Pillows & Duvets',
                    'Bedding & Bedroom Essentials',
                    'Personal & Welfare Supplies',
                ],
            ],
        ];

        foreach ($categories as $category) {
            $details = $category['details'];
            unset($category['details']);

            $service = Service::updateOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );

            foreach ($details as $index => $title) {
                ServiceDetail::updateOrCreate(
                    ['service_id' => $service->id, 'title' => $title],
                    ['content' => $title, 'type' => 'feature', 'sort_order' => $index + 1, 'is_active' => true]
                );
            }
        }
    }
}
