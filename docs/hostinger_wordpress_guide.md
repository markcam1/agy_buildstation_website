# Hostinger & WordPress Deployment Guide for Buildstation

This guide explains how to install and run the Buildstation website on **Hostinger**, supporting both **WordPress** and **Static Hosting**.

---

## 📦 What Has Been Built

| Package / File | Purpose | Deployment Target |
|---|---|---|
| **`buildstation-theme.zip`** | Complete WordPress theme package | Hostinger WordPress (`Appearance > Themes`) |
| **`buildstation-theme/`** | Unzipped theme source directory | FTP or Hostinger File Manager (`wp-content/themes/`) |
| **`public_html.zip`** | Static HTML/CSS/JS package | Hostinger hPanel File Manager (`public_html/`) |
| **`public_html/`** | Static website source directory | Direct static hosting or local preview |

---

## 🚀 Option 1: WordPress on Hostinger (Recommended)

Use this option if you want to manage content, publish new benchmark articles, edit hardware specs via WordPress Customizer, and collect subscriber emails automatically.

### Method A: 1-Click Upload via WordPress Admin (Easiest)

1. Log into your WordPress admin dashboard (e.g., `https://yourdomain.com/wp-admin`).
2. Go to **Appearance → Themes** in the left sidebar.
3. Click **Add New Theme** at the top.
4. Click **Upload Theme**.
5. Select the **`buildstation-theme.zip`** file from your computer.
6. Click **Install Now**.
7. Once uploaded, click **Activate**.

### Method B: Via Hostinger hPanel File Manager

1. Log into your [Hostinger hPanel](https://hpanel.hostinger.com).
2. Go to **Websites → Manage → File Manager**.
3. Navigate to: `public_html/wp-content/themes/`.
4. Click the **Upload** button in the top-right and choose `buildstation-theme.zip`.
5. Right-click `buildstation-theme.zip` and choose **Extract** into a folder named `buildstation-theme`.
6. Go to your WordPress Admin dashboard → **Appearance → Themes** and click **Activate** under the **Buildstation** theme.

---

## ⚙️ Configuring Your WordPress Theme

### 1. Configure Hardware Test Bench & Links (Customizer)
In your WordPress Admin, go to **Appearance → Customize → Buildstation Settings**:
- **Hardware Test Bench:**
  - CPU: `i7-14700KF` (or your rig's CPU)
  - GPU: `RTX 4060 Ti · 16GB` (or your rig's GPU)
  - RAM: `64GB DDR5`
  - OS: `Ubuntu 24.04`
- **Channel & Social Links:**
  - YouTube Channel URL

### 2. Publishing Benchmark Runs & Videos
1. Go to **Posts → Add New Post**.
2. Enter the title (e.g. `Qwen 2.5 Coder 7B vs Aider on 16GB`).
3. Add your write-up, benchmarks, and terminal logs.
4. Set a **Featured Image** (16:9 ratio recommended).
5. Click **Publish**.
6. The homepage **Start here / Video series** section will automatically pull and display your latest published benchmarks!

### 3. Collecting Subscribers
- The newsletter form on the homepage is hooked into an AJAX endpoint (`buildstation_subscribe`).
- Submitted emails are automatically saved into your WordPress database (`buildstation_subscribers` option) and an email notification is immediately sent to the site admin address.
- You can export these subscribers anytime or integrate with plugins like *Mailchimp for WordPress*, *FluentCRM*, or *Beehiiv*.

---

## ⚡ Option 2: Static Website on Hostinger (Zero Maintenance)

If you don't need a WordPress backend and prefer ultra-fast static HTML:

1. Log into **Hostinger hPanel** → **File Manager**.
2. Navigate to your site's root directory: `public_html/`.
3. If there is a default `default.php` or `index.php` from Hostinger, delete or rename it.
4. Upload **`public_html.zip`**.
5. Right-click and choose **Extract** directly into `public_html/`.
6. Verify that `index.html`, `css/`, `js/`, and `robots.txt` are directly inside `public_html/`.
7. Your site is instantly live!

---

## 🎨 Style Guide Verification

The theme adheres strictly to the **Buildstation Style Guide**:
- **Palette:** `#0f172a` (background), `#2563eb` (electric blue accent), `#e2e8f0` (text), `#00ff41` (neon green urgent spotlight — strictly one element per frame), `#94a3b8` (text dim), `#1e293b` (grid / borders).
- **Typography:**
  - Headlines: `Poppins` 800/900 (-0.02em tracking, sentence case or ALL CAPS, never Title Case).
  - Numbers & stats: `Roboto Mono` 500/700 (every load-bearing figure).
  - Body: `Inter` 400/600.
  - Handwritten diagram notes: `Caveat` 700.
- **Tone:** Measured, specific, unimpressed. Lead with the result. Name the constraint. Show the number.

---

## 🛠️ Performance & Hostinger Optimization Tips

1. **LiteSpeed Cache (Hostinger):**
   - If using WordPress on Hostinger, the *LiteSpeed Cache* plugin works out of the box with the Buildstation theme.
   - CSS & JS minification can be safely enabled because assets are modular and clean.
2. **PHP Version:**
   - Compatible with **PHP 8.0, 8.1, 8.2, and 8.3+**. Hostinger defaults to PHP 8.1 or 8.2.
3. **Free SSL Certificate:**
   - In Hostinger hPanel, ensure **SSL** is activated under **Security → SSL** for HTTPS encryption.
