# Torre Tórò Backend API Documentation & Frontend Integration Guide

This guide provides everything a frontend developer or autonomous agent needs to connect a frontend (Next.js, React, Vue, Nuxt, Svelte, Mobile App, etc.) to the **Torre Tórò** backend API.

---

## 1. Architecture & Multi-Domain Overview

Torre Tórò operates as a multi-region platform serving different phone numbers, currencies, addresses, projects, and content for:
1. **Global / Nigeria** (`global`) — Default domain.
2. **United Kingdom** (`uk`) — UK specific domain.

### Base URLs
* **Local Development**: `http://127.0.0.1:8000` (or `http://localhost:8000`)
* **API Prefix**: `/api/v1`
* **Static Assets**: All media assets (images, logos, videos) are served under `/storage/...` (e.g., `http://127.0.0.1:8000/storage/uploads/projects/...`).

### Domain Resolution (How Domain is Determined)
The backend automatically resolves the active domain for every request using the following priority order:
1. **HTTP Header**: `X-Domain: uk` or `X-Domain: global` (Recommended for frontend apps / SSR).
2. **Query Parameter**: `?domain=uk` or `?domain=global` (Convenient for quick testing or links).
3. **Host Header**: Automatically maps hostnames (e.g. `torretoro.co.uk` -> `uk`, `torretoro.com` -> `global`).
4. **Fallback Default**: `global`.

Every API response includes the active domain header for verification:
```http
X-Active-Domain: global
```

---

