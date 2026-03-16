<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Livewire-3-4E56A6?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 3">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Pest-4-F9322C?style=for-the-badge" alt="Pest 4">
</p>

# 🎫 EventFlow — Event Management Platform

**A production-ready Laravel 12 event management template with ticketing, check-ins, analytics, and multi-role access control.**

EventFlow gives you a complete, modern event platform out of the box — ready to customize, extend, and deploy. Built with Laravel 12, Livewire 3, and Tailwind CSS, it's designed for marketplaces, client projects, and SaaS MVPs.

---

## ✨ What's Included

| Area | Highlights |
|------|------------|
| **Public Experience** | Landing page, event discovery with filters, event detail pages, ticket checkout, order confirmation |
| **Organizer Dashboard** | Create/edit/duplicate/archive events, manage categories & tags, SEO fields, venue assignment |
| **Ticketing System** | Multi-tier pricing (free & paid), per-order limits, promo codes (fixed & percentage), QR code generation |
| **Staff Check-Ins** | Ticket validation via code, cryptographic QR signature verification, manual override with audit trail |
| **Analytics Dashboard** | Revenue tracking, tickets sold, event performance, capacity metrics |
| **Attendee Features** | Favorite events, purchase history, order tracking |
| **Authentication** | Registration, login, email verification, profile management, password reset |
| **Roles & Permissions** | Super Admin · Organizer · Staff · Attendee — powered by Spatie Permission |
| **Localization** | English, French, Arabic support with session-based switching |
| **Demo Data** | Realistic seeders with users, venues, events, tickets, and orders — ready to explore |

---

## 🖥️ Screenshots

> Replace the placeholders below with your own screenshots before publishing your listing.

| Landing Page | Event Discovery | Event Detail |
|:---:|:---:|:---:|
| *screenshot* | *screenshot* | *screenshot* |

| Checkout Flow | Organizer Dashboard | Analytics |
|:---:|:---:|:---:|
| *screenshot* | *screenshot* | *screenshot* |

---

## 🧱 Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | **Laravel 12** · PHP 8.2+ |
| Frontend | **Livewire 3** · **Volt** · **Tailwind CSS** · **Vite** |
| Auth & Roles | **Laravel Breeze** · **Spatie Laravel Permission** |
| Ticketing | **Simple QR Code** (QR generation) · **HMAC-SHA256** (ticket signature) |
| Exports | **Laravel DomPDF** (PDF) · **Maatwebsite Excel** (spreadsheets) |
| Testing | **Pest 4** · 27 tests · 90 assertions |

---

## ⚙️ Installation

### Requirements

- PHP 8.2+
- Composer 2.x
- Node.js 18+ & npm
- MySQL 8+ / MariaDB 10.6+ / SQLite

### Quick Setup

```bash
git clone <your-repository-url> eventflow
cd eventflow
composer run setup
```

The `setup` script will install dependencies, configure `.env`, generate the app key, run migrations + seeders, and build frontend assets.

### Manual Setup

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Configure database in .env, then:
php artisan migrate --seed

# 4. Build assets
npm run build
```

### Start Development Server

```bash
composer run dev
```

---

## 🔑 Demo Accounts

After running `php artisan migrate --seed`, these accounts are available:

| Role | Email | Password |
|------|-------|----------|
| **Super Admin** | `admin@eventflow.test` | `password` |
| **Organizer** | `organizer1@eventflow.test` | `password` |
| **Organizer** | `organizer2@eventflow.test` | `password` |
| **Staff** | `staff@eventflow.test` | `password` |
| **Attendee** | `attendee@eventflow.test` | `password` |
| **Attendee** | `buyer@eventflow.test` | `password` |

### Demo Data Included

- **6 users** across all roles
- **5 published events** (Tech Conference, UX Workshop, Networking Mixer, Wellness Summit, Marketing Masterclass)
- **5 venues** (San Francisco, New York, Los Angeles, Austin, Virtual)
- **10 categories** · **15 tags**
- **13 ticket types** with realistic pricing ($0–$799)
- **3 paid orders** with generated tickets and QR signatures

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/          # 7 controllers (Dashboard, Events, Checkout, Analytics, Check-ins, Favorites, Public)
│   ├── Middleware/            # Locale middleware (en/fr/ar)
│   └── Requests/             # Form validation (Checkout, StoreEvent, UpdateEvent)
├── Models/                   # 10 Eloquent models with relationships
├── Policies/                 # EventPolicy (role-based authorization)
└── Support/                  # TicketQrSigner (HMAC-SHA256 verification)

database/
├── migrations/               # 14 migrations (users, events, tickets, orders, promo codes, check-ins…)
└── seeders/                  # 8 seeders (roles, users, venues, categories, tags, events, tickets, orders)

resources/views/
├── welcome.blade.php         # Landing page
├── dashboard.blade.php       # Role-aware dashboard
├── public/                   # Event discovery, detail, checkout, confirmation
├── events/                   # Organizer CRUD (create, edit, index)
├── dashboard/                # Analytics, check-ins
├── layouts/                  # App & guest layouts
├── components/               # Reusable Blade components
└── livewire/                 # Volt components (auth, profile, dashboard)
```

