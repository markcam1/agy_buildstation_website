# Buildstation Website Architecture & Specs

Buildstation is a developer-facing brand about local AI, coding harnesses, and model testing on consumer hardware.
**Core Proposition:** Measured on the machine you own. Honest constraints, zero datacenter hype.

---

## Brand Tokens & Aesthetics
- **Background (`--bg`):** `#0f172a` (Dark slate, workstation aesthetic)
- **Accent (`--accent`):** `#2563eb` (Electric blue for headers, key links, emphasis)
- **Text (`--text`):** `#e2e8f0` (Light grey high contrast)
- **Urgent (`--urgent`):** `#00ff41` (Neon green spotlight — strictly **one element per frame**)
- **Text Dim (`--text-dim`):** `#94a3b8` (Connective words, labels)
- **Grid / Hairlines (`--grid`):** `#1e293b` (Hairlines, card borders)
- **Typography:**
  - Headlines: `Poppins` 800/900 (-0.02em tracking, sentence case or ALL CAPS)
  - Subheads: `Poppins` 600
  - Numbers, stats, commands: `Roboto Mono` 500/700
  - Body copy: `Inter` 400/600
  - Hand-drawn annotations: `Caveat` 700

---

## Deliverables in This Project
1. **`buildstation-theme/` & `buildstation-theme.zip` (WordPress Theme):**
   - Installable via WordPress Admin (`Appearance > Themes > Add New > Upload Theme`) or Hostinger File Manager (`wp-content/themes/`).
   - Dynamic Customizer support for Hardware Test Bench specs, social links, and booking URLs.
   - Dynamic Post Queries for benchmark articles and videos.
   - AJAX-powered newsletter subscription handling.
   - Includes `front-page.php`, `header.php`, `footer.php`, `index.php`, `single.php`, `page.php`, and `screenshot.png` (1200x900).

2. **`public_html/` & `public_html.zip` (Static Site):**
   - Zero-dependency, ultra-fast static website ready to upload straight into Hostinger's `public_html` root directory.
   - Responsive mobile navigation drawer, interactive clipboard copy, toast notifications.

3. **`HOSTINGER_WORDPRESS_GUIDE.md`:**
   - Step-by-step instructions for 1-click deployment on Hostinger (both WordPress and static).
