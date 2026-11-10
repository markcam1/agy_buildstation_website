# Buildstation & RSU Flow — Newsletter & Benchmark Dispatch Process

Operational guide for drafting, testing, and broadcasting email dispatches to registered subscribers across **Buildstation** (`https://buildstationai.com`) and **RSU Flow** (`https://rsuflow.com`).

All dispatches are published under **SimpleInvest Digital LLC**.

---

## 1. Overview & Architecture

Both platforms capture subscriber emails into their respective WordPress databases (`wp_options` table) via bot-protected endpoints. Dispatches can be previewed, test-sent, and broadcasted using the CLI sender tool:

```
[ Local Template / Markdown ]
              │
              ▼
   scripts/send_newsletter.py
              │
   ┌──────────┴──────────┐
   ▼                     ▼
--test <email>        --send
(Sandbox preview)     (Interactive broadcast confirmation)
   │                     │
   └──────────┬──────────┘
              ▼
    Hostinger WP-CLI (wp_mail)
              │
    ┌─────────┴─────────┐
    ▼                   ▼
Buildstation        RSU Flow
Subscribers         Subscribers
```

---

## 2. Dispatch Cadence & Content Types

| Channel | Frequency | Content Type | Sender Identity |
| :--- | :--- | :--- | :--- |
| **Buildstation** | Per benchmark run | **Unredacted Benchmark Dispatch:** Raw scoring sheets, +task deltas, 18-run telemetry, and model execution flags. | `Buildstation Dispatch <dispatch@buildstationai.com>` |
| **RSU Flow** | Quarterly (Feb, May, Aug, Nov) | **Vesting Alert Briefing:** IRS 22% statutory withholding gaps, tax calendar deadlines, concentration simulations. | `RSU Flow Briefing <alerts@rsuflow.com>` |

---

## 3. Standard Step-by-Step Sending Process

### Step 1: Check Subscriber Lists
Before drafting or sending, verify the active subscriber counts across both platforms:
```bash
./scripts/check_contacts.sh
```
To export fresh local CSVs:
```bash
./scripts/check_contacts.sh --export
```

### Step 2: Prepare or Customize the Dispatch Template
Templates live in the `templates/` directory:
- Buildstation: `templates/dispatch_buildstation.html`
- RSU Flow: `templates/dispatch_rsuflow.html`

Both templates include standard dark-mode responsive styling, monospace telemetry boxes, direct CTAs to unredacted reports/tools, and mandatory legal footer disclosures for **SimpleInvest Digital LLC**.

### Step 3: Run a Safe Dry-Run Preview
The sender defaults to dry-run mode if `--send` is omitted. It shows the full recipient list, email subject, and template size without sending anything:
```bash
# Buildstation dry-run:
./scripts/send_newsletter.py --site buildstation --subject "ACR vs Mini-SWE-agent Benchmark Breakdown"

# RSU Flow dry-run:
./scripts/send_newsletter.py --site rsuflow --subject "Q4 Vesting Calendar Alert: 22% Withholding Gap"
```

### Step 4: Send a Test Email to Yourself
Always test the dispatch on your own email address first to check formatting, spam score, and client compatibility (Gmail, Apple Mail, Outlook):
```bash
./scripts/send_newsletter.py --site buildstation \
  --subject "ACR vs Mini-SWE-agent Benchmark Breakdown" \
  --test your_personal_email@gmail.com
```

### Step 5: Broadcast to the Live Subscriber List
When ready, trigger the live broadcast with the `--send` flag. The tool displays an interactive safety confirmation prompt:
```bash
./scripts/send_newsletter.py --site buildstation \
  --subject "ACR vs Mini-SWE-agent Benchmark Breakdown" \
  --send
```
Type `CONFIRM` when prompted to execute delivery.

---

## 4. Customizing Email Variables via CLI

You can pass dynamic variables into the templates using `--vars`:
```bash
./scripts/send_newsletter.py --site buildstation \
  --subject "Qwen2.5-Coder-7B SWE-bench Results" \
  --vars '{"HERO_METRIC": "+5.2 tasks", "HERO_LABEL": "Delta on RTX 4060 Ti 16GB", "REPORT_URL": "https://buildstationai.com/reports/scoring_sheet_mock.html"}' \
  --dry-run
```

Supported placeholders:
- `{{TITLE}}`: Dispatch subject title
- `{{DATE}}`: Formatted date (YYYY-MM-DD)
- `{{NAME}}`: Subscriber greeting
- `{{HERO_METRIC}}`: Prominent number/delta
- `{{HERO_LABEL}}`: Description below the hero metric
- `{{INTRO_TEXT}}`: Opening paragraph
- `{{ANALYSIS_BODY}}`: In-depth analysis text
- `{{REPORT_URL}}`: Link to full benchmark scoring sheet or tool

---

## 5. Audit Logging & Delivery Records

Every test and live broadcast is automatically logged to:
`logs/newsletter_dispatches.log`

Log entries include UTC timestamp, site identifier, recipient address, subject line, and delivery status. The `logs/` directory is excluded from git tracking via `.gitignore`.