---

## 🧪 Testing

```bash
# Run all tests
php artisan test --compact

# Filter by name
php artisan test --filter=CheckoutTest
```

**27 tests · 90 assertions** — covering authentication, event management, checkout flow, role-based access, and seeder validation.

---

## 🛠️ Development Commands

| Command | Purpose |
|---------|---------|
| `composer run dev` | Start dev server + Vite watcher |
| `npm run build` | Build production assets |
| `php artisan test --compact` | Run test suite |
| `vendor/bin/pint --dirty` | Format modified PHP files |
| `php artisan migrate:fresh --seed` | Reset database with demo data |

---

## 🗄️ Database Schema

14 tables designed for a real-world event management workflow:

```
users ─────────────── events ────────────── ticket_types
                        │                       │
                        ├── event_category       │
                        ├── event_tag            │
                        ├── event_likes      orders
                        │                       │
                      venues               order_items
                                                │
                      promo_codes            tickets
                                                │
                                            check_ins
```

**Key design decisions:**
- Prices stored in **smallest currency unit** (cents) for precision
- Tickets signed with **HMAC-SHA256** for tamper-proof QR verification
- **Soft role separation** — same User model, different capabilities per role
- **SEO-friendly slugs** with auto-increment collision handling
- **Timezone-aware** event scheduling with per-event timezone support

---

## 🎯 Use Cases

EventFlow is a strong fit for:

- 🎪 **Event marketplace** — public discovery + ticketed checkout
- 🎤 **Conference platform** — multi-track events with tiered tickets
- 🧑‍🏫 **Workshop booking** — small events with capacity limits
- 🏢 **Corporate event portal** — organizer dashboards + analytics
- 🎟️ **Ticketing SaaS MVP** — extend with Stripe/PayPal for production payments

---

## 🔌 Ready to Extend

The template is designed to be easily customized:

| Extension Point | How |
|-----------------|-----|
| **Payment gateway** | Replace the `fake` provider in `CheckoutController` with Stripe, PayPal, or any PSP |
| **Email notifications** | Add Laravel Notifications for order confirmation, event reminders |
| **PDF tickets** | `pdf_path` column + DomPDF already installed — generate downloadable tickets |
| **Excel exports** | Maatwebsite Excel already installed — export orders, attendee lists |
| **Seat maps** | `seat_maps`, `seat_sections`, `seats` tables already migrated |
| **API endpoints** | Add API routes with Laravel Sanctum for mobile apps |
| **Additional languages** | Add translation files in `lang/` directory |

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

<p align="center">
  Built with ❤️ using <strong>Laravel 12</strong> · <strong>Livewire 3</strong> · <strong>Tailwind CSS</strong>
</p>

Current verified status in this workspace:

- Frontend assets build successfully with `npm run build`
- Test suite passes with `php artisan test --compact`
- Code formatting passes with Laravel Pint

## Notes For Buyers

- This project ships as a starter template, not as a hosted SaaS service
- Payment gateway integration can be added based on buyer needs
- Email notifications, invoice generation, and PDF export can be expanded further if needed
- Queue workers should be configured in production for heavier workloads

## Commercial Packaging Checklist

Before listing it for sale, make sure your marketplace package includes:

- Source code
- Setup instructions
- `.env.example`
- Database migration files
- Compiled screenshots for the listing page
- A buyer support policy
- Version/update policy

## Support

If you sell this template commercially, it is recommended to define clearly:

- What is included in support
- Whether installation support is included
- Whether customization is included or billed separately
- How long updates will be provided

## License

Set the license according to your commercial distribution model before publishing.

If you are selling on a marketplace, include the correct buyer license terms in the final package.