## 2. API Endpoints Quick Reference

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/v1/config` | Global site config, branding, active domain contact info, navigation menus, and settings |
| `GET` | `/api/v1/domains` | List of supported active domains (`global`, `uk`) |
| `GET` | `/api/v1/pages/{slug}` | Dynamic page content with structured sections (`home`, `about-us`, `contact-us`, `services`, `portfolio`) |
| `GET` | `/api/v1/services` | List all active architectural & interior design services |
| `GET` | `/api/v1/services/{slug}` | Single service detail with features and related services |
| `GET` | `/api/v1/projects` | Paginated projects list with category filtering and featured flag |
| `GET` | `/api/v1/projects/{slug}` | Single project detail with multi-image gallery, stats, and related projects |
| `GET` | `/api/v1/posts` | Paginated news & blog articles |
| `GET` | `/api/v1/posts/{slug}` | Single article detail + recent posts |
| `GET` | `/api/v1/testimonials` | Featured client testimonials |
| `POST` | `/api/v1/inquiries` | Submit contact inquiry or consultation request |

---

## 3. Detailed Endpoint Specifications

### 3.1. Site Configuration & Menus
#### `GET /api/v1/config`
Retrieves all global branding assets, phone numbers, email addresses, social links, navigation menus, and custom site settings for the requested domain.

* **Headers**: `Accept: application/json`, `X-Domain: [global|uk]` (optional)
* **Query Params**: `domain=[global|uk]` (optional)

#### Response Example (`200 OK`)
```json
{
  "domain": {
    "code": "global",
    "name": "Torre Tórò International (Nigeria & Global)",
    "currency": "NGN",
    "phone": "+234 813 600 1221",
    "phone_1": "+234 813 600 1221",
    "phone_2": "+234 011 336 54",
    "phone_secondary": "+234 011 336 54",
    "email": "hello@torretoro.com",
    "email_1": "hello@torretoro.com",
    "email_2": "dami@torretoro.com",
    "email_secondary": "dami@torretoro.com",
    "address": "16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA",
    "social_links": {
      "instagram": "https://www.instagram.com/torretorong/",
      "facebook": "https://facebook.com/torretorong",
      "twitter": "https://x.com/torretorong",
      "linkedin": "https://linkedin.com/company/torretoro",
      "youtube": "https://youtube.com/@torretoro"
    },
    "meta_title": "Commercial Interior Design & Architecture Firm | Torre Tórò",
    "meta_description": "At Torre Toro, we transform commercial spaces into vibrant environments where creativity thrives and businesses flourish."
  },
  "menus": {
    "header": [
      {
        "id": 49,
        "title": "Home",
        "url": "/",
        "target": "_self",
        "order": 1,
        "children": []
      },
      {
        "id": 50,
        "title": "Services",
        "url": "/services",
        "target": "_self",
        "order": 2,
        "children": [
          { "id": 51, "title": "Commercial Architecture", "url": "/services/architectural-design" },
          { "id": 52, "title": "Commercial Interiors", "url": "/services/interior-design" },
          { "id": 53, "title": "Construction Consultancy", "url": "/services/building-construction" },
          { "id": 54, "title": "Procurement Services", "url": "/services/consultancy-and-procurement" },
          { "id": 55, "title": "Real Estate", "url": "/services/real-estate" }
        ]
      },
      { "id": 56, "title": "Portfolio", "url": "/portfolio", "children": [] },
      { "id": 57, "title": "News", "url": "/news", "children": [] },
      { "id": 58, "title": "About Us", "url": "/about-us", "children": [] },
      { "id": 59, "title": "Contact Us", "url": "/contact-us", "children": [] }
    ],
    "footer_quick_links": [
      { "title": "About Company", "url": "/about-us" },
      { "title": "Our Services", "url": "/services" },
      { "title": "Our Projects", "url": "/portfolio" },
      { "title": "Pricing", "url": "/contact-us" },
      { "title": "Contacts", "url": "/contact-us" }
    ],
    "footer_client_support": [
      { "title": "Careers", "url": "/contact-us?subject=careers" },
      { "title": "Our Process", "url": "/about-us#our-process" },
      { "title": "FAQs", "url": "/about-us#faqs" },
      { "title": "Clients Testimonials", "url": "/#testimonials" },
      { "title": "Our Blog", "url": "/news" }
    ],
    "top_bar": [
      { "title": "Support", "url": "/contact-us" },
      { "title": "Partners", "url": "/about-us#partners" },
      { "title": "Careers", "url": "/contact-us?subject=careers" }
    ]
  },
  "settings": {
    "site_name": "Torre Tórò",
    "site_logo": "/storage/uploads/branding/logo.png",
    "site_logo_white": "/storage/uploads/branding/logo-white.png",
    "site_symbol": "/storage/uploads/branding/logo-symbol.png",
    "site_symbol_white": "/storage/uploads/branding/logo-symbol-white.png",
    "site_favicon": "/storage/uploads/branding/favicon.png",
    "site_video": "/storage/uploads/branding/corporate-logo.mp4",
    "tagline": "Designing Spaces that Inspire Success",
    "experience_years": "7+",
    "projects_count": "14",
    "stats_headline": "We Govern and Manage Place and Privacy policies",
    "header_cta_label": "Call Us Today",
    "header_phone": "+234 813 600 1221",
    "contact_phone": "+234 813 600 1221",
    "contact_phone_secondary": "+234 011 336 54",
    "contact_email": "hello@torretoro.com",
    "contact_email_secondary": "dami@torretoro.com",
    "office_address": "16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA",
    "office_hours": "Monday - Friday: 8:00 AM - 6:00 PM",
    "google_maps_embed": "https://www.google.com/maps/embed?pb=...",
    "google_maps_directions": "https://maps.google.com/?cid=13929622342407962470...",
    "copyright_text": "Torre Toro Projects © All rights reserved Copyrights 2025"
  }
}
```

---

### 3.2. Supported Domains
#### `GET /api/v1/domains`
Returns the list of enabled domains with their active codes and currencies.

#### Response Example (`200 OK`)
```json
{
  "data": [
    {
      "id": 1,
      "code": "global",
      "name": "Torre Tórò International (Nigeria & Global)",
      "currency": "NGN",
      "is_default": true
    },
    {
      "id": 2,
      "code": "uk",
      "name": "Torre Tórò UK",
      "currency": "GBP",
      "is_default": false
    }
  ]
}
```

---

### 3.3. Dynamic Pages with Modular Sections
#### `GET /api/v1/pages/{slug}`
Available page slugs:
* `home`
* `about-us`
* `contact-us`
* `services`
* `portfolio`

#### Response Example for `GET /api/v1/pages/home` (`200 OK`):
```json
{
  "data": {
    "id": 1,
    "title": "Home",
    "slug": "home",
    "subtitle": "Inspiring Success Through Commercial Interior Design",
    "hero_badge": "COMMERCIAL INTERIOR ARCHITECTURE",
    "hero_title": "Commercial Interior Design That Redefines Workplace Success",
    "hero_subtitle": "We are a commercial interior design company creating bespoke spaces that foster collaboration, enhance employee well-being, and elevate your brand identity.",
    "hero_image": "/storage/uploads/library/TorreToro_at_21.32.12_6d80d296.jpg",
    "meta_title": "Torre Tórò - Commercial Interior Architecture",
    "meta_description": "We are a commercial interior design company creating bespoke spaces...",
    "sections": {
      "hero": {
        "badge": "COMMERCIAL INTERIOR ARCHITECTURE",
        "title": "Commercial Interior Design That Redefines Workplace Success",
        "description": "We are a commercial interior design company creating bespoke spaces that foster collaboration, enhance employee well-being, and elevate your brand identity.",
        "image": "/storage/uploads/library/TorreToro_at_21.32.12_6d80d296.jpg",
        "video": "/storage/uploads/branding/corporate-logo.mp4",
        "cta_text": "Book a Consultation",
        "cta_link": "/contact-us",
        "secondary_cta_text": "View Our Portfolio",
        "secondary_cta_link": "/portfolio"
      },
      "stats": {
        "experience": "7+",
        "projects_count": "14",
        "headline": "We Govern and Manage Place and Privacy policies",
        "subheadline": "We believe our passion for precision and eye for elegance shines through in every piece we create."
      },
      "expertise": {
        "badge": "DESIGNING EXPERIENCES",
        "heading": "We Design Experiences That Last Beyond Work Hours",
        "subheading": "Every space tells a story. We make sure yours is one of innovation, comfort, and productivity.",
        "items": [
          {
            "title": "Functional Excellence",
            "description": "Seamless workflows tailored to your team's operational needs."
          },
          {
            "title": "Modern Biophilic Aesthetics",
            "description": "Infusing natural light, sustainable textures, and living elements into urban workspaces."
          },
          {
            "title": "Precision Execution",
            "description": "Turnkey fit-outs delivered on time, within budget, and to world-class standards."
          }
        ]
      },
      "about": {
        "badge": "ABOUT US",
        "heading": "A Legacy of Transforming Spaces",
        "description": "Torre Tórò is a premier commercial interior design firm specializing in turnkey workplace transformations across Nigeria and the United Kingdom.",
        "image": "/storage/uploads/library/TorreToro_at_21.32.13_7697106c.jpg"
      },
      "pillars": {
        "badge": "HOW WE WORK",
        "heading": "Our Architectural Pillars",
        "items": [
          { "step": "01", "title": "Discovery & Concept", "description": "Analyzing your culture, brand, and workflow requirements." },
          { "step": "02", "title": "Bespoke 3D Modeling", "description": "Photorealistic renders and material boards." },
          { "step": "03", "title": "Turnkey Fit-Out", "description": "End-to-end procurement, fabrication, and construction management." }
        ]
      },
      "projects_section": {
        "badge": "PORTFOLIO",
        "heading": "Crafted with Purpose, Designed to Last",
        "subheading": "Explore recent commercial interior transformations delivered for visionary enterprises."
      },
      "review": {
        "badge": "TESTIMONIALS",
        "heading": "Our Clients Say",
        "quote": "Torre Tórò transformed our Victoria Island workspace completely. Their attention to acoustic control and biophilic elements increased our staff satisfaction noticeably.",
        "client_name": "Executive Director",
        "client_role": "Facilities & Corporate Services",
        "client_company": "Sanlam Insurance Nigeria",
        "client_avatar": "/storage/uploads/library/TorreToro_at_21.32.14_814ea3b1.jpg",
        "rating": 5
      },
      "map": {
        "badge": "VISIT US",
        "heading": "Our Studio Headquarters",
        "address": "16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA",
        "embed_url": "https://www.google.com/maps/embed?pb=...",
        "directions_url": "https://maps.google.com/?cid=13929622342407962470..."
      },
      "bottom_video": {
        "title": "Experience Torre Tórò",
        "video_url": "/storage/uploads/branding/corporate-logo.mp4",
        "poster_image": "/storage/uploads/library/TorreToro_at_21.32.12_6d80d296.jpg"
      }
    },
    "domain": {
      "code": "global",
      "name": "Torre Tórò International (Nigeria & Global)",
      "phone": "+234 813 600 1221",
      "email": "hello@torretoro.com",
      "address": "16a Da Silva Street Lekki Phase 1, Lekki Lagos, NIGERIA",
      "currency": "NGN"
    }
  }
}
```

---

### 3.4. Services
#### `GET /api/v1/services`
Lists all active services ordered by sequence.

#### Response Example (`200 OK`):
```json
{
  "data": [
    {
      "id": 1,
      "title": "Commercial Architecture",
      "slug": "commercial-architecture",
      "subtitle": "Inspiring Spaces for Modern Enterprises",
      "excerpt": "Comprehensive architectural planning and structural design for corporate headquarters and modern offices.",
      "icon": "building",
      "thumbnail_image": "/storage/uploads/services/commercial-architecture.jpg",
      "banner_image": "/storage/uploads/services/commercial-architecture.jpg",
      "is_featured": true,
      "order": 1
    },
    {
      "id": 2,
      "title": "Commercial Interiors",
      "slug": "commercial-interiors",
      "subtitle": "Bespoke Workplace Design & Fit-Out",
      "excerpt": "Turnkey interior architecture, custom joinery, executive boardrooms, and ergonomic work environments.",
      "icon": "couch",
      "thumbnail_image": "/storage/uploads/services/commercial-interiors.jpg",
      "banner_image": "/storage/uploads/services/commercial-interiors.jpg",
      "is_featured": true,
      "order": 2
    }
  ]
}
```

#### `GET /api/v1/services/{slug}`
Retrieves detailed information for a single service, including its key feature bullets and 4 recommended other services.

* **Example Slug**: `commercial-interiors`
* **Response Body**:
```json
{
  "data": {
    "id": 2,
    "title": "Commercial Interiors",
    "slug": "commercial-interiors",
    "subtitle": "Bespoke Workplace Design & Fit-Out",
    "excerpt": "Turnkey interior architecture, custom joinery, executive boardrooms, and ergonomic work environments.",
    "description": "<p>Detailed description in HTML...</p>",
    "icon": "couch",
    "thumbnail_image": "/storage/uploads/services/commercial-interiors.jpg",
    "banner_image": "/storage/uploads/services/commercial-interiors.jpg",
    "features": [
      "Custom Executive Boardrooms & Audio-Visual Integration",
      "Acoustic Wall Paneling & Sound Dampening",
      "Biophilic Design & Natural Plant Integration",
      "Bespoke Reception Desks and Architectural Joinery"
    ],
    "is_featured": true
  },
  "other_services": [
    { "id": 1, "title": "Commercial Architecture", "slug": "commercial-architecture" },
    { "id": 3, "title": "Construction Consultancy", "slug": "construction-consultancy" }
  ]
}
```

---

### 3.5. Projects & Multi-Image Gallery
#### `GET /api/v1/projects`
Retrieves a paginated list of projects with category associations and counts.

* **Query Parameters**:
  * `category` (optional, string): Filter by category slug (e.g. `?category=commercial-interiors`).
  * `featured` (optional, boolean): Set to `1` or `true` for featured portfolio items (e.g. `?featured=1`).
  * `per_page` (optional, integer): Default `12`.
  * `page` (optional, integer): Pagination page number.

#### Response Example (`200 OK`):
```json
{
  "data": [
    {
      "id": 3,
      "title": "Sanlam Insurance V.I. Lagos",
      "slug": "sanlam-insurance",
      "client_name": "Sanlam Insurance Group",
      "location": "Victoria Island, Lagos, Nigeria",
      "year": "2024",
      "services_rendered": "Commercial Interior Design & Turnkey Fit-Out",
      "excerpt": "Where Heritage Meets Modern Vision — A state-of-the-art corporate boardroom, executive offices, and collaborative workstations.",
      "thumbnail_image": "/storage/uploads/projects/sanlam-insurance-1.jpg",
      "banner_image": "/storage/uploads/projects/sanlam-insurance-1.jpg",
      "gallery_images": [
        { "url": "/storage/uploads/projects/sanlam-insurance-1.jpg", "caption": "Executive Boardroom" },
        { "url": "/storage/uploads/projects/sanlam-insurance-2.jpg", "caption": "Collaborative Lounge" }
      ],
      "gallery_urls": [
        "/storage/uploads/projects/sanlam-insurance-1.jpg",
        "/storage/uploads/projects/sanlam-insurance-2.jpg"
      ],
      "stats": {
        "area": "15,000 sq ft",
        "timeline": "16 weeks",
        "capacity": "250 workstations"
      },
      "is_featured": true,
      "category": {
        "id": 2,
        "name": "Commercial Interiors",
        "slug": "commercial-interiors"
      }
    }
  ],
  "categories": [
    { "id": 1, "name": "Commercial Architecture", "slug": "commercial-architecture", "projects_count": 4 },
    { "id": 2, "name": "Commercial Interiors", "slug": "commercial-interiors", "projects_count": 8 }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 2,
    "total": 14
  }
}
```

#### `GET /api/v1/projects/{slug}`
Retrieves a project by slug with its rich multi-image gallery, stats, and 3 related projects in the same category.

* **Example Slug**: `sanlam-insurance`
* **Response Body**:
```json
{
  "data": {
    "id": 3,
    "title": "Sanlam Insurance V.I. Lagos",
    "slug": "sanlam-insurance",
    "client_name": "Sanlam Insurance Group",
    "location": "Victoria Island, Lagos, Nigeria",
    "year": "2024",
    "services_rendered": "Commercial Interior Design & Turnkey Fit-Out",
    "excerpt": "Where Heritage Meets Modern Vision...",
    "description": "<p>Completed on June 19, 2024, Sanlam Insurance entrusted Torre Tórò...</p>",
    "thumbnail_image": "/storage/uploads/projects/sanlam-insurance-1.jpg",
    "banner_image": "/storage/uploads/projects/sanlam-insurance-1.jpg",
    "gallery_images": [
      {
        "url": "/storage/uploads/projects/sanlam-insurance-1.jpg",
        "caption": "Executive Boardroom"
      },
      {
        "url": "/storage/uploads/projects/sanlam-insurance-2.jpg",
        "caption": "Collaborative Open Space"
      }
    ],
    "gallery_urls": [
      "/storage/uploads/projects/sanlam-insurance-1.jpg",
      "/storage/uploads/projects/sanlam-insurance-2.jpg"
    ],
    "stats": {
      "area": "15,000 sq ft",
      "timeline": "16 weeks",
      "capacity": "250 workstations"
    },
    "is_featured": true,
    "category": {
      "id": 2,
      "name": "Commercial Interiors",
      "slug": "commercial-interiors"
    }
  },
  "related_projects": [
    {
      "id": 7,
      "title": "ShoeLab HQ Lekki",
      "slug": "shoelab-hq",
      "thumbnail_image": "/storage/uploads/projects/shoelab-1.jpg",
      "gallery_urls": ["/storage/uploads/projects/shoelab-1.jpg", "/storage/uploads/projects/shoelab-2.jpg"]
    }
  ]
}
```

---

### 3.6. Blog & News Posts
#### `GET /api/v1/posts`
* **Query Parameters**:
  * `category` (optional, string): Category slug (e.g. `?category=interior-trends`).
  * `per_page` (optional, integer): Default `9`.
  * `page` (optional, integer).

#### `GET /api/v1/posts/{slug}`
Retrieves a single blog article and 3 recent posts.

#### Response Body:
```json
{
  "data": {
    "id": 1,
    "title": "How Biophilic Office Architecture Elevates Productivity",
    "slug": "biophilic-office-architecture-productivity",
    "excerpt": "Discover how natural daylight, live plants, and organic wood textures drive measurable gains in employee focus.",
    "content": "<p>Full article rich text HTML content...</p>",
    "featured_image": "/storage/uploads/posts/biophilic-design.jpg",
    "author_name": "Torre Tórò Editorial",
    "read_time": "4 min read",
    "published_at": "2026-10-20T10:00:00.000000Z",
    "category": {
      "id": 1,
      "name": "Design Trends",
      "slug": "design-trends"
    }
  },
  "recent_posts": [
    {
      "id": 2,
      "title": "Designing Sustainable Executive Boardrooms for 2026",
      "slug": "sustainable-boardrooms-2026",
      "featured_image": "/storage/uploads/posts/boardroom-design.jpg",
      "published_at": "2026-10-15T09:00:00.000000Z"
    }
  ]
}
```

---

### 3.7. Testimonials
#### `GET /api/v1/testimonials`
Retrieves featured customer testimonials.

#### Response Example (`200 OK`):
```json
{
  "data": [
    {
      "id": 1,
      "client_name": "Tunde Adeyemi",
      "client_role": "Chief Operations Officer",
      "company_name": "Sanlam Insurance Group",
      "quote": "Torre Tórò delivered our Victoria Island office on time and with exceptional craftsmanship. Our employees love the vibrant, biophilic work environment.",
      "avatar_image": "/storage/uploads/testimonials/avatar-1.jpg",
      "rating": 5,
      "is_featured": true
    }
  ]
}
```

---

### 3.8. Submitting Inquiries & Consultations
#### `POST /api/v1/inquiries`
Allows website visitors to submit contact messages, request consultations, or book appointments.

* **Headers**:
  * `Content-Type: application/json`
  * `Accept: application/json`
  * `X-Domain: [global|uk]` (optional)

* **Request Body JSON**:
```json
{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "phone": "+234 801 234 5678",
  "company": "Acme Capital",
  "type": "consultation",
  "service_requested": "Commercial Interiors Fit-Out",
  "message": "We are relocating to a 10,000 sq ft office in Lekki Phase 1 and require a comprehensive turnkey design and fit-out proposal.",
  "preferred_date": "2026-11-15"
}
```

* **Validation Rules**:
  * `name`: **Required**, string, max 255 chars.
  * `email`: **Required**, valid email address, max 255 chars.
  * `phone`: Optional, string, max 50 chars.
  * `company`: Optional, string, max 255 chars.
  * `type`: Optional, one of: `general_contact`, `expert_appointment`, `consultation` (default: `general_contact`).
  * `service_requested`: Optional, string, max 255 chars.
  * `message`: Optional, string, max 5000 chars.
  * `preferred_date`: Optional, string, max 50 chars.

#### Success Response (`201 Created`):
```json
{
  "message": "Inquiry received successfully. Our team will contact you shortly.",
  "data": {
    "id": 12,
    "domain_id": 1,
    "name": "Jane Doe",
    "email": "jane@example.com",
    "phone": "+234 801 234 5678",
    "company": "Acme Capital",
    "type": "consultation",
    "service_requested": "Commercial Interiors Fit-Out",
    "message": "We are relocating to a 10,000 sq ft office...",
    "preferred_date": "2026-11-15",
    "status": "new",
    "created_at": "2026-10-27T14:30:00.000000Z",
    "updated_at": "2026-10-27T14:30:00.000000Z"
  }
}
```

#### Validation Error Response (`422 Unprocessable Content`):
```json
{
  "message": "The email field is required. (and 1 more error)",
  "errors": {
    "email": ["The email field must be a valid email address."],
    "type": ["The selected type is invalid."]
  }
}
```

---

## 4. Ready-to-Use Frontend TypeScript Integration Client

Create a file named `lib/api.ts` (or `src/services/api.ts`) in the frontend application:

```typescript
/**
 * Torre Tórò API Client
 * Compatible with Next.js (App Router / Pages), Nuxt, React, Vue, and Node.js
 */

