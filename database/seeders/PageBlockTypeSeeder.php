<?php

namespace Database\Seeders;

use App\Models\PageBlockType;
use Illuminate\Database\Seeder;

class PageBlockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blockTypes = [
            [
                'name' => 'Hero Section 1',
                'slug' => 'hero_section_1',
                'component_name' => 'hero_section_1',
                'category' => 'hero',
                'description' => 'Full-width hero section with image and CTA button',
                'schema' => [
                    'heading' => ['type' => 'text', 'required' => true],
                    'subheading' => ['type' => 'text', 'required' => false],
                    'description' => ['type' => 'textarea', 'required' => false],
                    'image' => ['type' => 'image', 'required' => false],
                    'cta_text' => ['type' => 'text', 'required' => false],
                    'cta_link' => ['type' => 'text', 'required' => false],
                ],
                'default_data' => [
                    'heading' => 'Professional Procurement Services',
                    'subheading' => 'Your Trusted Partner',
                    'description' => 'We deliver excellence in procurement solutions.',
                    'cta_text' => 'Get Started',
                    'cta_link' => '#contact',
                ],
            ],
            [
                'name' => 'Hero Section 2',
                'slug' => 'hero_section_2',
                'component_name' => 'hero_section_2',
                'category' => 'hero',
                'description' => 'Split hero with content left and image right',
                'schema' => [
                    'heading' => ['type' => 'text', 'required' => true],
                    'subheading' => ['type' => 'text', 'required' => false],
                    'description' => ['type' => 'textarea', 'required' => false],
                    'image' => ['type' => 'image', 'required' => true],
                    'cta_text' => ['type' => 'text', 'required' => false],
                    'cta_link' => ['type' => 'text', 'required' => false],
                ],
                'default_data' => [
                    'heading' => 'Quality You Can Trust',
                    'description' => 'Industry-leading procurement solutions.',
                    'cta_text' => 'Learn More',
                ],
            ],
            [
                'name' => 'Hero Section 3',
                'slug' => 'hero_section_3',
                'component_name' => 'hero_section_3',
                'category' => 'hero',
                'description' => 'Hero section with video background',
                'schema' => [
                    'heading' => ['type' => 'text', 'required' => true],
                    'subheading' => ['type' => 'text', 'required' => false],
                    'video_url' => ['type' => 'text', 'required' => true],
                    'cta_text' => ['type' => 'text', 'required' => false],
                    'cta_link' => ['type' => 'text', 'required' => false],
                ],
                'default_data' => [
                    'heading' => 'Excellence in Every Detail',
                    'video_url' => '',
                ],
            ],
            [
                'name' => 'Card Grid - 2 Columns',
                'slug' => 'card_grid_2col',
                'component_name' => 'card_grid_2col',
                'category' => 'card',
                'description' => 'Two-column card layout with images and icons',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'section_subtitle' => ['type' => 'text', 'required' => false],
                    'cards' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'image' => ['type' => 'image', 'hint' => 'Card cover image'],
                        'icon' => ['type' => 'icon', 'hint' => 'Icon displayed on the card'],
                        'title' => ['type' => 'text'],
                        'description' => ['type' => 'textarea'],
                        'link' => ['type' => 'text', 'hint' => 'URL for the card link'],
                        'link_text' => ['type' => 'text', 'hint' => 'Button text (e.g. Learn More)'],
                    ]],
                ],
                'default_data' => [
                    'section_title' => 'Our Services',
                    'cards' => [],
                ],
            ],
            [
                'name' => 'Card Grid - 3 Columns',
                'slug' => 'card_grid_3col',
                'component_name' => 'card_grid_3col',
                'category' => 'card',
                'description' => 'Three-column card layout (ideal for services)',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'section_subtitle' => ['type' => 'text', 'required' => false],
                    'cards' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'image' => ['type' => 'image', 'hint' => 'Card cover image'],
                        'icon' => ['type' => 'icon', 'hint' => 'Icon displayed on the card'],
                        'title' => ['type' => 'text'],
                        'description' => ['type' => 'textarea'],
                        'link' => ['type' => 'text', 'hint' => 'URL for the card link'],
                        'link_text' => ['type' => 'text', 'hint' => 'Button text (e.g. View Details)'],
                    ]],
                ],
                'default_data' => [
                    'section_title' => 'What We Offer',
                    'cards' => [],
                ],
            ],
            [
                'name' => 'Card Grid - 4 Columns',
                'slug' => 'card_grid_4col',
                'component_name' => 'card_grid_4col',
                'category' => 'card',
                'description' => 'Four-column card grid',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'section_subtitle' => ['type' => 'text', 'required' => false],
                    'cards' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'image' => ['type' => 'image', 'hint' => 'Card cover image'],
                        'icon' => ['type' => 'icon', 'hint' => 'Icon displayed on the card'],
                        'title' => ['type' => 'text'],
                        'description' => ['type' => 'textarea'],
                        'link' => ['type' => 'text', 'hint' => 'URL for the card link'],
                        'link_text' => ['type' => 'text', 'hint' => 'Button text (e.g. Read More)'],
                    ]],
                ],
                'default_data' => [
                    'cards' => [],
                ],
            ],
            [
                'name' => 'About Section',
                'slug' => 'about_section',
                'component_name' => 'about_section',
                'category' => 'content',
                'description' => 'Image and content section',
                'schema' => [
                    'heading' => ['type' => 'text', 'required' => true],
                    'subheading' => ['type' => 'text', 'required' => false],
                    'description' => ['type' => 'textarea', 'required' => true],
                    'image' => ['type' => 'image', 'required' => true],
                    'image_position' => ['type' => 'select', 'options' => ['left', 'right'], 'default' => 'right'],
                    'features' => ['type' => 'repeater', 'required' => false, 'fields' => [
                        'icon' => ['type' => 'image'],
                        'text' => ['type' => 'text'],
                    ]],
                ],
                'default_data' => [
                    'heading' => 'About Our Company',
                    'description' => 'We are committed to excellence.',
                    'image_position' => 'right',
                ],
            ],
            [
                'name' => 'Stats Counter',
                'slug' => 'stats_counter',
                'component_name' => 'stats_counter',
                'category' => 'stats',
                'description' => 'Statistics/numbers section with counters',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'stats' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'number' => ['type' => 'text'],
                        'label' => ['type' => 'text'],
                        'icon' => ['type' => 'image'],
                    ]],
                ],
                'default_data' => [
                    'stats' => [],
                ],
            ],
            [
                'name' => 'Testimonial Slider',
                'slug' => 'testimonial_slider',
                'component_name' => 'testimonial_slider',
                'category' => 'testimonial',
                'description' => 'Testimonial carousel/slider',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'section_subtitle' => ['type' => 'text', 'required' => false],
                    'testimonials' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'client_name' => ['type' => 'text'],
                        'client_position' => ['type' => 'text'],
                        'client_image' => ['type' => 'image'],
                        'testimonial' => ['type' => 'textarea'],
                        'rating' => ['type' => 'number'],
                    ]],
                ],
                'default_data' => [
                    'section_title' => 'Client Testimonials',
                    'testimonials' => [],
                ],
            ],
            [
                'name' => 'Testimonial Grid',
                'slug' => 'testimonial_grid',
                'component_name' => 'testimonial_grid',
                'category' => 'testimonial',
                'description' => 'Testimonial grid layout',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'testimonials' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'client_name' => ['type' => 'text'],
                        'client_position' => ['type' => 'text'],
                        'client_image' => ['type' => 'image'],
                        'testimonial' => ['type' => 'textarea'],
                        'rating' => ['type' => 'number'],
                    ]],
                ],
                'default_data' => [
                    'testimonials' => [],
                ],
            ],
            [
                'name' => 'Call to Action Section',
                'slug' => 'cta_section',
                'component_name' => 'cta_section',
                'category' => 'cta',
                'description' => 'Call-to-action banner section',
                'schema' => [
                    'heading' => ['type' => 'text', 'required' => true],
                    'description' => ['type' => 'textarea', 'required' => false],
                    'background_image' => ['type' => 'image', 'required' => false],
                    'cta_text' => ['type' => 'text', 'required' => true],
                    'cta_link' => ['type' => 'text', 'required' => true],
                ],
                'default_data' => [
                    'heading' => 'Ready to Get Started?',
                    'cta_text' => 'Contact Us Now',
                ],
            ],
            [
                'name' => 'Feature List',
                'slug' => 'feature_list',
                'component_name' => 'feature_list',
                'category' => 'content',
                'description' => 'Icon and text features list',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'features' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'icon' => ['type' => 'image'],
                        'title' => ['type' => 'text'],
                        'description' => ['type' => 'textarea'],
                    ]],
                ],
                'default_data' => [
                    'features' => [],
                ],
            ],
            [
                'name' => 'Gallery Grid',
                'slug' => 'gallery_grid',
                'component_name' => 'gallery_grid',
                'category' => 'gallery',
                'description' => 'Image gallery in grid layout',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'images' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'image' => ['type' => 'image'],
                        'caption' => ['type' => 'text'],
                    ]],
                ],
                'default_data' => [
                    'images' => [],
                ],
            ],
            [
                'name' => 'Gallery Masonry',
                'slug' => 'gallery_masonry',
                'component_name' => 'gallery_masonry',
                'category' => 'gallery',
                'description' => 'Masonry-style gallery',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'images' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'image' => ['type' => 'image'],
                        'caption' => ['type' => 'text'],
                    ]],
                ],
                'default_data' => [
                    'images' => [],
                ],
            ],
            [
                'name' => 'FAQ Accordion',
                'slug' => 'faq_accordion',
                'component_name' => 'faq_accordion',
                'category' => 'faq',
                'description' => 'FAQ section with accordion',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'faqs' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'question' => ['type' => 'text'],
                        'answer' => ['type' => 'textarea'],
                    ]],
                ],
                'default_data' => [
                    'section_title' => 'Frequently Asked Questions',
                    'faqs' => [],
                ],
            ],
            [
                'name' => 'Content Two Column',
                'slug' => 'content_two_column',
                'component_name' => 'content_two_column',
                'category' => 'content',
                'description' => 'Two-column content in styled cards with optional images',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'section_subtitle' => ['type' => 'text', 'required' => false],
                    'image_1' => ['type' => 'image', 'required' => false, 'hint' => 'Optional image for column 1'],
                    'column_1' => ['type' => 'wysiwyg', 'required' => true],
                    'image_2' => ['type' => 'image', 'required' => false, 'hint' => 'Optional image for column 2'],
                    'column_2' => ['type' => 'wysiwyg', 'required' => true],
                ],
                'default_data' => [
                    'column_1' => '',
                    'column_2' => '',
                ],
            ],
            [
                'name' => 'Content Full Width',
                'slug' => 'content_full_width',
                'component_name' => 'content_full_width',
                'category' => 'content',
                'description' => 'Full-width content with optional featured image',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'section_subtitle' => ['type' => 'text', 'required' => false],
                    'image' => ['type' => 'image', 'required' => false, 'hint' => 'Optional featured image above content'],
                    'content' => ['type' => 'wysiwyg', 'required' => true],
                ],
                'default_data' => [
                    'content' => '',
                ],
            ],
            [
                'name' => 'Map with Location Cards',
                'slug' => 'map_location_cards',
                'component_name' => 'map_location_cards',
                'category' => 'map',
                'description' => 'Map with location card overlays',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'map_embed_url' => ['type' => 'text', 'required' => true],
                    'locations' => ['type' => 'repeater', 'required' => false, 'fields' => [
                        'title' => ['type' => 'text'],
                        'address' => ['type' => 'textarea'],
                        'phone' => ['type' => 'text'],
                    ]],
                ],
                'default_data' => [
                    'locations' => [],
                ],
            ],
            [
                'name' => 'Contact Form',
                'slug' => 'contact_form',
                'component_name' => 'contact_form',
                'category' => 'form',
                'description' => 'Contact/quote request form',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'description' => ['type' => 'textarea', 'required' => false],
                    'form_type' => ['type' => 'select', 'options' => ['contact', 'quote'], 'default' => 'quote'],
                ],
                'default_data' => [
                    'section_title' => 'Request a Quote',
                    'form_type' => 'quote',
                ],
            ],
            [
                'name' => 'Pricing Table',
                'slug' => 'pricing_table',
                'component_name' => 'pricing_table',
                'category' => 'other',
                'description' => 'Pricing comparison table',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'plans' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'name' => ['type' => 'text'],
                        'price' => ['type' => 'text'],
                        'features' => ['type' => 'textarea'],
                        'cta_text' => ['type' => 'text'],
                        'cta_link' => ['type' => 'text'],
                    ]],
                ],
                'default_data' => [
                    'plans' => [],
                ],
            ],
            [
                'name' => 'Team Grid',
                'slug' => 'team_grid',
                'component_name' => 'team_grid',
                'category' => 'other',
                'description' => 'Team members grid',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'members' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'photo' => ['type' => 'image'],
                        'name' => ['type' => 'text'],
                        'position' => ['type' => 'text'],
                        'bio' => ['type' => 'textarea'],
                    ]],
                ],
                'default_data' => [
                    'section_title' => 'Our Team',
                    'members' => [],
                ],
            ],
            [
                'name' => 'Timeline',
                'slug' => 'timeline',
                'component_name' => 'timeline',
                'category' => 'other',
                'description' => 'Journey/timeline section',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'events' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'year' => ['type' => 'text'],
                        'title' => ['type' => 'text'],
                        'description' => ['type' => 'textarea'],
                    ]],
                ],
                'default_data' => [
                    'events' => [],
                ],
            ],
            [
                'name' => 'Video Embed',
                'slug' => 'video_embed',
                'component_name' => 'video_embed',
                'category' => 'other',
                'description' => 'Video section with embed',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'video_url' => ['type' => 'text', 'required' => true],
                    'thumbnail' => ['type' => 'image', 'required' => false],
                ],
                'default_data' => [
                    'video_url' => '',
                ],
            ],
            [
                'name' => 'Logo Showcase',
                'slug' => 'logo_showcase',
                'component_name' => 'logo_showcase',
                'category' => 'other',
                'description' => 'Partner/client logos showcase',
                'schema' => [
                    'section_title' => ['type' => 'text', 'required' => false],
                    'logos' => ['type' => 'repeater', 'required' => true, 'fields' => [
                        'image' => ['type' => 'image'],
                        'name' => ['type' => 'text'],
                        'link' => ['type' => 'text'],
                    ]],
                ],
                'default_data' => [
                    'logos' => [],
                ],
            ],
            [
                'name' => 'Scrolling Ticker',
                'slug' => 'scrolling_ticker',
                'component_name' => 'scrolling_ticker',
                'category' => 'other',
                'description' => 'Scrolling text ticker',
                'schema' => [
                    'text' => ['type' => 'text', 'required' => true],
                    'speed' => ['type' => 'number', 'default' => 50],
                ],
                'default_data' => [
                    'text' => 'Welcome to Good Procurement Service Ltd',
                    'speed' => 50,
                ],
            ],
        ];

        foreach ($blockTypes as $blockType) {
            PageBlockType::updateOrCreate(
                ['slug' => $blockType['slug']],
                $blockType
            );
        }
    }
}
