<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class LiveContentSeeder extends Seeder
{
    public function run(): void
    {
        $domains = Domain::all();

        // 1. Categories
        $archCategory = ProjectCategory::updateOrCreate(['slug' => 'commercial-architecture'], ['name' => 'Commercial Architecture']);
        $interiorCategory = ProjectCategory::updateOrCreate(['slug' => 'commercial-interiors'], ['name' => 'Commercial Interiors']);
        $consultCategory = ProjectCategory::updateOrCreate(['slug' => 'construction-consultancy'], ['name' => 'Construction Consultancy']);
        $procureCategory = ProjectCategory::updateOrCreate(['slug' => 'procurement-fit-out'], ['name' => 'Procurement & Fit-Out']);

        $newsCategory = PostCategory::updateOrCreate(['slug' => 'workplace-insights'], ['name' => 'Workplace Insights']);
        $designCategory = PostCategory::updateOrCreate(['slug' => 'interior-design'], ['name' => 'Interior Design']);
        $caseCategory = PostCategory::updateOrCreate(['slug' => 'case-studies'], ['name' => 'Case Studies']);

        // 2. Services (5 services from services.jpeg)
        $servicesData = [
            [
                'slug' => 'commercial-interiors',
                'title' => 'Commercial Interiors',
                'subtitle' => 'Tailored Commercial Interiors Grounded in Workflow & Well-being',
                'icon' => 'cube',
                'image' => '/storage/uploads/services/commercial-interiors.jpg',
                'order' => 1,
                'excerpt' => 'Human-centric commercial interiors that elevate workforce productivity and reflect corporate brand identity.',
                'features' => [
                    'Acoustic Planning & Privacy Management',
                    'Ergonomic Workstation Layouts & Executive Suites',
                    'Brand Identity & Custom Color Harmony',
                    'Lighting Concept Design & Visual Comfort',
                ],
            ],
            [
                'slug' => 'project-management',
                'title' => 'Project Management',
                'subtitle' => 'End-to-End Turnkey Execution and Oversight',
                'icon' => 'building',
                'image' => '/storage/uploads/services/construction-consultancy.jpg',
                'order' => 2,
                'excerpt' => 'Our project management team ensures smooth execution, rigorous quality control, and on-time delivery.',
                'features' => [
                    'Master Construction Scheduling & Critical Path Control',
                    'Vendor Management & Cost Auditing',
                    'Quality Assurance and Site Supervision',
                    'Smooth Occupancy & Post-Handover Support',
                ],
            ],
            [
                'slug' => 'construction-consultancy',
                'title' => 'Construction Consultancy',
                'subtitle' => 'Turnkey Engineering & Structural Design Advisory',
                'icon' => 'hammer',
                'image' => '/storage/uploads/services/construction-consultancy.jpg',
                'order' => 3,
                'excerpt' => 'Engineering expertise, structural safety assessments, and compliance audits for corporate fit-outs.',
                'features' => [
                    'Structural Integrity and Engineering Assurance',
                    'Timeline, Budget, and Material Cost Auditing',
                    'Health, Safety, and Environmental Compliance',
                    'Regulatory Approvals & Statutory Building Permits',
                ],
            ],
            [
                'slug' => 'procurement-fit-out',
                'title' => 'Procurement & Fit-out',
                'subtitle' => 'Strategic Materials Procurement and Commercial Grade Fit-outs',
                'icon' => 'truck',
                'image' => '/storage/uploads/services/procurement-services.jpg',
                'order' => 4,
                'excerpt' => 'We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.',
                'features' => [
                    'Direct International Furniture & Fixture Sourcing',
                    'Custom Joinery and Architectural Millwork',
                    'Logistics, Customs Clearance, and White-Glove Installation',
                    'Comprehensive Manufacturer Warranty Administration',
                ],
            ],
            [
                'slug' => 'interior-design',
                'title' => 'Interior Design',
                'subtitle' => 'Functional, Stylish Spaces that Inspire Employees and Impress Clients',
                'icon' => 'brush',
                'image' => '/storage/uploads/services/commercial-architecture.jpg',
                'order' => 5,
                'excerpt' => 'We create functional, stylish spaces that inspire employees and impress clients across diverse sectors.',
                'features' => [
                    'Comprehensive 3D BIM Modelling & Virtual Walkthroughs',
                    'Space Planning and Workspace Optimization',
                    'Sustainable & Biophilic Material Specification',
                    'Color Psychology & Environmental Graphic Integration',
                ],
            ],
        ];

        foreach ($domains as $domain) {
            foreach ($servicesData as $s) {
                Service::updateOrCreate(
                    ['domain_id' => $domain->id, 'slug' => $s['slug']],
                    [
                        'title' => $s['title'],
                        'subtitle' => $s['subtitle'],
                        'excerpt' => $s['excerpt'],
                        'description' => "<p>{$s['excerpt']}</p><p>{$s['subtitle']}. With a strong footprint in both the UK and Nigeria, Torre Tórò brings international rigor to every square meter.</p>",
                        'icon' => $s['icon'],
                        'thumbnail_image' => $s['image'],
                        'banner_image' => $s['image'],
                        'features' => $s['features'],
                        'order' => $s['order'],
                        'is_featured' => true,
                        'is_active' => true,
                    ]
                );
            }
        }

        // 3. Projects (from portfolio.jpeg and sanlam portfolio.jpeg)
        $projectsData = [
            [
                'slug' => 'sanlam-insurance',
                'title' => 'Sanlam Insurance V.I. Lagos',
                'subtitle' => 'Where Heritage Meets Modern Vision',
                'client_name' => 'Sanlam Insurance Group',
                'location' => 'Victoria Island, Lagos, Nigeria',
                'year' => '2024',
                'services_rendered' => 'Commercial Interior Design & Turnkey Fit-Out',
                'category_id' => $interiorCategory->id,
                'image' => '/storage/uploads/projects/sanlam-insurance-1.jpg',
                'gallery' => [
                    ['url' => '/storage/uploads/projects/sanlam-insurance-1.jpg', 'caption' => 'Executive Boardroom & Acoustic Panelling'],
                    ['url' => '/storage/uploads/projects/sanlam-insurance-2.jpg', 'caption' => 'Collaborative Open Workstations & Lighting'],
                ],
                'excerpt' => 'Where Heritage Meets Modern Vision — A state-of-the-art corporate boardroom, executive offices, and collaborative workstations.',
                'description' => '<p>Completed on June 19, 2024, Sanlam Insurance entrusted Torre Tórò to revamp their Victoria Island headquarters into a cutting-edge, biophilic work environment. Featuring acoustic wall panels, executive board suites, and bespoke lighting.</p>',
                'stats' => ['area' => '15,000 sq ft', 'timeline' => '16 weeks', 'capacity' => '250 workstations'],
                'order' => 1,
            ],
            [
                'slug' => 'shoelab-hq',
                'title' => 'ShoeLab HQ Lekki',
                'subtitle' => 'Contemporary Retail & Creative Studio Space',
                'client_name' => 'ShoeLab',
                'location' => 'Lekki Phase 1, Lagos, Nigeria',
                'year' => '2023',
                'services_rendered' => 'Commercial Interior Architecture & Workspace Optimization',
                'category_id' => $interiorCategory->id,
                'image' => '/storage/uploads/projects/shoelab-1.jpg',
                'gallery' => [
                    ['url' => '/storage/uploads/projects/shoelab-1.jpg', 'caption' => 'Curated Retail Display & Spotlight Architecture'],
                    ['url' => '/storage/uploads/projects/shoelab-2.jpg', 'caption' => 'Minimalist Studio Concrete Fit-Out'],
                ],
                'excerpt' => 'An innovative blend of retail showroom and open-plan creative design studios for a high-growth luxury brand.',
                'description' => '<p>ShoeLab HQ required an adaptable, minimalist aesthetic incorporating raw concrete finishes, curated spotlighting, and seamless retail flow.</p>',
                'stats' => ['area' => '4,200 sq ft', 'timeline' => '8 weeks', 'capacity' => 'Creative Studios & Retail Display'],
                'order' => 2,
            ],
            [
                'slug' => 'gtbank-headquarters-gym',
                'title' => 'GTBank Headquarters Gym',
                'subtitle' => 'Wellness & Athletic Transformation',
                'client_name' => 'Guaranty Trust Bank (GTBank)',
                'location' => 'Lagos Island, Lagos, Nigeria',
                'year' => '2023',
                'services_rendered' => 'Architectural Renovation & Corporate Wellness Fit-Out',
                'category_id' => $archCategory->id,
                'image' => '/storage/uploads/projects/gtbank-gym-1.jpg',
                'gallery' => [
                    ['url' => '/storage/uploads/projects/gtbank-gym-1.jpg', 'caption' => 'Athletic Fitness Suite & Shock Absorbent Flooring'],
                    ['url' => '/storage/uploads/projects/gtbank-gym-2.jpg', 'caption' => 'Acoustic Cardio Zone & Custom HVAC'],
                ],
                'excerpt' => 'Turnkey renovation of the GTBank corporate gym, featuring specialized shock-absorbent flooring, advanced ventilation, and energizing spatial architecture.',
                'description' => '<p>Delivered within an active banking headquarters, this wellness center combines acoustic isolation with premium fitness equipment layout.</p>',
                'stats' => ['area' => '8,500 sq ft', 'timeline' => '12 weeks', 'features' => 'Rubberized flooring, HVAC integration'],
                'order' => 3,
            ],
        ];

        foreach ($domains as $domain) {
            foreach ($projectsData as $p) {
                Project::updateOrCreate(
                    ['domain_id' => $domain->id, 'slug' => $p['slug']],
                    [
                        'category_id' => $p['category_id'],
                        'title' => $p['title'],
                        'client_name' => $p['client_name'],
                        'location' => $domain->code === 'uk' ? str_replace('Nigeria', 'UK & Global', $p['location']) : $p['location'],
                        'year' => $p['year'],
                        'services_rendered' => $p['services_rendered'],
                        'thumbnail_image' => $p['image'],
                        'banner_image' => $p['image'],
                        'gallery_images' => $p['gallery'],
                        'excerpt' => $p['excerpt'],
                        'description' => $p['description'],
                        'stats' => $p['stats'],
                        'is_featured' => true,
                        'order' => $p['order'],
                    ]
                );
            }
        }

        // 4. Testimonials (Mrs Jacobo from homepage.jpeg verbatim!)
        foreach ($domains as $domain) {
            Testimonial::updateOrCreate(
                ['domain_id' => $domain->id, 'client_name' => 'Mrs Jacobo'],
                [
                    'client_role' => 'Client',
                    'company_name' => 'Office Interior Design in Abuja, Nigeria.',
                    'quote' => 'As a client, I felt involved in every step. The design team was responsive, transparent, and dedicated to bringing our vision to life. The final space is stylish, comfortable, and perfectly suited to our needs.',
                    'avatar_image' => '/storage/uploads/team/adeboye-damilola.png',
                    'rating' => 5,
                    'is_featured' => true,
                ]
            );

            Testimonial::updateOrCreate(
                ['domain_id' => $domain->id, 'client_name' => 'Sanlam Facilities Director'],
                [
                    'client_role' => 'Head of Infrastructure',
                    'company_name' => 'Sanlam Insurance Group',
                    'quote' => 'Torre Tórò delivered a transformative workspace that exceeded our expectations. The attention to acoustic detail, ergonomic flow, and turnkey delivery was impeccable.',
                    'avatar_image' => '/storage/uploads/team/oludara-samuel.jpg',
                    'rating' => 5,
                    'is_featured' => true,
                ]
            );
        }

        // 5. Blog / Insights
        $postsData = [
            [
                'slug' => 'how-commercial-interiors-design-boost-workplace-productivity',
                'category_id' => $newsCategory->id,
                'title' => 'How Commercial Interiors Design Boosts Workplace Productivity',
                'excerpt' => 'Discover how thoughtful spatial layout, acoustic comfort, and natural illumination directly impact team focus and organizational performance.',
                'image' => '/storage/uploads/about/brainstorming.png',
                'read_time' => '4 min read',
            ],
            [
                'slug' => 'design-for-everyone-rethinking-accessibility-in-modern-workspaces',
                'category_id' => $designCategory->id,
                'title' => 'Design for Everyone: Rethinking Accessibility in Modern Workspaces',
                'excerpt' => 'Universal design principles and ADA compliance in executive boardrooms, open desks, and communal breakout hubs.',
                'image' => '/storage/uploads/services/commercial-interiors.jpg',
                'read_time' => '5 min read',
            ],
            [
                'slug' => 'heres-why-sanlam-insurance-chose-us',
                'category_id' => $caseCategory->id,
                'title' => "Here's Why Sanlam Insurance Chose Torre Tórò for Their Headquarters",
                'excerpt' => 'Inside the 16-week transformation of Sanlam Insurance Victoria Island office: from architectural conception to turnkey move-in.',
                'image' => '/storage/uploads/projects/sanlam-insurance-1.jpg',
                'read_time' => '6 min read',
            ],
        ];

        foreach ($domains as $domain) {
            foreach ($postsData as $post) {
                Post::updateOrCreate(
                    ['domain_id' => $domain->id, 'slug' => $post['slug']],
                    [
                        'category_id' => $post['category_id'],
                        'title' => $post['title'],
                        'excerpt' => $post['excerpt'],
                        'featured_image' => $post['image'],
                        'content' => "<p>{$post['excerpt']}</p><p>Commercial architecture is undergoing a quiet revolution. As companies transition between hybrid and on-site schedules, the office must become a magnet for collaboration rather than a routine obligation.</p>",
                        'author_name' => 'Torre Tórò Editorial Team',
                        'read_time' => $post['read_time'],
                        'published_at' => now(),
                        'is_published' => true,
                    ]
                );
            }
        }

        // 6. Pages (Home, About Us, Services, Portfolio, Contact Us)
        foreach ($domains as $domain) {
            $isUk = $domain->code === 'uk';
            $officeAddress = $isUk 
                ? '45 Berkeley Square, Mayfair, London W1J 5AS, United Kingdom' 
                : '16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA';
            $phone1 = $isUk ? '+44 20 7946 0991' : '+234 813 600 1221';
            $phone2 = $isUk ? '+44 20 7946 0912' : '+234 011 336 54';
            $callUs = $isUk ? '+44 20 7946 0991' : '+234 813 600 1221';
            $email1 = $isUk ? 'uk@torretoro.com' : 'hello@torretoro.com';
            $email2 = $isUk ? 'london@torretoro.com' : 'dami@torretoro.com';

            // Home Page
            Page::updateOrCreate(
                ['domain_id' => $domain->id, 'slug' => 'home'],
                [
                    'title' => 'Home',
                    'hero_badge' => 'COMMERCIAL INTERIOR DESIGN & ARCHITECTURE',
                    'hero_title' => 'Designing Spaces that Inspire Success',
                    'hero_subtitle' => 'At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish. Your workspace design should fuel productivity, innovation, and employee satisfaction.',
                    'hero_image' => '/storage/uploads/hero/hero-bg.jpg',
                    'sections' => [
                        'hero' => [
                            'badge' => 'COMMERCIAL INTERIOR DESIGN & ARCHITECTURE',
                            'title' => 'Designing Spaces that Inspire Success',
                            'subtitle' => 'At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish. Your workspace design should fuel productivity, innovation, and employee satisfaction.',
                            'cta_text' => "LET'S CREATE YOUR PERFECT SPACE  →",
                            'cta_url' => '/contact-us',
                            'image' => '/storage/uploads/hero/hero-bg.jpg',
                            'video_url' => '/storage/uploads/branding/corporate-logo.mp4',
                        ],
                        'stats' => [
                            'counter_1_number' => '14',
                            'counter_1_label' => 'Completed Projects',
                            'counter_2_number' => '7+',
                            'counter_2_label' => 'Years of Experience',
                            'headline' => 'We Govern and Manage Place and Privacy policies',
                        ],
                        'expertise' => [
                            [
                                'title' => 'Interior Design',
                                'desc' => 'We create functional, stylish spaces that inspire employees and impress clients.',
                                'icon' => 'cube',
                            ],
                            [
                                'title' => 'Project Management',
                                'desc' => 'Our project management team ensures smooth execution',
                                'icon' => 'building',
                            ],
                            [
                                'title' => 'Procurement & Fit-out',
                                'desc' => 'We handle the procurement of materials and procurement of furniture, guaranteeing cohesive spaces that match your goals.',
                                'icon' => 'truck',
                            ],
                        ],
                        'about' => [
                            'badge' => 'ABOUT US',
                            'tag' => 'Crafting Experiences',
                            'heading' => 'With our expertise we guarentee success',
                            'paragraph_1' => 'We are a leading interior design firm dedicated to crafting commercial spaces that inspire, innovate, and elevate the way people work.',
                            'paragraph_2' => 'With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.',
                            'paragraph_3' => 'Whether you are reimagining your corporate office, retail environment, or hospitality space, our tailored approach ensures that your vision comes to life.',
                            'cta_text' => 'LEARN MORE  →',
                            'cta_url' => '/about-us',
                            'image_1' => '/storage/uploads/about/about-page.png',
                            'image_2' => '/storage/uploads/about/about-story.png',
                            'video_url' => '/storage/uploads/branding/corporate-logo.mp4',
                        ],
                        'pillars' => [
                            'badge' => 'OUR PROCESS',
                            'heading' => 'Architectural Rigor From Vision to Delivery',
                            'cards' => [
                                [
                                    'title' => 'Research & Analysis',
                                    'desc' => 'Understanding Context, Culture, and Client Needs',
                                    'image' => '/storage/uploads/about/brainstorming.png',
                                ],
                                [
                                    'title' => 'Industry Development',
                                    'desc' => 'Design Innovation, Strategy, and Technical Planning',
                                    'image' => '/storage/uploads/services/commercial-architecture.jpg',
                                ],
                                [
                                    'title' => 'Production Launch',
                                    'desc' => 'Execution, Oversight, and Final Delivery',
                                    'image' => '/storage/uploads/projects/sanlam-insurance-1.jpg',
                                ],
                            ],
                        ],
                        'projects_section' => [
                            'badge' => 'OUR WORKS',
                            'heading' => 'Our Special Projects',
                            'subheading' => 'A curated selection of our commercial interior design and turnkey architectural completions.',
                            'cta_text' => 'SEE OUR FULL PORTFOLIO  →',
                            'cta_url' => '/portfolio',
                        ],
                        'review' => [
                            'badge' => 'TESTIMONIALS',
                            'heading' => 'What Our Clients Say',
                            'subheading' => 'Hear directly from corporate executives and facility directors whose workspaces we have transformed.',
                            'quote' => 'As a client, I felt involved in every step. The design team was responsive, transparent, and dedicated to bringing our vision to life. The final space is stylish, comfortable, and perfectly suited to our needs.',
                            'client_name' => 'Mrs Jacobo',
                            'client_role' => 'Office Interior Design in Abuja, Nigeria.',
                            'client_company' => 'Jacobo Corporate Offices',
                            'client_avatar' => '/storage/uploads/team/adeboye-damilola.png',
                            'rating' => 5,
                        ],
                        'map' => [
                            'badge' => 'VISIT OUR STUDIOS',
                            'heading' => 'Global Footprint & Project Hubs',
                            'office_title' => $isUk ? 'Torre Toro London Design Studio' : 'Torre Toro Architecture Headquarters',
                            'address' => $officeAddress,
                            'phone_1' => $phone1,
                            'phone_2' => $phone2,
                            'call_us_today' => $callUs,
                            'email_1' => $email1,
                            'email_2' => $email2,
                            'working_hours' => 'Monday - Friday: 8:00 AM - 6:00 PM',
                            'map_image' => '/storage/uploads/maps/map-location.png',
                            'embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.727768913337!2d3.4735!3d6.4419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf45300000001%3A0x1!2s16a%20Da-Silva%20St%2C%20Lekki%20Phase%20I%2C%20Lekki%2C%20Lagos!5e0!3m2!1sen!2sng!4v1714500000000!5m2!1sen!2sng',
                            'directions_url' => 'https://maps.google.com/?q=' . urlencode($officeAddress),
                        ],
                        'bottom_video' => [
                            'heading' => 'Experience Architecture in Motion',
                            'subheading' => 'Take a dynamic tour through our completed commercial headquarters and signature fit-outs.',
                            'poster_image' => '/storage/uploads/video/video-bg.jpg',
                            'video_cover' => '/storage/uploads/video/video-cover.png',
                            'video_url' => '/storage/uploads/branding/corporate-logo.mp4',
                            'cta_text' => "LET'S CREATE YOUR PERFECT SPACE  →",
                            'cta_url' => '/contact-us',
                        ],
                    ],
                    'meta_title' => $domain->meta_title,
                    'meta_description' => $domain->meta_description,
                    'is_published' => true,
                ]
            );

            // About Us Page
            Page::updateOrCreate(
                ['domain_id' => $domain->id, 'slug' => 'about-us'],
                [
                    'title' => 'About Us',
                    'hero_badge' => 'ABOUT US',
                    'hero_title' => 'CRAFTING EXPERIENCES',
                    'hero_subtitle' => 'Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.',
                    'hero_image' => '/storage/uploads/about/about-page.png',
                    'sections' => [
                        'hero' => [
                            'badge' => 'ABOUT US',
                            'title' => 'CRAFTING EXPERIENCES',
                            'subtitle' => 'Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.',
                            'image' => '/storage/uploads/about/about-page.png',
                        ],
                        'story' => [
                            'badge' => 'OUR STORY',
                            'heading' => 'Architectural Passion and Purpose',
                            'paragraph_1' => 'Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect. Founded by architects and interior design specialists, we believe design is more than aesthetics; it is a catalyst for corporate productivity.',
                            'paragraph_2' => 'With a strong presence in the UK and Nigeria, we combine global design trends with localized insights to deliver spaces that are visually stunning, functional, and aligned with your business objectives.',
                            'image' => '/storage/uploads/about/about-story.png',
                        ],
                        'vision_mission' => [
                            'vision' => 'To be a global leader in commercial architecture and workplace design, inspiring businesses to achieve their full potential.',
                            'mission' => 'To create innovative, high-performance work environments through human-centric design, architectural precision, and seamless project delivery.',
                            'values' => ['Creativity', 'Collaboration', 'Excellence', 'Integrity', 'Innovation'],
                        ],
                        'team' => [
                            'badge' => 'LEADERSHIP',
                            'heading' => 'Meet the Team',
                            'members' => [
                                [
                                    'name' => 'Adeboye Damilola',
                                    'role' => 'MD/CEO',
                                    'bio' => '15+ years experience in commercial interior design, turnkey architecture, and workplace masterplanning.',
                                    'image' => '/storage/uploads/team/adeboye-damilola.png',
                                ],
                                [
                                    'name' => 'Kater Titus',
                                    'role' => 'Chief Technology Officer (CTO)',
                                    'bio' => 'Directing digital twin integrations, smart building automation, and architectural technology systems.',
                                    'image' => '/storage/uploads/team/kater-titus.jpg',
                                ],
                                [
                                    'name' => 'Olamide Roberts',
                                    'role' => 'Media & Brand Director',
                                    'bio' => 'Overseeing visual identity, brand communications, and experiential design narratives.',
                                    'image' => '/storage/uploads/team/olamide-roberts.jpg',
                                ],
                                [
                                    'name' => 'Samuel Oludara',
                                    'role' => 'Project Lead & Spatial Architect',
                                    'bio' => 'Leading site engineering, BIM modeling, and architectural coordination across commercial developments.',
                                    'image' => '/storage/uploads/team/oludara-samuel.jpg',
                                ],
                                [
                                    'name' => 'Idris Salau',
                                    'role' => 'Construction & Site Manager',
                                    'bio' => 'Spearheading on-site fit-out execution, contractor oversight, and structural quality compliance.',
                                    'image' => '/storage/uploads/team/idris-salau.jpg',
                                ],
                            ],
                        ],
                    ],
                    'meta_title' => 'About Torre Tórò | Crafting Experiences & Workplace Architecture',
                    'meta_description' => 'Torre Toro was born from a simple idea: that the spaces we inhabit shape how we think, work, and connect.',
                    'is_published' => true,
                ]
            );

            // Services Page
            Page::updateOrCreate(
                ['domain_id' => $domain->id, 'slug' => 'services'],
                [
                    'title' => 'Services',
                    'hero_badge' => 'WHAT WE DO',
                    'hero_title' => 'DESIGNING FOR IMPACT',
                    'hero_subtitle' => 'Comprehensive commercial architecture, interior design, and turnkey procurement services tailored for modern organizations.',
                    'hero_image' => '/storage/uploads/services/services-bg.jpg',
                    'sections' => [
                        'hero' => [
                            'badge' => 'WHAT WE DO',
                            'title' => 'DESIGNING FOR IMPACT',
                            'subtitle' => 'Comprehensive commercial architecture, interior design, and turnkey procurement services tailored for modern organizations.',
                            'image' => '/storage/uploads/services/services-bg.jpg',
                        ],
                    ],
                    'meta_title' => 'Our Services | Torre Tórò Commercial Architecture & Fit-Out',
                    'meta_description' => 'Explore Torre Tórò commercial interior design, project management, construction consultancy, and procurement services.',
                    'is_published' => true,
                ]
            );

            // Contact Us Page
            Page::updateOrCreate(
                ['domain_id' => $domain->id, 'slug' => 'contact-us'],
                [
                    'title' => 'Contact Us',
                    'hero_badge' => 'GET IN TOUCH',
                    'hero_title' => 'Contact Us',
                    'hero_subtitle' => "Let's discuss how we can transform your commercial workspace.",
                    'hero_image' => '/storage/uploads/about/contact-header.png',
                    'sections' => [
                        'hero' => [
                            'badge' => 'GET IN TOUCH',
                            'title' => 'Contact Us',
                            'subtitle' => "Let's discuss how we can transform your commercial workspace.",
                            'image' => '/storage/uploads/about/contact-header.png',
                        ],
                        'form_info' => [
                            'button_text' => 'APPOINTMENT →',
                            'address' => $officeAddress,
                            'phone_1' => $phone1,
                            'phone_2' => $phone2,
                            'email_1' => $email1,
                            'email_2' => $email2,
                            'working_hours' => 'Monday - Friday: 8:00 AM - 6:00 PM',
                        ],
                    ],
                    'meta_title' => 'Contact Torre Tórò | Request an Appointment',
                    'meta_description' => 'Get in touch with Torre Tórò for office interior design, project management, and turnkey construction appointments.',
                    'is_published' => true,
                ]
            );

            // Portfolio Archive Page
            Page::updateOrCreate(
                ['domain_id' => $domain->id, 'slug' => 'portfolio'],
                [
                    'title' => 'Portfolio',
                    'hero_badge' => 'OUR WORKS',
                    'hero_title' => 'Spaces That Speak for Themselves',
                    'hero_subtitle' => 'Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.',
                    'hero_image' => '/storage/uploads/projects/portfolio-header.png',
                    'sections' => [
                        'hero' => [
                            'badge' => 'OUR WORKS',
                            'title' => 'Spaces That Speak for Themselves',
                            'subtitle' => 'Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.',
                            'image' => '/storage/uploads/projects/portfolio-header.png',
                        ],
                    ],
                    'meta_title' => 'Portfolio & Case Studies | Torre Tórò Commercial Projects',
                    'meta_description' => 'Explore our featured commercial office fit-outs, executive boardrooms, and creative studios.',
                    'is_published' => true,
                ]
            );
        }
    }
}
