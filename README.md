# MRK WP Theme

> Custom hybrid WordPress theme for **MRK WP** — founder-led design and engineering, built for performance, editorial clarity, and structured knowledge.

- **Current Version:** `1.0.1`
- **Requires WordPress:** `6.7+`
- **Requires PHP:** `8.0+`
- **Author:** Matt Knighton ([https://mrkwp.com/](https://mrkwp.com/))
- **Text Domain:** `mrkwp`

---

## Overview

The **MRK WP** theme is a modern hybrid WordPress theme that blends classic PHP page templates with Full Site Editing (FSE) block capabilities, a centralized `theme.json` design token architecture, and an automated SCSS/PostCSS build pipeline.

### Key Highlights
- **Hybrid Architecture:** Uses robust PHP page templates for tailored layouts alongside Gutenberg block template parts (e.g., FSE footer) and block patterns.
- **Design Tokens (`theme.json` v3):** Unified palette, typography scales, spacing units, and block styling presets shared across the frontend and block editor.
- **Gutenberg Native Extensions:** Custom block styles for buttons and typography, customized SVG stroke social icons, and Gutenberg sidebar panels for page-level settings.
- **Strict Code Quality:** 100% compliant with WordPress Coding Standards (WPCS) via PHP_CodeSniffer (`phpcs.xml`).

---

## What We Have So Far

### 1. Theme Configuration & Design Tokens (`theme.json`)
- **Color Palette:**
  - `ink` (`#0a2540`): Primary headings and deep dark backgrounds.
  - `body` (`#425466`): Standard body copy with high readability.
  - `canvas` (`#f8fafc`): Subtle off-white canvas backgrounds.
  - `accent-orange` (`#ff6a3d`): Primary CTA accent.
  - `accent-cyan` (`#00b4d8`): Secondary accent.
  - `accent-green` (`#2ec4b6`): Positive status and metric highlights.
  - `white` (`#ffffff`), `black` (`#000000`), and `border` (`#e2e8f0`).
- **Typography Scale:**
  - Font families: `Inter` (body copy & UI) and `Plus Jakarta Sans` (headings & display).
  - Sizes: `xs` (13px), `sm` (14px), `base` (16px), `lg` (18px), `xl` (20px), `2xl` (24px), `3xl` (32px), `4xl` (40px).
- **Layout:**
  - Content width: `1120px`
  - Wide width: `1320px`
- **Button Styling:**
  - Standardized button presets with border-radius, typography, and hover interaction rules matching MRK WP brand aesthetics.

### 2. Page Templates & Hierarchy
- **`front-page.php`:** Homepage template featuring the hero section, belief strip, comparison matrix, strategic frameworks, and dynamic post grids.
- **`page.php`:** Default page template with support for page-level meta toggles (e.g. show/hide title) and clean content wrapping without border artifacts.
- **`page-about.php`:** Editorial about and founder layout.
- **`page-tools.php`:** Interactive tools, calculator, and diagnostic layout.
- **`page-advisory.php`:** Advisory and consulting service breakdown.
- **`page-resources.php`:** Curated resource library and reading list.
- **`page-contact.php`:** Inquiries and project discovery contact form.
- **`page-community.php`:** Community hub and discussion overview.
- **`page-clearer-brief.php`:** Project briefing tool landing page.
- **`single.php` & `index.php`:** Clean, accessible blog post and archive views.
- **`header.php`:** Responsive navigation header with quick links, mobile drawer, and accessible SVG icons.
- **`footer.php` & `parts/footer.html`:** Block-based FSE footer template part with direct shortcut in WordPress Admin under **Appearance > Footer**.

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
