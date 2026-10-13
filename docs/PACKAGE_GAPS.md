# Package Gaps & Adapter Architecture

This document tracks vendor package observations, API differences, and the architectural bridge layer implemented in `app/Support` as required by **Ground Rule 1**.

---

## 1. `imrandevbd/laravel-admin-panel` (dev-main)

### Discovered Package Surface:
- **Namespace:** `ImranDevBD\LaravelAdminPanel`
- **Facade:** `ImranDevBD\LaravelAdminPanel\Facades\AdminPanel`
- **Core Classes:**
  - `AdminPanel`: Root manager holding `PanelRegistry`, `PanelManager`, `ThemeRegistry`, `RenderHook`.
  - `Panel`: Fluent panel builder supporting `path()`, `guard()`, `middleware()`, `theme()`, `brandName()`, `brandLogo()`, `resources()`, `pages()`, `widgets()`, `navigation()`, `booting()`, `url()`.
  - `NavigationItem`, `NavigationGroup`: Fluent navigation configuration.
  - `Theme`, `ThemeRegistry`: 8 WCAG 2.2 palettes (indigo, emerald, blue, etc.), zero-white-flash `<head>` script.
  - `RenderHook`: Extensible blade hook points.
- **Commands Published:** `admin-panel:install`, `admin-panel:publish`.

### Gaps & Application Adapters:
- **Gap 1: Missing CLI commands `admin-panel:make-resource` and `admin-panel:make-page`**:
  - The package provides the panel container, routing, themes, and navigation, but does not ship built-in code generators or Filament-style Form/Table AST engines.
  - **Adapter Solution:** Built `App\Admin\Support\Resource` and `App\Admin\Support\AdminResourceRegistry` to provide fluent resource declarations, data tables, actions, and custom page routers rendered through the admin panel's native Blade/Alpine layout.
- **Gap 2: Multi-panel Scoping**:
  - The package allows registering multiple panels (`admin`, `instructor`, `org`). Each panel specifies its own path, middleware stack, and navigation items.
  - **Adapter Solution:** `AdminPanelServiceProvider` registers the 3 distinct panels and attaches panel-specific navigation groups and route guards.

---

## 2. `imrandevbd/laravel-ai-hub` (^1.6)

### Discovered Package Surface:
- **Namespace:** `ImranDevBd\AiHub`
- **Facade:** `ImranDevBd\AiHub\Facades\AIHub`
- **Core Capabilities:**
  - 13 provider adapters (OpenAI, Gemini, Claude, Grok, DeepSeek, Mistral, Groq, Ollama, OpenRouter, Azure, Together, Fireworks, Perplexity).
  - Methods: `provider()`, `model()`, `prompt()`, `thinking()`, `asJsonSchema()`, `structured()`, `stream()`, `chat()`, `forJob()`, `embed()`, `promptTemplate()`, `fake()`, `response()`.
  - Persistence: `AiRequestLog` model and migrations (`ai_hub_request_logs`, `ai_hub_settings`).

### Gaps & Application Adapters:
- **Gap 1: Application-level Quotas and Course Context**:
  - While `laravel-ai-hub` provides token logging and global settings, it does not know about TutorForge courses, user subscription plans, or student quotas.
  - **Adapter Solution:** Implemented `App\Services\Ai\AiGateway` as the single choke point. It decorates every AI request with `forJob()`, checks user plan limits, redacts PII, caches identical requests, and creates `ai_usage` application records.

---

## 3. `imrandevbd/laravel-unicode-pdf` (dev-main)

### Discovered Package Surface:
- **Namespace:** `ImranDev\UnicodePdf`
- **Facade:** `ImranDev\UnicodePdf\Facades\UnicodePdf`
- **Core Capabilities:**
  - Native engine with zero external binary dependencies.
  - Full Unicode font embedding, Bengali/Arabic conjunct glyph shaping, RTL layout detection.
  - Methods: `view()`, `html()`, `preset()`, `locale()`, `paper()`, `margin()`, `watermark()`, `encrypt()`, `numerals()`, `checkGlyphs()`, `fake()`.
  - Font directory: `storage/app/unicode-pdf/fonts`. Preset font Noto Sans Bengali installed and verified.

### Gaps & Application Adapters:
- **Gap 1: Native Engine CSS Limitations**:
  - The native engine does not support CSS Grid or Flexbox.
  - **Adapter Solution:** All PDF view templates (`resources/views/pdf/certificate.blade.php`, `invoice.blade.php`, etc.) use table-based layouts and absolute-positioned elements. For advanced templates requiring CSS Grid, the system provides an opt-in switch to `UnicodePdf::engine('browsershot')`.

---

## 4. `imrandevbd/laravel-universal-slug` (dev-main)

### Discovered Package Surface:
- **Namespace:** `ImranDev\UniversalSlug`
- **Traits:** `HasUniversalSlug`, `HasSlugHistory`.
- **Core Capabilities:**
  - Preserves UTF-8 Unicode characters (Bangla, Arabic) in URL slugs by default.
  - Automatic 301 redirection tracking via `slug_histories` table.
  - Attributes: `#[Slug]`.
  - Commands: `slug:generate`, `slug:regenerate`, `slug:audit`, `slug:prune`.

### Gaps & Application Adapters:
- Fully aligned with TutorForge requirements. Migration `create_slug_histories_table` is registered and executed.