const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://127.0.0.1:8000';

export type DomainCode = 'global' | 'uk';

export interface DomainInfo {
  code: DomainCode;
  name: string;
  currency: string;
  phone: string;
  phone_1: string;
  phone_2: string;
  phone_secondary: string;
  email: string;
  email_1: string;
  email_2: string;
  email_secondary: string;
  address: string;
  social_links: Record<string, string>;
  meta_title: string;
  meta_description: string;
}

export interface MenuItem {
  id: number;
  title: string;
  url: string;
  target?: string;
  children?: MenuItem[];
}

export interface SiteSettings {
  site_name: string;
  site_logo: string;
  site_logo_white: string;
  site_symbol: string;
  site_symbol_white: string;
  site_favicon: string;
  site_video: string;
  tagline: string;
  experience_years: string;
  projects_count: string;
  stats_headline: string;
  header_cta_label: string;
  header_phone: string;
  contact_phone: string;
  contact_phone_secondary: string;
  contact_email: string;
  contact_email_secondary: string;
  office_address: string;
  office_hours: string;
  google_maps_embed: string;
  google_maps_directions: string;
  copyright_text: string;
}

export interface ConfigResponse {
  domain: DomainInfo;
  menus: {
    header: MenuItem[];
    footer_quick_links: MenuItem[];
    footer_client_support: MenuItem[];
    top_bar: MenuItem[];
  };
  settings: SiteSettings;
}

