# Architecture & Product Decisions (ADR)

This document logs significant architectural and design choices made during development.

---

## ADR-001: Multi-Panel Routing Architecture
- **Context:** The application requires three distinct administrative portals:
  - `/admin`: Super-admin and platform administrators.
  - `/instructor`: Dedicated instructor dashboard scoped exclusively to instructor courses, learners, and payouts.
  - `/org`: B2B Organization & school manager portal for seat licenses and cohorts.
- **Decision:** Utilize `imrandevbd/laravel-admin-panel`'s multi-panel manager (`AdminPanel::registerPanel`) inside `app/Providers/AdminPanelServiceProvider.php`. Each panel defines its own route prefix, guard, middleware, and navigation structure.

## ADR-002: Money & Currency Storage
- **Context:** Financial transactions, course prices, commissions, and payouts must avoid floating point precision errors.
- **Decision:** Store all monetary amounts as integer minor units (e.g., cents, paisa: `1000` = $10.00 / ৳10.00) alongside a 3-character ISO 4217 currency column (`USD`, `BDT`, `EUR`). A `Money` value object and custom Eloquent cast manage formatting and localization (including Bengali numeral formatting for `bn` locale).

## ADR-003: Bengali-First Unicode Localization
- **Context:** TutorForge targets global and Bangladeshi educators. Slugs, PDFs, and numerals must natively render in Bengali (`bn`) without tofu or transliteration artifacts.
- **Decision:**
  - Slug generation uses `imrandevbd/laravel-universal-slug` with `mode = 'preserve_unicode'`.
  - PDF generation uses `imrandevbd/laravel-unicode-pdf` with SIL OFL `Noto Sans Bengali` font and complex conjunct script shaping enabled.
  - Locale switching preserves full dictionary translations in `resources/lang/bn.json` and `resources/lang/en.json`.

## ADR-004: Strict Eloquent & Query Budgets
- **Context:** N+1 queries degrade performance at scale.
- **Decision:** Enable `Model::preventLazyLoading()` and `Model::preventSilentlyDiscardingAttributes()` in all non-production environments inside `AppServiceProvider`.
