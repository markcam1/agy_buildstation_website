# GEMINI.md — Buildstation Website Context & Guidelines

Comprehensive operational reference for Google Antigravity and Gemini coding agents working on the Buildstation codebase.

---

## 1. Project & Brand Identity

- **Channel / Brand:** Buildstation (`https://buildstationai.com`)
- **Legal Business Entity:** SimpleInvest Digital LLC
- **Core Mission:** Developer-facing channel testing coding harnesses (Aider, OpenHands, SWE-agent, AutoCodeRover, etc.) on consumer hardware with local open-weight models (7B–14B).
- **The Core Constraint:** **16GB VRAM** (RTX 4060 Ti 16GB, i7-14700KF, 64GB DDR5, Ubuntu 24.04).
- **Tone & Aesthetic:** Terminal-adjacent, dark surfaces, monospace stats, high-contrast type, measured voice ("measured rather than claimed", no hype adjectives).
- **YouTube Channel:** [https://www.youtube.com/@BuildstationHQ/shorts](https://www.youtube.com/@BuildstationHQ/shorts) (and `@BuildstationHQ`).

### Color Palette (Strict — No 5th Color)
```
#0f172a  --bg          Background (dark surfaces, never light mode)
#2563eb  --accent      Electric blue (primary brand accent, circuit lines, specs)
#e2e8f0  --text        Light grey (headlines, high contrast body text)
#00ff41  --urgent      Neon green (strictly ONE per frame / viewport — CTA, live dot, cursor)
#94a3b8  --text-dim    Muted labels, code comments, secondary annotations
#1e293b  --grid        Borders, dividers, subtle hatches
#3a4a5e  --text-enter  Animation entry color (word cascade before settling into #e2e8f0)
```

### Typography
- **Headlines:** `Poppins` (wght 800, 900) — sentence case or ALL CAPS, never Title Case.
- **Numbers / Metrics / Terminal:** `Roboto Mono` (wght 500, 700) — every number a viewer should remember.
- **Sketches / Handwritten Notes:** `Caveat` (wght 500, 700).
- **Long-form Body:** `Inter` (wght 400, 500, 600).

---

## 2. Infrastructure & Hosting Environment

- **Live Production URL:** `https://buildstationai.com`
- **Hosting Provider:** Hostinger Cloud (LiteSpeed Web Server, PHP 8.3, MariaDB, WP-CLI 2.12.0)
- **Domain Registrar:** Namecheap DNS pointing to Hostinger name servers (`ns1.dns-parking.com`, `ns2.dns-parking.com`)
- **Server Access:** SSH Key-based authentication via port `65002`

### Deployment Credentials (`.env`)
```bash
HOST_IP=191.101.79.207
HOST_PORT=65002
HOST_UNAME=u574213859
```

### Remote Path Mappings
- **Buildstation Document Root:** `domains/buildstationai.com/public_html/`
- **Active WordPress Theme:** `domains/buildstationai.com/public_html/wp-content/themes/buildstation-theme/`
- **Secondary Domain (Same Host & SSH):** `domains/rsuflow.com/public_html/` (see section 6)

---

## 3. Repository Directory Structure

```
buildstation_website/
├── GEMINI.md                    # This agent reference guide
├── README.md                    # Project README & quick start
├── .env                         # SSH deployment secrets (git-ignored)
├── .env.example                 # Example template for credentials
├── .gitignore                   # Git ignore rules
├── deploy.sh                    # 1-command live rsync deployment + cache flush
├── buildstation-theme/          # Custom WordPress theme
│   ├── style.css                # Primary stylesheet (theme version 1.0.4)
│   ├── functions.php            # AJAX handlers, 301 redirects, admin dashboard
│   ├── front-page.php           # Landing page template (sketches, videos, telemetry)
│   ├── header.php               # Clean header, navlinks, mobile drawer
│   ├── footer.php               # Footer, disclaimer, social links
│   ├── single.php               # Single post template (with 301 redirect safeguard)
│   ├── page.php                 # Standard page template
│   ├── index.php                # Blog fallback
│   ├── inc/
│   │   └── customizer.php       # WordPress Customizer controls (specs, URLs)
│   └── assets/
│       ├── css/
│       │   └── buildstation.css # Mirror of style.css
│       └── js/
│           └── main.js          # Telemetry ticker, form submission, copy pill
├── docs/                        # Project documentation & setup history
│   ├── domain_ideas.md          # Domain brainstorming
│   ├── hostinger_wordpress_guide.md # Server setup guide
│   ├── newsletter_sending_process.md # Email dispatch guide & sender workflow
│   ├── website_idea.md          # Initial concept and wireframe
│   └── screenshots/             # DNS and verification captures
├── scripts/                     # Operational scripts
│   ├── check_contacts.sh        # Unified subscriber checker for both domains
│   ├── deploy.sh                # Script copy of deploy tool
│   ├── get_subscribers.sh       # Fetches subscriber emails & exports to CSV/JSON
│   └── send_newsletter.py       # Dispatch broadcast and test sending engine
├── templates/                   # Newsletter HTML dispatch templates
│   ├── dispatch_buildstation.html
│   └── dispatch_rsuflow.html
└── style/
    └── buildstation-style-guide.md # Master Buildstation Brand Style Guide
```

---

## 4. Key Subsystems & Architecture

### A. Newsletter Subscription System
- **Endpoint:** `wp-admin/admin-ajax.php` (`action=buildstation_subscribe`) with fallback to `admin-post.php`.
- **Cache Resilience:** Caching layers (LiteSpeed/CDN) frequently invalidate guest nonces. The handler in [`functions.php`](buildstation-theme/functions.php) uses a bot honeypot field (`bs_hp`) and email format validation (`is_email`) to guarantee reliable signups without false 403 blocks.
- **Storage:** Stored in WordPress database table `wp_options` under option name `buildstation_subscribers` as an array of `['email' => ..., 'date' => ..., 'ip' => ...]`.
- **WordPress Admin View:** Accessible in WP Admin under **Subscribers** (`admin.php?page=buildstation-subscribers`) with a 1-click **Export to CSV** action (`admin-post.php?action=buildstation_export_subscribers`).
- **CLI Sync:** `./scripts/get_subscribers.sh` pulls all subscribers directly to local `subscribers.csv` and `subscribers.json`.

### B. Curated Video Cards & Redirects
- **Hero & Videos Grid:** Featured cards link directly to YouTube Shorts (`https://www.youtube.com/@BuildstationHQ/shorts`).
- **301 Permanent Redirect:** `/hello-world/` is configured in `functions.php` (via `template_redirect`) and `single.php` to immediately issue HTTP 301 redirecting to `https://www.youtube.com/@BuildstationHQ/shorts`.

### C. Motion Graphics
Following the **Buildstation Style Guide** (no 3D bounces, no offscreen spring transitions):
1. **Live Monospace Telemetry Ticker (Hero):** Real-time typing animation in `main.js` cycling realistic local benchmark throughput (`vLLM`, `ollama`, `llama.cpp`) with neon green (`#00ff41`) blinking cursor.
2. **Remotion Headline Color-Settle:** Words enter in `--text-enter: #3a4a5e` and transition to `#e2e8f0` and `#2563eb` front-loaded.
3. **Chassis Neural Network Pulse (`#hardware`):** Animated SVG stroke-dash pulses (`@keyframes bsDashFlow`) travel along data conduits from the CPU and GPU into the neural network layers.
4. **GPU Hardware Fan Rotation:** Dual GPU fans smoothly rotate (`@keyframes bsFanSpin`).

---

## 5. Standard Operating Commands

```bash
# 1. Deploy theme changes to live production server & flush cache
./deploy.sh

# 2. Fetch all newsletter subscribers and export to CSV/JSON
./scripts/get_subscribers.sh

# 3. Check live contacts across both Buildstation and RSU Flow
./scripts/check_contacts.sh

# 4. Preview / Test newsletter dispatch
python3 scripts/send_newsletter.py --site buildstation --subject "SWE-bench Breakdown" --test developer@domain.com

# 5. Remote WP-CLI execution
ssh -p 65002 u574213859@191.101.79.207 "cd domains/buildstationai.com/public_html && wp cache flush"
ssh -p 65002 u574213859@191.101.79.207 "cd domains/buildstationai.com/public_html && wp option get buildstation_subscribers --format=json"

# 4. Check live HTTP redirect
curl -ILs "https://buildstationai.com/hello-world/" | grep -E "HTTP/|Location"
```

---

## 6. Multi-Tenant Sister Domain: `rsuflow.com`

- **Host Location:** Hosted on the **exact same Hostinger server and SSH account**.
- **Remote Path:** `domains/rsuflow.com/public_html/`
- **Active Theme:** `rsuflow-theme`
- **SSH Access:** **No new SSH key is required.** The credentials in `.env` provide full shell access to `domains/rsuflow.com/public_html/`.
- **Local Dedicated Website Project:** `/home/master/Software/content_maker/website_rsu/`
- **Local YouTube Channel Project:** `/home/master/Software/content_maker/youtube_rsu/`