export interface GalleryItem {
  url: string;
  caption: string;
}

export interface Project {
  id: number;
  title: string;
  slug: string;
  client_name?: string;
  location?: string;
  year?: string;
  services_rendered?: string;
  excerpt?: string;
  description?: string;
  thumbnail_image?: string;
  banner_image?: string;
  gallery_images: GalleryItem[];
  gallery_urls: string[];
  stats?: Record<string, string>;
  is_featured: boolean;
  category?: {
    id: number;
    name: string;
    slug: string;
  };
}

export interface Service {
  id: number;
  title: string;
  slug: string;
  subtitle?: string;
  excerpt?: string;
  description?: string;
  icon?: string;
  thumbnail_image?: string;
  banner_image?: string;
  features?: string[];
  is_featured: boolean;
}

export interface InquiryPayload {
  name: string;
  email: string;
  phone?: string;
  company?: string;
  type?: 'general_contact' | 'expert_appointment' | 'consultation';
  service_requested?: string;
  message?: string;
  preferred_date?: string;
}

/**
 * Resolves relative asset URLs (e.g. /storage/uploads/...) to absolute URLs
 */
export function resolveAssetUrl(path?: string | null): string {
  if (!path) return '';
  if (path.startsWith('http://') || path.startsWith('https://')) return path;
  const cleanPath = path.startsWith('/') ? path : `/${path}`;
  return `${API_BASE_URL}${cleanPath}`;
}

