# MRK WP Theme

> Full Site Editing (FSE) block theme for **MRK WP** — founder-led design and engineering, built for performance, editorial clarity, and structured knowledge.

- **Current Version:** `1.0.4`
- **Requires WordPress:** `6.7+`
- **Requires PHP:** `8.0+`
- **Author:** Matt Knighton ([https://mrkwp.com/](https://mrkwp.com/))
- **Text Domain:** `mrkwp`

---

## Overview

The **MRK WP** theme is a modern Full Site Editing (FSE) block theme featuring HTML templates in `templates/`, template parts in `parts/`, block patterns in `patterns/`, a centralized `theme.json` design token architecture, and an automated SCSS/PostCSS build pipeline.

### Key Highlights
- **Full Site Editing (FSE) Architecture:** Uses standard HTML templates and template parts (`templates/` and `parts/`), editable via the WordPress Site Editor.
- **Design Tokens (`theme.json` v3):** Unified palette, typography scales, spacing units, and block styling presets shared across the frontend and block editor.
- **Gutenberg Native Extensions:** Custom block styles for buttons and typography, customized SVG stroke social icons, and Gutenberg sidebar panels for page-level settings.
- **Strict Code Quality:** 100% compliant with WordPress Coding Standards (WPCS) via PHP_CodeSniffer (`phpcs.xml`).

---

## What We Have

### 1. Theme Configuration & Design Tokens (`theme.json`)
- **Color Palette:**
  - `ink` (`#0a2540`): Primary headings and deep dark backgrounds.
  - `body` (`#425466`): Standard body copy with high readability.
  - `canvas` (`#f8fafc`): Subtle off-white canvas backgrounds.
  - `white` (`#ffffff`), `indigo` (`#554cf0`), `cyan` (`#00d4ff`), `deep-cyan` (`#007a99`).
- **Typography Scale:**
  - Font families: `Inter` (body copy & UI) and `Plus Jakarta Sans` (headings & display).
- **Template Parts:**
  - `header` (`parts/header.html`): Site header with navigation and mega-menu.
  - `footer` (`parts/footer.html`): Site footer with brand lockup, links, and social icons.
- **Custom Templates:**
  - `page-about`: About Matt
  - `page-advisory`: Advisory
  - `page-clearer-brief`: Resource: Clearer Brief
  - `page-community`: Community
  - `page-contact`: Work With Me / Contact
  - `page-resources`: Resource Library
  - `page-tools`: Tools & Workflows

### 2. Block Templates (`templates/`)
- **`templates/front-page.html`:** Homepage featuring hero section, belief strip, editorial about, path grid, resource highlights, generative engine optimization comparison, and process journey.
- **`templates/page.html`:** Default page template.
- **`templates/single.html`:** Single post template.
- **`templates/index.html`:** Blog index and query loop fallback.
- **`templates/archive.html`:** Category, tag, and author archives.
- **`templates/search.html`:** Search results.
- **`templates/404.html`:** Accessible 404 error page.
- **`templates/page-about.html`:** About Matt Knighton.
- **`templates/page-tools.html`:** Tool directory and readiness assessment.
- **`templates/page-advisory.html`:** Advisory and consulting service breakdown.
- **`templates/page-resources.html`:** Curated resource library.
- **`templates/page-contact.html`:** Contact and inquiry forms.
- **`templates/page-community.html`:** Free builder community.
- **`templates/page-clearer-brief.html`:** Clearer brief prompt tool.

### 3. Block Editor Customizations
- **Custom Block Styles:**
  - `core/button`:
    - `Secondary (Outline)` (`is-style-secondary`)
    - `Light (White)` (`is-style-light`)
    - `Small / Compact` (`is-style-small`)
    - `Text Action Link` (`is-style-text-link`)
  - `core/paragraph`:
    - `Eyebrow Kicker` (`is-style-eyebrow`)
    - `Lead Paragraph` (`is-style-lead`)
- **Custom Social Link Icons:**
  - Replaces default filled social icons with brand-aligned minimal stroke SVG icons for GitHub, Instagram, LinkedIn, X, and YouTube on both the frontend and inside the block editor.
- **Page Settings Editor Sidebar (`js/page-settings-editor.js`):**
  - Gutenberg Document Sidebar panel providing a toggle to hide or show the page title (`mrkwp_hide_title` meta field).
- **Editor Styles (`dist/editor-style.css`):**
  - Compiles SCSS design tokens directly for the Gutenberg canvas to ensure true WYSIWYG editing.

### 4. Client-Side Scripts & Motion
- **`js/navigation.js`:** Mobile menu toggle, sticky header detection, and keyboard accessibility.
- **`js/motion.js`:** GSAP & ScrollTrigger scroll-driven animations and reveal effects.
- **`js/app.js`:** Readiness assessment logic and interactive calculations on the tools page.

---

## Development & Build Pipeline

### Prerequisites
- Node.js (v18+) and npm
- PHP 8.0+
- PHP_CodeSniffer with WordPress Coding Standards (WPCS)

### Installation
```bash
# Navigate to theme directory
cd wp-content/themes/mrkwp

# Install frontend build dependencies
npm install
```

### Available npm Scripts
- `npm run build`: Compiles SCSS (`src/scss/main.scss` & `src/scss/editor.scss`) using Sass and processes with PostCSS (Autoprefixer + cssnano) into `dist/`.
- `npm run watch`: Watches `src/scss/` and recompiles on file changes.
- `npm run build:sass`: Sass compilation only.
- `npm run build:postcss`: PostCSS autoprefixer and minification pass on `dist/*.css`.

---

## Code Quality & Standards

This theme adheres strictly to the official **WordPress Coding Standards (WPCS)**.

### Running PHPCS
```bash
# Check all theme PHP files against WPCS
phpcs

# Run with sniff codes and progress indicator
phpcs -s

# Automatically fix fixable sniffs
phpcbf
```

Configuration is maintained in [`phpcs.xml`](./phpcs.xml), scanning all theme PHP files while excluding build and vendor folders.

---

## Changelog

### [1.0.4] - 2026-10-23
#### Changed
- **Architectural SCSS Consolidation:** Eliminated redundant cascade overlay layers by removing monolithic legacy stylesheets `founder/_editorial.scss` (1,757 lines), `refinements/_readability.scss`, and the detached `base/_responsive.scss`.
- **Co-located Breakpoints:** Relocated all media query breakpoints directly into their respective atomic components (`_navigation.scss`, `_footer.scss`, `_buttons.scss`, `_bento.scss`, `_cards.scss`, `_eyebrows-badges.scss`) and composite sections (`_hero.scss`, `_shift-comparison.scss`, `_engine.scss`, `_community-invite.scss`, `_assessment.scss`).
- **Single Source of Truth:** Unified design tokens in `abstracts/_variables.scss` and `theme.json`, removing conflicting `:root` border radius overrides that were crushing styled radii.
- **Performance Optimization:** Reduced compiled `dist/theme.css` by over 36KB compressed (down from 127KB to 91KB, eliminating over 100KB of raw duplicated CSS) for faster browser parsing and improved Core Web Vitals (LCP).
- **Code Quality:** Maintained 100% PHPCS compliance (26 of 26 files passing) with clean Sass and PostCSS asset compilation.

### [1.0.2] - 2026-10-23
#### Added
- Dynamic related videos block (`mrkwp/related-videos`) querying videos related by `post_tag` and date descending, with fallback backfill to recent videos.
- Dynamic relative post date formatting (`mrkwp_format_relative_days()`) and `render_block_core/post-date` filter to show "Posted 'x' days ago" (e.g. "Posted today", "Posted 1 day ago", "Posted 5 days ago") for `mrkwp_video` posts.
- Insertable block patterns for `path-section` and `belief-strip`.

#### Changed
- Refined `single-mrkwp_video.html` template: removed card border, background, and padding artifacts from the video container.
- Set single video `h1` post title font size to 35px (`clamp` override and line-height adjustment).
- Styled related videos grid in `.videos-grid` with unified button badges and responsive column layouts.
- Maintained 100% PHPCS compliance (26 of 26 files passing).

### [1.0.1] - 2026-10-23
#### Added
- `phpcs.xml` configuration for WordPress Coding Standards (WPCS) with text domain validation for `mrkwp`.
- Gutenberg sidebar panel in `js/page-settings-editor.js` for post meta toggles (`mrkwp_hide_title`).
- Custom block styles for `core/button` (secondary, light, small, text-link) and `core/paragraph` (eyebrow, lead).
- Brand-matching stroke SVG icons for `core/social-link` blocks on both frontend and in the editor.
- Direct "Footer (Site Editor)" menu item under Appearance for managing the `parts/footer.html` template part.
- Comprehensive `README.md` documenting theme features, architecture, and development workflows.

#### Changed
- Resolved 100% of PHPCS errors and warnings across all theme PHP files (14 of 14 files passing).
- Corrected indentation to WordPress-standard tabs and eliminated unnecessary double-quoted strings.
- Escaped dynamic excerpt output in `index.php` using `esc_html()`.
- Added missing docblock annotations and stylesheet versioning in `functions.php`.
- Refined `page.php` to support title toggles and prevent unexpected container border/spacing artifacts.
- Synchronized theme version to `1.0.1` across `style.css`, `functions.php`, and `package.json`.

---

### [1.0.0] - 2026-10-22
#### Added
- Initial release of MRK WP custom theme.
- Hybrid theme setup with `theme.json` v3 presets for colors, typography, and button blocks.
- Page templates: `front-page.php`, `page-tools.php`, `page-about.php`, `page-advisory.php`, `page-resources.php`, `page-contact.php`, `page-community.php`, `page-clearer-brief.php`.
- Core SCSS architecture and asset build system (`Sass` + `PostCSS` with `Autoprefixer` and `cssnano`).
- Interactive readiness assessment script (`js/app.js`) and GSAP/ScrollTrigger motion integration (`js/motion.js`).
- Accessible responsive navigation and mobile menu drawer (`js/navigation.js`).
