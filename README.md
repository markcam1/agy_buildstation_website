# Buildstation Website (`buildstationai.com`)

The official marketing site and developer benchmark portal for **Buildstation** — local AI coding harnesses and open-weight models tested on consumer hardware under a strict **16GB VRAM constraint**.

> **Live Website:** [https://buildstationai.com](https://buildstationai.com)  
> **Legal Business Entity:** SimpleInvest Digital LLC  
> **YouTube Channel:** [@BuildstationHQ/shorts](https://www.youtube.com/@BuildstationHQ/shorts)

---

## ⚡ Quick Start

### 1. Requirements
- Linux / macOS / WSL environment
- OpenSSH client
- `rsync`
- Python 3 (for subscriber exports)

### 2. Configure Credentials
Copy `.env.example` to `.env` and ensure your Hostinger SSH details are present:
```bash
cp .env.example .env
```
Default configuration:
```env
HOST_IP=191.101.79.207
HOST_PORT=65002
HOST_UNAME=u574213859
```

### 3. Deploy Live (1-Command)
Deploy all local theme updates directly to Hostinger and automatically flush the WordPress object/page cache:
```bash
./deploy.sh
```

### 4. Fetch Newsletter Subscribers
Pull all registered subscribers from the WordPress database into a formatted terminal table and export local CSV/JSON files:
```bash
./scripts/get_subscribers.sh
```

### 5. Check All Contacts Across Buildstation & RSU Flow
Inspect verified live subscribers across both web properties in a single command:
```bash
./scripts/check_contacts.sh
```

### 6. Send Benchmark Dispatches & Newsletters
Dry-run preview or broadcast email dispatches via Hostinger `wp_mail`:
```bash
# Safe dry-run preview:
./scripts/send_newsletter.py --site buildstation --subject "SWE-bench Breakdown"

# Single test send to yourself:
./scripts/send_newsletter.py --site buildstation --subject "SWE-bench Breakdown" --test you@domain.com
```

---

## 🏗️ Architecture & Features

### Custom WordPress Theme (`buildstation-theme`)
- **Strict Brand Design:** Designed to strictly follow the [Buildstation Style Guide](style/buildstation-style-guide.md) (Palette: `#0f172a`, `#2563eb`, `#e2e8f0`, `#00ff41`, `#94a3b8`, `#1e293b`, `#3a4a5e`).
- **Fast, Lightweight:** Zero heavy bloated page builders or third-party plugins; vanilla ES6 JavaScript and pure modern CSS.
- **Cache-Resilient Newsletter Engine:** Guest newsletter subscription form in [`front-page.php`](buildstation-theme/front-page.php) handles LiteSpeed caching and guest nonces gracefully with bot honeypot protection, JSON feedback, and standard HTML POST fallback (`admin-post.php`).
- **WordPress Admin Subscribers Hub:** View registered subscribers and export them to CSV via a custom admin menu in WordPress Admin (**Subscribers**).
- **Curated Video Cards:** Direct integration with YouTube Shorts playlists, featuring play badge overlays and smooth elevation transitions.
- **301 Permanent Redirect:** Automatic HTTP 301 redirection for legacy routes (`/hello-world/` → YouTube Shorts).
- **Interactive Motion Graphics:**
  - **Live Telemetry Monospace Stream:** Real-time benchmark throughput ticker cycling in the hero section.
  - **Remotion-Style Headline Word Cascade:** Font color-settle animation from `--text-enter: #3a4a5e` into final high-contrast type.
  - **Chassis Neural Net Pulse:** Animated SVG stroke-dash pulses traveling along data conduits from CPU & GPU into the neural network layers.
  - **GPU Fan Rotation:** Continuous hardware cooling fan animations in the cross-section diagram.

---

## 📂 Project Directory Structure

```text
buildstation_website/
├── GEMINI.md                    # Antigravity & Gemini agent context manual
├── README.md                    # Project overview & documentation
├── .env                         # Server deployment credentials (git-ignored)
├── .env.example                 # Example credentials template
├── .gitignore                   # Git ignore specifications
├── deploy.sh                    # Live deployment & cache flushing runner
├── buildstation-theme/          # Production WordPress theme
│   ├── style.css                # Primary stylesheet (v1.0.4)
│   ├── functions.php            # AJAX handlers, redirects, admin subscriber page
│   ├── front-page.php           # Landing page template (sketches, telemetry, cards)
│   ├── header.php               # Header, navigation, mobile drawer
│   ├── footer.php               # Footer & channel links
│   ├── single.php               # Single post template (with 301 redirect safeguard)
│   ├── page.php                 # Standard page template
│   ├── inc/customizer.php       # WordPress Customizer controls (specs, URLs)
│   └── assets/                  # CSS & JavaScript assets
├── docs/                        # Setup documentation & archive
│   ├── domain_ideas.md          # Domain brainstorming notes
│   ├── hostinger_wordpress_guide.md # Server setup guide
│   ├── website_idea.md          # Initial concept & wireframes
│   └── screenshots/             # DNS and verification captures
├── scripts/                     # Operational automation scripts
│   ├── deploy.sh                # Deployment script copy
│   └── get_subscribers.sh       # Subscriber database retrieval & CSV export
└── style/
    └── buildstation-style-guide.md # Master Buildstation Brand Style Guide
```

---

## 🛠️ Management via WP-CLI

You can run WP-CLI commands directly against the live Hostinger environment:

```bash
# Flush WordPress cache
ssh -p 65002 u574213859@191.101.79.207 "cd domains/buildstationai.com/public_html && wp cache flush"

# View active plugins / themes
ssh -p 65002 u574213859@191.101.79.207 "cd domains/buildstationai.com/public_html && wp theme list"

# List subscribers as JSON
ssh -p 65002 u574213859@191.101.79.207 "cd domains/buildstationai.com/public_html && wp option get buildstation_subscribers --format=json"
```

---

## 🌐 Sister Project: `rsuflow.com`

- **Host Location:** Hosted on the same Hostinger server and SSH account at `domains/rsuflow.com/public_html/`.
- **SSH Key:** Uses the identical SSH key and credentials configured in `.env` (no additional key required).
- **Local Reference:** `../youtube_rsu/`