/**
 * Core Fetch Wrapper supporting multi-domain switching
 */
async function fetchApi<T>(endpoint: string, domain: DomainCode = 'global', options: RequestInit = {}): Promise<T> {
  const url = `${API_BASE_URL}/api/v1${endpoint.startsWith('/') ? endpoint : `/${endpoint}`}`;

  const headers: Record<string, string> = {
    'Accept': 'application/json',
    'X-Domain': domain,
    ...((options.headers as Record<string, string>) || {}),
  };

  const response = await fetch(url, {
    ...options,
    headers,
  });

  if (!response.ok) {
    let errorBody: any = null;
    try {
      errorBody = await response.json();
    } catch {
      // ignore
    }
    const error: any = new Error(errorBody?.message || `API error ${response.status}: ${response.statusText}`);
    error.status = response.status;
    error.errors = errorBody?.errors;
    throw error;
  }

  return response.json();
}

export const api = {
  // Config & Domains
  getConfig: (domain: DomainCode = 'global') => 
    fetchApi<ConfigResponse>('/config', domain),

  getDomains: () => 
    fetchApi<{ data: Array<{ id: number; code: DomainCode; name: string; currency: string; is_default: boolean }> }>('/domains'),

  // Dynamic Pages
  getPage: (slug: string, domain: DomainCode = 'global') => 
    fetchApi<{ data: any }>(`/pages/${slug}`, domain),

  // Services
  getServices: (domain: DomainCode = 'global') => 
    fetchApi<{ data: Service[] }>('/services', domain),

  getService: (slug: string, domain: DomainCode = 'global') => 
    fetchApi<{ data: Service; other_services: Service[] }>(`/services/${slug}`, domain),

  // Projects
  getProjects: (params: { category?: string; featured?: boolean; page?: number; per_page?: number } = {}, domain: DomainCode = 'global') => {
    const query = new URLSearchParams();
    if (params.category) query.set('category', params.category);
    if (params.featured) query.set('featured', '1');
    if (params.page) query.set('page', params.page.toString());
    if (params.per_page) query.set('per_page', params.per_page.toString());
    const queryString = query.toString() ? `?${query.toString()}` : '';
    return fetchApi<{ data: Project[]; categories: any[]; pagination: any }>(`/projects${queryString}`, domain);
  },

  getProject: (slug: string, domain: DomainCode = 'global') => 
    fetchApi<{ data: Project; related_projects: Project[] }>(`/projects/${slug}`, domain),

  // Posts
  getPosts: (params: { category?: string; page?: number; per_page?: number } = {}, domain: DomainCode = 'global') => {
    const query = new URLSearchParams();
    if (params.category) query.set('category', params.category);
    if (params.page) query.set('page', params.page.toString());
    if (params.per_page) query.set('per_page', params.per_page.toString());
    const queryString = query.toString() ? `?${query.toString()}` : '';
    return fetchApi<{ data: any[]; categories: any[]; pagination: any }>(`/posts${queryString}`, domain);
  },

  getPost: (slug: string, domain: DomainCode = 'global') => 
    fetchApi<{ data: any; recent_posts: any[] }>(`/posts/${slug}`, domain),

  // Testimonials
  getTestimonials: (domain: DomainCode = 'global') => 
    fetchApi<{ data: any[] }>('/testimonials', domain),

  // Inquiries
  sendInquiry: (payload: InquiryPayload, domain: DomainCode = 'global') => 
    fetchApi<{ message: string; data: any }>('/inquiries', domain, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    }),
};
```

---

## 5. Next.js 14 / 15 Integration Example

### Global Layout (`app/[domain]/layout.tsx`)
```tsx
import { api, resolveAssetUrl, DomainCode } from '@/lib/api';
import Image from 'next/image';
import Link from 'next/link';

