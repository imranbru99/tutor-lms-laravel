# TutorForge — Enterprise AI-Powered Learning Management System

<p align="center">
  <img src="https://raw.githubusercontent.com/imranbru99/laravel-admin-panel/main/art/banner.svg" alt="TutorForge Banner" width="100%" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
</p>

<p align="center">
  <strong>A Production-Grade, Multi-Tenant LMS Re-architecting Tutor LMS (v4.x) natively for Laravel.</strong><br>
  <em>Featuring an Agentic AI Studio, Complete Global & Bangladesh Payment Gateway Layer, Multi-Panel Administration, and Native Bengali-First Unicode Localization.</em>
</p>

<p align="center">
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.3%2B-777bb4.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.3+"></a>
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12.x-ff2d20.svg?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12"></a>
  <a href="https://livewire.laravel.com"><img src="https://img.shields.io/badge/Livewire-3.x-fb70a9.svg?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 3"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind-CSS%204-38bdf8.svg?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4"></a>
  <a href="https://phpstan.org"><img src="https://img.shields.io/badge/Larastan-Level%208-brightgreen.svg?style=for-the-badge" alt="Larastan Level 8"></a>
  <a href="https://pestphp.com"><img src="https://img.shields.io/badge/Pest-3.x-ff4088.svg?style=for-the-badge" alt="Pest 3"></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge" alt="MIT License"></a>
</p>

---

## 📖 Table of Contents