export default async function DomainLayout({
  children,
  params,
}: {
  children: React.ReactNode;
  params: Promise<{ domain: DomainCode }>;
}) {
  const { domain } = await params;
  const config = await api.getConfig(domain);

  return (
    <html lang="en">
      <body>
        <header className="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-stone-200">
          <div className="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            {/* Logo */}
            <Link href={`/${domain}`}>
              <img
                src={resolveAssetUrl(config.settings.site_logo)}
                alt={config.settings.site_name}
                className="h-10 w-auto object-contain"
              />
            </Link>

            {/* Navigation */}
            <nav className="hidden md:flex items-center gap-8 text-sm font-medium">
              {config.menus.header.map((item) => (
                <Link key={item.id} href={`/${domain}${item.url}`} className="hover:text-amber-800 transition">
                  {item.title}
                </Link>
              ))}
            </nav>

            {/* Direct CTA with verified business phone */}
            <a
              href={`tel:${config.domain.phone.replace(/\s+/g, '')}`}
              className="bg-stone-900 text-white px-5 py-2.5 rounded-full text-xs font-semibold tracking-wider hover:bg-stone-800 transition"
            >
              {config.settings.header_cta_label || 'Call Us'}: {config.domain.phone}
            </a>
          </div>
        </header>

        <main>{children}</main>

        <footer className="bg-stone-950 text-stone-300 py-16">
          <div className="max-w-7xl mx-auto px-6">
            <p className="text-xs text-stone-500">{config.settings.copyright_text}</p>
          </div>
        </footer>
      </body>
    </html>
  );
}
```

---

## 6. Testing Endpoints from Terminal

You can test any endpoint instantly with `curl` or PowerShell:

### Test Site Config (Global)
```bash
curl -s -H "Accept: application/json" -H "X-Domain: global" http://127.0.0.1:8000/api/v1/config | jq .domain
```

### Test Site Config (UK)
```bash
curl -s -H "Accept: application/json" -H "X-Domain: uk" http://127.0.0.1:8000/api/v1/config | jq .domain
```

### Test Project Gallery (Sanlam Insurance)
```bash
curl -s http://127.0.0.1:8000/api/v1/projects/sanlam-insurance | jq .data.gallery_images
```

### Test Submitting an Inquiry
```bash
curl -X POST http://127.0.0.1:8000/api/v1/inquiries \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-Domain: global" \
  -d '{
    "name": "Frontend Tester",
    "email": "test@example.com",
    "phone": "+234 813 600 1221",
    "type": "consultation",
    "message": "Testing inquiry API connection"
  }'
```