- [Vision & Architecture](#-vision--architecture)
- [Primary Technology Stack](#-primary-technology-stack)
- [Proprietary & Mandatory Packages](#-proprietary--mandatory-packages)
- [Complete Feature Matrix](#-complete-feature-matrix)
  - [1. Course Creation & Curriculum Builder](#1-course-creation--curriculum-builder)
  - [2. Learner Experience & Continuous Player](#2-learner-experience--continuous-player)
  - [3. Assessment & 13+ Question Quiz Engine](#3-assessment--13-question-quiz-engine)
  - [4. Monetization & Native eCommerce](#4-monetization--native-ecommerce)
  - [5. Complete Payment Gateway Layer (Global & Bangladesh)](#5-complete-payment-gateway-layer-global--bangladesh)
  - [6. Deep Agentic AI Layer (20+ Features)](#6-deep-agentic-ai-layer-20-features)
  - [7. Triple Admin Panel System](#7-triple-admin-panel-system)
  - [8. Multilingual, Unicode & Bengali-First Engineering](#8-multilingual-unicode--bengali-first-engineering)
  - [9. Gamification, Certifications & Social Engagement](#9-gamification-certifications--social-engagement)
  - [10. Security, Content Protection & Zero-Trust RBAC](#10-security-content-protection--zero-trust-rbac)
- [Directory & Domain Structure](#-directory--domain-structure)
- [Database Schema & Data Model](#-database-schema--data-model)
- [Getting Started & Installation](#-getting-started--installation)
  - [Standard Local Setup](#standard-local-setup)
  - [Dockerized Environment](#dockerized-environment)
- [Demo Credentials](#-demo-credentials)
- [Testing & Quality Gates](#-testing--quality-gates)
- [Continuous Integration (CI/CD)](#-continuous-integration-cicd)
- [License](#-license)

---

## 🎯 Vision & Architecture

**TutorForge** breaks the dependency on WordPress, WooCommerce, and plugin bloat by reimagining **Tutor LMS (v4.x)** as a standalone, high-concurrency Laravel enterprise application. 

### Core Architectural Tenets:
1. **Zero-WordPress Dependency:** Native Eloquent models, Actions, DTOs, and clean event-driven architecture.
2. **Domain-Driven Action Pattern:** Business logic resides strictly in `app/Actions/<Domain>/<Action>.php`, not controllers or views.
3. **Integer Minor Units for Financial Safety:** Zero float rounding bugs. Every monetary transaction operates with minor units (paisa/cents) and ISO 4217 currency codes wrapped in a robust `Money` value object.
4. **Idempotency Everywhere:** Database unique constraints, transactional row locks, and signed webhook deduplication.
5. **Zero N+1 Database Queries:** Strict model configurations (`Model::preventLazyLoading()`) enforce query budgets on production-scale catalogs and course players.
6. **Bengali-First Unicode Native:** Non-latin alphabets (বাংলা, العربية) are first-class citizens in URL slugs, PDF certificate rendering, and localized numerals.

---

## 🛠 Primary Technology Stack

- **Framework:** Laravel 12.x (compatible with 11.x & 13.x), PHP 8.3+
- **Frontend (Learner Portal):** Blade + Livewire 3 + Alpine.js + Tailwind CSS 4 (`wire:navigate` SPA feel)
- **Administration:** `imrandevbd/laravel-admin-panel` (Zero-build, Alpine.js 3, Tailwind, multi-panel engine)
- **Database:** MySQL 8.0 (PostgreSQL-compatible schema) with SQLite in-memory test driver
- **Caching & Locks:** Redis 7.x (tag-based cache invalidation, queue workers, atomic locks)
- **Full-Text Search:** Laravel Scout with Meilisearch (typo-tolerant Bengali & English search)
- **Queues & Scheduling:** Laravel Horizon with dedicated queues (`payments`, `emails`, `ai`, `pdf`, `media`, `default`)
- **Realtime Events:** Laravel Reverb (WebSockets for notifications, live Q&A, and attendance)
- **Static Analysis & Testing:** Pest 3, Larastan Level 8, Laravel Pint, GitHub Actions CI

---

## 📦 Proprietary & Mandatory Packages

TutorForge is built on top of four specialized packages engineered by the author:

| Package | Version | Purpose & Integration |
|---|:---:|---|
| **`imrandevbd/laravel-admin-panel`** | `dev-main` | Powers the entire administrative suite across three isolated panels (`/admin`, `/instructor`, `/org`) with 8 WCAG 2.2 palettes, WebAuthn passkeys, and zero-build architecture. |
| **`imrandevbd/laravel-ai-hub`** | `^1.6` | Powers all generative and agentic workflows (OpenAI, Gemini, Claude, Ollama, Groq, DeepSeek) through a centralized, rate-limited `AiGateway`. |
| **`imrandevbd/laravel-unicode-pdf`** | `dev-main` | Produces landscape A4 completion certificates, tax invoices, and transcripts with native SIL OFL Noto Sans Bengali font shaping. |
| **`imrandevbd/laravel-universal-slug`** | `dev-main` | Preserves native Unicode characters in public URLs (e.g., `/courses/লার্যাভেল-মাস্টারক্লাস`) and maintains an automatic 301 redirect history. |

*Detailed gap analyses and adapter bridges are documented in [`docs/PACKAGE_GAPS.md`](file:///c:/docker/tutor-lms-laravel/docs/PACKAGE_GAPS.md).*

---

## 🚀 Complete Feature Matrix

### 1. Course Creation & Curriculum Builder
- **Three-Pane Visual Course Builder:** Drag-and-drop curriculum tree (topics, lessons, quizzes, assignments, live classes) powered by Alpine.js + SortableJS with optimistic UI and conflict resolution.
- **Content Bank (Reusable Assets):** Central repository of reusable lessons, question pools, and assignments across multiple courses (copy-by-reference or copy-by-value).
- **Rich Course Attributes:** Title, multilingual descriptions, intro video (YouTube, Vimeo, Bunny.net Stream, self-hosted signed URLs), difficulty levels, duration, seat caps, FAQs, prerequisites, and drip schedules.
- **Multi-Instructor Support:** Primary instructor with revenue sharing, plus co-instructors with granular permissions.
- **Import/Export Engine:** JSON/ZIP course bundles with media manifests; migration wizards for **Tutor LMS (WordPress)**, LearnDash, and LifterLMS.

### 2. Learner Experience & Continuous Player
- **Continuous Dashboard Learning Player:** Mobile-first, distraction-free player with collapsible sidebar, video progress resume, keyboard shortcuts (`Space`, `N`, `P`), and offline-safe queueing via IndexedDB.
- **Two Distinct Learning Modes:**
  - **Modern Mode:** Clean, sleek, high-productivity interface with dark/light themes.
  - **Kids Mode:** Gamified UI with enlarged typography, friendly mascot animations, simplified navigation, and guardian progress monitoring.
- **Rich Lesson Types:** TipTap rich-text, self-hosted protected video, audio lectures, PDF slides viewer, and downloadable resources.
- **Interactive Study Tools:** Highlight-to-note with video timestamp bookmarks, personal study guides, and lesson discussion threads.

### 3. Assessment & 13+ Question Quiz Engine
Strategy-pattern question engine (`App\Domain\Quizzes\QuestionType`) supporting 13+ question formats:
1. Single Choice
2. Multiple Choice (Multi-select)
3. True / False
4. Short Answer
5. Fill in the Blanks
6. Open-Ended Essay (with AI Rubric Auto-Grading)
7. Matching Pairs
8. Sequence / Ordering
9. Image Answering
10. Image Matching
11. **Image Marking / Pin-on-Image**
12. **Puzzle / Ordering Grid**
13. **Graph / Range / Slider**
- **Advanced Scoring:** Negative marking, partial credits, question bank randomizer pools, time limits, tab-blur cheat detection, and detailed item discrimination analytics.

### 4. Monetization & Native eCommerce
- **No WooCommerce Required:** Fully native carts, single-step checkouts, and multi-currency orders.
- **Diverse Revenue Models:**
  - **Single Course Purchase:** Lifetime access or expiring enrollment windows.
  - **Course Bundles:** Multi-course learning paths with bundle pricing.
  - **Recurring Subscriptions:** Weekly, monthly, and annual billing with trial periods, proration, grace periods, and dunning cycles.
  - **Membership Tiers:** Tiered catalog access (Basic, Plus, Pro) with automated course entitlement resolution.
  - **B2B Seat Licenses:** Organizations purchase bulk seat blocks with student assignment/unassignment portals.
  - **Installment Plans:** Split payments for high-ticket bootcamps.
- **Dynamic Coupons & Affiliates:** Percentage or flat discounts, user/course constraints, referral URL tracking, and affiliate commission ledgers.

### 5. Complete Payment Gateway Layer (Global & Bangladesh)
Built on a driver-based architecture (`App\Domain\Payments\PaymentGateway`) with server-side verification, signed webhook replay-protection, and idempotency:

| Region | Supported Gateways | Capabilities |
|---|---|---|
| **Global Cards & Wallets** | **Stripe** (Checkout, Elements, Billing, Connect)<br>**PayPal** (Orders v2, Subscriptions)<br>**Paddle**<br>**Razorpay**<br>**Mollie**<br>**Paystack**<br>**Flutterwave**<br>**Authorize.net** | Cards, Apple Pay, Google Pay, recurring subscriptions, instant refunds, automated payouts. |
| **Bangladesh (Native)** | **bKash** (Tokenized Checkout & Recurring Agreements)<br>**Nagad**<br>**Rocket**<br>**SSLCommerz**<br>**aamarPay**<br>**ShurjoPay**<br>**UpayPay** | MFS payments, tokenized recurring billing, automated IPN verification, local currency settlements. |
| **Offline & Manual** | **Bank Wire Transfer**<br>**Cash on Delivery**<br>**Manual Mobile Money (TrxID + Receipt Proof)** | Admin verification queue, receipt proof upload, automated enrollment activation upon approval. |

### 6. Deep Agentic AI Layer (20+ Features)
Powered by `imrandevbd/laravel-ai-hub` and coordinated through `App\Services\Ai\AiGateway`:
1. **Course Outline Generator:** Produces pedagogical curricula based on topic, audience, and duration.
2. **End-to-End Course Authoring:** Generates lesson outlines, quiz drafts, assignments, FAQs, and thumbnail prompts.
3. **Lesson Rewriter & Polisher:** Adapts lesson reading levels, generates code examples, simplifies complex topics.
4. **Quiz Generator:** Analyzes lesson transcripts to formulate balanced questions with explanations.
5. **AI Assignment Rubric Designer:** Creates multi-criteria evaluation matrices.
6. **Automated Grading Assistant:** Evaluates essays against rubrics with instructor sign-off.
7. **Speech-to-Text & Captions:** Transcribes video/audio to VTT captions and searchable chapters.
8. **SEO & Metadata Assistant:** Generates JSON-LD schema, OpenGraph tags, and Unicode slugs.
9. **Glossary-Locked Translation:** High-accuracy translation across `en`, `bn`, and `ar`.
10. **Instructor Q&A Co-Pilot:** Drafts helpful pedagogical answers for instructor review.
11. **Certificate Text Designer:** Generates personalized congratulatory text.
12. **Learner AI Tutor (RAG):** Context-aware chatbot restricted strictly to enrolled course material with citation links.
13. **Adaptive Study Tools:** Generates lesson summaries, spaced-repetition flashcards, and practice quizzes.
14. **Recommendations Engine:** Cosine embedding matching based on learner past performance.
15. **Natural Language Search:** Converts conversational queries ("beginner Python in Bangla under ৳3000") into filtered database queries.
16. **Pre-Sales Support Bot:** Answers prospective student questions about course prerequisites.
17. **Admin Natural-Language Copilot:** Queries platform telemetry and logs safely via Eloquent builders.
18. **Fraud & Anomaly Detection:** Detects suspicious concurrent sessions and abnormal payment spikes.
19. **Content Moderation:** Filters toxic or offensive comments and reviews.
20. **AI Token & Spend Governance:** Monthly budget enforcement, per-user quotas, and PII scrubbing.

### 7. Triple Admin Panel System
Using `imrandevbd/laravel-admin-panel`, three dedicated, decoupled portals are registered:
- **`/admin` (Platform Administrator):** Full governance over courses, instructors, finance, gateway credentials, system health, and AI models.
- **`/instructor` (Instructor Portal):** Scope-isolated workspace where instructors manage only their courses, view assignment submissions, and track earnings ledgers.
- **`/org` (Organization & School Portal):** B2B portal where enterprise managers track seat allocations, create cohorts, and view student progress analytics.

### 8. Multilingual, Unicode & Bengali-First Engineering
- **Preserved Unicode Slugs:** URLs retain natural script without transliteration degradation:
  `https://tutorforge.test/courses/লার্যাভেল-মাস্টারক্লাস`
- **Native PDF Rendering:** Certificate and invoice templates utilize `imrandevbd/laravel-unicode-pdf` with Google Noto Sans Bengali font shaping for complex ligatures (যুক্তাক্ষর).
- **Localized Numerals & Currencies:** Displays currency symbol (৳) and converts numeric figures (`৳১,৫০০.০০`) dynamically based on user locale.
- **Full Localization:** Shipped complete with `en` (English) and `bn` (বাংলা), plus `ar` (العربية) RTL scaffold.

### 9. Gamification, Certifications & Social Engagement
- **Dynamic Certificate Builder:** Canvas with dynamic tokens (`{{student_name}}`, `{{course_title}}`, `{{date}}`, `{{certificate_id}}`) and verifiable cryptographic QR codes.
- **Public Verification Portal:** `/verify/{uuid}` displays certificate authenticity, issue date, and issuing instructor.
- **Gamification Mechanics:** Experience points (XP), achievement badges, learning streaks, and cohort leaderboards.
- **Community & Social:** Per-course Q&A discussion forums, review moderation, announcements with push notifications, and Zoom/Google Meet live sessions.

### 10. Security, Content Protection & Zero-Trust RBAC
- **Authentication:** Email/password verification, social OAuth (Google, GitHub, Facebook, Apple), TOTP 2FA, and WebAuthn Biometric Passkeys (FaceID/TouchID/Windows Hello).
- **Content Shielding:** Video streams served via short-lived signed URLs, dynamic learner email watermarking over video players, right-click disabling, and hotlink protection.
- **Fine-Grained Permissions:** Wildcard-supported RBAC (`courses.*`, `orders.refund`) with field-level commission permissions and tamper-evident SHA-256 audit logs.

---

## 📂 Directory & Domain Structure

```
tutor-lms-laravel/
├── app/
│   ├── Actions/                  # Domain write actions (CreateCourseAction, ProcessPaymentAction)
│   ├── Casts/                    # Custom Eloquent casts (MoneyCast)
│   ├── Data/                     # Spatie/PHP Data Transfer Objects (DTOs)
│   ├── Domain/                   # Domain business engines (Payments, Quizzes, AI)
│   ├── Enums/                    # Platform enums (UserRole, OrderStatus, QuizType)
│   ├── Models/                   # Eloquent Models (User, Role, Permission, InstructorProfile)
│   ├── Providers/                # Service providers (AdminPanelServiceProvider, AppServiceProvider)
│   ├── Services/                 # Gateway services (AiGateway, EntitlementService, PdfService)
│   └── ValueObjects/             # Value objects (Money with minor units and Bengali numerals)
├── config/                       # Published package & system configurations
├── database/
│   ├── factories/                # Model factories for testing and seeding
│   ├── migrations/               # PostgreSQL-compatible database migrations
│   └── seeders/                  # Role, permission, user, and demo data seeders
├── docker/                       # Nginx configurations and Docker environment files
├── docs/                         # Architecture documentation (DECISIONS.md, PACKAGE_GAPS.md)
├── lang/                         # Translation dictionaries (en.json, bn.json, ar.json)
├── public/                       # Web root (precompiled admin panel assets in vendor/admin-panel)
├── resources/                    # Blade views, Livewire components, and styles
├── storage/app/unicode-pdf/      # SIL OFL Noto Sans Bengali font repository
└── tests/                        # Pest 3 feature, unit, and smoke tests
```

---

## 💾 Database Schema & Data Model

The data layer is architected with ULID public identifiers, integer minor unit financial columns, and single-database multi-tenancy columns (`tenant_id`).

### Primary Model Domains:
- **Identity & Access:** `users`, `roles`, `permissions`, `role_user`, `permission_role`, `instructor_profiles`, `instructor_applications`, `organizations`, `organization_members`, `cohorts`, `cohort_members`, `guardians`.
- **Course Catalog:** `courses`, `course_translations`, `categories`, `tags`, `course_instructors`, `topics`, `items` (polymorphic: lessons, quizzes, assignments, live classes), `lessons`, `lesson_resources`, `content_bank_items`, `bundles`, `slug_histories`.
- **Assessment:** `quizzes`, `questions`, `question_options`, `quiz_attempts`, `quiz_attempt_answers`, `assignments`, `assignment_submissions`, `rubrics`, `rubric_criteria`, `grade_scales`, `grade_entries`.
- **Learning Progression:** `enrollments`, `progress_records`, `lesson_notes`, `lesson_comments`, `qna_threads`, `qna_messages`, `certificates`, `badges`, `user_badges`, `point_ledger`.
- **Commerce & Billing:** `carts`, `cart_items`, `orders`, `order_items`, `payments`, `payment_attempts`, `payment_gateways`, `webhook_events`, `refunds`, `invoices`, `coupons`, `subscription_plans`, `subscriptions`, `tax_rates`, `instructor_earnings`, `payouts`.
- **Platform Telemetry:** `ai_usage`, `ai_hub_request_logs`, `ai_hub_settings`, `email_templates`, `audit_logs`.

---

## ⚡ Getting Started & Installation

### Standard Local Setup

#### Prerequisites:
- PHP 8.3 or higher (with `pdo_mysql`, `mbstring`, `intl`, `gd`, `bcmath`, `curl`)
- Composer 2.7+
- Node.js 20+ & npm (for Livewire/Vite frontend assets)
- MySQL 8.0+ or SQLite for local dev
- Redis 7.0+

```bash
# 1. Clone the repository
git clone https://github.com/your-org/tutorforge.git
cd tutorforge

# 2. Install PHP dependencies
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Run database migrations & seed demo dataset
php artisan migrate:fresh --seed

# 5. Verify Unicode PDF font readiness
php artisan unicode-pdf:diagnose

# 6. Install frontend dependencies & run build
npm install
npm run build

# 7. Start the development server
php artisan serve
```

### Dockerized Environment

TutorForge includes a preconfigured `docker-compose.yml` orchestrating the entire stack:

```bash
# Build and start all containers
docker compose up -d --build

# Run migrations and seeders inside the app container
docker compose exec app php artisan migrate:fresh --seed

# Access the services:
# - Application / Learner Portal: http://localhost:8080
# - Admin Console:                http://localhost:8080/admin
# - Mailpit Email Inspector:      http://localhost:8025
# - Meilisearch Engine:           http://localhost:7700
# - MinIO S3 Object Storage:      http://localhost:9001
```

---

## 🔑 Demo Credentials

Following database seeding (`php artisan db:seed`), the following preconfigured user accounts are available:

| Role | Email Address | Password | Portal Access |
|---|---|:---:|---|
| **Super Administrator** | `superadmin@tutorforge.test` | `password` | `/admin`, `/ai-hub`, Full Access |
| **Platform Administrator** | `admin@tutorforge.test` | `password` | `/admin` |
| **Course Instructor** | `instructor@tutorforge.test` | `password` | `/instructor` |
| **Organization Manager** | `org@tutorforge.test` | `password` | `/org` |
| **Student / Learner** | `learner@tutorforge.test` | `password` | Front-end Portal (`/dashboard`) |

---

## 🧪 Testing & Quality Gates

TutorForge enforces strict automated quality standards:

```bash
# Execute Pest 3 test suite
./vendor/bin/pest

# Run Larastan Level 8 static analysis
./vendor/bin/phpstan analyse --memory-limit=2G

# Verify code formatting standards with Laravel Pint
./vendor/bin/pint --test

# Automatically fix code formatting
./vendor/bin/pint
```

### Quality Verification Summary:
- **Pest 3:** 100% test pass rate covering panel routing, ULID generation, RBAC wildcard permissions, Money value objects, Bengali numeral conversions, and AI Hub/Unicode PDF fakes.
- **Larastan:** Configured at **Level 8** with 0 errors.
- **Laravel Pint:** Verified with strict Laravel preset rules.

---

## 🔄 Continuous Integration (CI/CD)

All commits and pull requests trigger automated GitHub Actions workflows (`.github/workflows/ci.yml`) validating:
1. PHP 8.3 environment provisioning with Redis and MySQL services.
2. Composer dependency verification.
3. System diagnostics (`unicode-pdf:diagnose`).
4. Strict code style check (`pint --test`).
5. Static analysis at Level 8 (`phpstan analyse`).
6. Complete feature and regression test suite (`pest`).

---

## 📄 License

TutorForge is open-source software licensed under the [MIT License](LICENSE).
