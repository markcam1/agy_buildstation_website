#!/usr/bin/env python3
"""
Buildstation & RSU Flow — Newsletter & Benchmark Dispatch Sender
Safely drafts, previews, tests, and broadcasts email dispatches to subscribers
via Hostinger WP-CLI (wp_mail).

Usage Examples:
  # 1. Dry-run preview for Buildstation:
  python3 scripts/send_newsletter.py --site buildstation

  # 2. Test send to yourself:
  python3 scripts/send_newsletter.py --site buildstation --test developer@domain.com

  # 3. Live broadcast to both sites:
  python3 scripts/send_newsletter.py --site both --send --yes
"""

import os
import sys
import json
import base64
import argparse
import subprocess
from datetime import datetime

# Path resolution
SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
ROOT_DIR = os.path.dirname(SCRIPT_DIR)
LOG_DIR = os.path.join(ROOT_DIR, "logs")

def load_env():
    env_vars = {}
    for path in [os.path.join(ROOT_DIR, ".env"), os.path.join(SCRIPT_DIR, ".env")]:
        if os.path.isfile(path):
            with open(path, "r", encoding="utf-8") as f:
                for line in f:
                    line = line.strip()
                    if line and not line.startswith("#") and "=" in line:
                        k, v = line.split("=", 1)
                        env_vars[k.strip()] = v.strip().strip('"').strip("'")
            break
    return env_vars

ENV = load_env()
HOST_IP = ENV.get("HOST_IP", "191.101.79.207")
HOST_PORT = ENV.get("HOST_PORT", "65002")
HOST_UNAME = ENV.get("HOST_UNAME", "u574213859")

SITES = {
    "buildstation": {
        "key": "buildstation",
        "name": "Buildstation",
        "domain": "buildstationai.com",
        "remote_path": "domains/buildstationai.com/public_html",
        "option_key": "buildstation_subscribers",
        "from_header": "Buildstation Dispatch <dispatch@buildstationai.com>",
        "default_subject": "Buildstation Dispatch // SWE-bench Coding Agent Benchmark Breakdown",
        "default_template": os.path.join(ROOT_DIR, "templates", "dispatch_buildstation.html"),
    },
    "rsuflow": {
        "key": "rsuflow",
        "name": "RSU Flow",
        "domain": "rsuflow.com",
        "remote_path": "domains/rsuflow.com/public_html",
        "option_key": "rsuflow_subscribers",
        "from_header": "RSU Flow Briefing <alerts@rsuflow.com>",
        "default_subject": "RSU Flow Quarterly Alert // The 22% Statutory Withholding Cliff",
        "default_template": os.path.join(ROOT_DIR, "templates", "dispatch_rsuflow.html"),
    }
}

def log_event(message):
    os.makedirs(LOG_DIR, exist_ok=True)
    log_file = os.path.join(LOG_DIR, "newsletter_dispatches.log")
    timestamp = datetime.utcnow().strftime("%Y-%m-%d %H:%M:%S UTC")
    with open(log_file, "a", encoding="utf-8") as f:
        f.write(f"[{timestamp}] {message}\n")

def fetch_subscribers(site_config):
    remote_path = site_config["remote_path"]
    option_key = site_config["option_key"]
    cmd = [
        "ssh", "-p", str(HOST_PORT),
        "-o", "StrictHostKeyChecking=accept-new",
        f"{HOST_UNAME}@{HOST_IP}",
        f"cd {remote_path} && wp option get {option_key} --format=json 2>/dev/null || echo '[]'"
    ]
    try:
        res = subprocess.run(cmd, capture_output=True, text=True, check=True)
        raw = res.stdout.strip()
        data = json.loads(raw)
        subscribers = []
        for item in data:
            if isinstance(item, dict) and "email" in item:
                subscribers.append(item["email"].strip().lower())
            elif isinstance(item, str) and "@" in item:
                subscribers.append(item.strip().lower())
        return sorted(list(set(subscribers)))
    except Exception as e:
        print(f"❌ Failed to fetch subscribers from Hostinger: {e}")
        return []

def render_content(template_path, variables):
    if not os.path.isfile(template_path):
        return f"<p>{variables.get('INTRO_TEXT', 'No content provided.')}</p>"
    with open(template_path, "r", encoding="utf-8") as f:
        content = f.read()
    for k, v in variables.items():
        content = content.replace(f"{{{{{k}}}}}", str(v))
    return content

def send_via_wp_mail(site_config, recipient, subject, html_content):
    remote_path = site_config["remote_path"]
    from_header = site_config["from_header"]
    
    b64_subject = base64.b64encode(subject.encode("utf-8")).decode("utf-8")
    b64_body = base64.b64encode(html_content.encode("utf-8")).decode("utf-8")
    b64_to = base64.b64encode(recipient.encode("utf-8")).decode("utf-8")
    b64_from = base64.b64encode(from_header.encode("utf-8")).decode("utf-8")
    
    php_code = f"""<?php
$to = base64_decode('{b64_to}');
$subject = base64_decode('{b64_subject}');
$body = base64_decode('{b64_body}');
$from = base64_decode('{b64_from}');
$headers = array(
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . $from
);
$result = wp_mail($to, $subject, $body, $headers);
echo $result ? 'SUCCESS' : 'FAILED';
"""
    cmd = [
        "ssh", "-p", str(HOST_PORT),
        "-o", "StrictHostKeyChecking=accept-new",
        f"{HOST_UNAME}@{HOST_IP}",
        f"cd {remote_path} && wp eval-file -"
    ]
    res = subprocess.run(cmd, input=php_code, capture_output=True, text=True)
    if "SUCCESS" in res.stdout:
        return True, "Delivered"
    return False, res.stderr or res.stdout.strip()

def process_site_send(site_config, subject, template_path, custom_vars, is_send, is_yes, test_email):
    subject = subject or site_config["default_subject"]
    template_path = template_path or site_config["default_template"]
    
    variables = {
        "TITLE": subject,
        "DATE": datetime.utcnow().strftime("%Y-%m-%d"),
        "NAME": "Fellow Engineer",
        "INTRO_TEXT": "Here is our latest benchmark breakdown evaluating small open-weight coding models on consumer hardware under a strict 16GB VRAM constraint." if site_config["key"] == "buildstation" else "Here is your quarterly vesting brief analyzing equity mechanics, statutory tax withholding cliffs, and concentration variance.",
        "HERO_METRIC": "+4.3 tasks (+8.6 pp)",
        "HERO_LABEL": "Delta vs mini-SWE-agent on RTX 4060 Ti 16GB",
        "ANALYSIS_BODY": "AutoCodeRover demonstrates higher solve rates due to syntax-directed localization before executing LLM patch loops. Check out the raw 50-task matrix and 18-run telemetry on the standalone report." if site_config["key"] == "buildstation" else "Employers withhold supplemental wages at a flat statutory 22% rate per IRS Pub 15-T, leaving an uncollected tax delta for tech engineers in the 35%-37% marginal brackets.",
        "REPORT_URL": f"https://{site_config['domain']}/reports/scoring_sheet_mock.html",
        "CYCLE": "Q4 2026",
        "STATUTORY_GAP": "$18,400 / VEST",
        "GAP_EXPLANATION": "22% statutory withholding vs 37% federal tax bracket",
        "TOOL_URL": f"https://{site_config['domain']}/#calculator"
    }
    
    if custom_vars:
        variables.update(custom_vars)
        
    rendered_html = render_content(template_path, variables)
    
    print("\n" + "=" * 80)
    print(f"📬 DISPATCH SENDER // TARGET: {site_config['name'].upper()} ({site_config['domain']})")
    print("=" * 80)
    print(f"📌 Subject:   {subject}")
    print(f"📄 Template:  {template_path}")
    print(f"📏 HTML Size: {len(rendered_html.encode('utf-8')):,} bytes")
    print(f"📤 Sender:    {site_config['from_header']}")
    
    subscribers = fetch_subscribers(site_config)
    print(f"👥 Total Subscribers in Database: {len(subscribers)}")
    
    # Mode 1: Test Email
    if test_email:
        print(f"\n🧪 [TEST MODE] Dispatching single test email to: {test_email}...")
        ok, msg = send_via_wp_mail(site_config, test_email, f"[TEST] {subject}", rendered_html)
        if ok:
            print(f"✅ Test email successfully delivered to {test_email}!")
            log_event(f"TEST SUCCESS: site={site_config['key']} to={test_email} subject='{subject}'")
        else:
            print(f"❌ Test email failed: {msg}")
            log_event(f"TEST FAILED: site={site_config['key']} to={test_email} error='{msg}'")
        return

    # Mode 2: Live Send
    if is_send:
        if not subscribers:
            print("⚠️ No subscribers found in database. Broadcast aborted.")
            return
        
        print("\n" + "!" * 80)
        print(f"⚠️  LIVE BROADCAST CONFIRMATION // {site_config['name'].upper()}")
        print(f"You are broadcasting '{subject}' to {len(subscribers)} subscriber(s):")
        for s in subscribers:
            print(f"   • {s}")
        print("!" * 80)
        
        if not is_yes:
            confirm = input("Type 'CONFIRM' to broadcast now: ").strip()
            if confirm != "CONFIRM":
                print("🛑 Broadcast cancelled by user.")
                return

        print(f"\n🚀 Broadcasting to {len(subscribers)} recipient(s)...")
        success_count = 0
        for s in subscribers:
            ok, msg = send_via_wp_mail(site_config, s, subject, rendered_html)
            if ok:
                print(f"   ✅ Sent to {s}")
                success_count += 1
                log_event(f"BROADCAST SENT: site={site_config['key']} to={s} subject='{subject}'")
            else:
                print(f"   ❌ Failed for {s}: {msg}")
                log_event(f"BROADCAST ERROR: site={site_config['key']} to={s} error='{msg}'")
        
        print(f"\n🎉 Broadcast complete for {site_config['name']}! Delivered {success_count}/{len(subscribers)}.")
        return

    # Default Mode: Dry-Run
    print("\n🔍 [DRY-RUN MODE] (No emails sent. Pass --test <email> or --send to dispatch)")
    print("-" * 80)
    print("Recipients that will receive this broadcast:")
    if not subscribers:
        print("   (None registered yet)")
    else:
        for idx, s in enumerate(subscribers, 1):
            print(f"   {idx}. {s}")
    print("-" * 80)

def main():
    parser = argparse.ArgumentParser(description="Send Buildstation and RSU Flow Dispatches")
    parser.add_argument("--site", choices=["buildstation", "rsuflow", "both"], default="buildstation", help="Target publication site")
    parser.add_argument("--subject", help="Email subject line")
    parser.add_argument("--template", help="Path to custom HTML template")
    parser.add_argument("--test", help="Send test email only to specified address")
    parser.add_argument("--send", action="store_true", help="Execute broadcast to all subscribers")
    parser.add_argument("-y", "--yes", action="store_true", help="Skip confirmation prompt")
    parser.add_argument("--vars", help="JSON string with template variables")
    
    args = parser.parse_args()
    custom_vars = {}
    if args.vars:
        try:
            custom_vars = json.loads(args.vars)
        except Exception as e:
            print(f"⚠️ Warning: Could not parse --vars JSON: {e}")
            
    sites_to_process = ["buildstation", "rsuflow"] if args.site == "both" else [args.site]
    for s_key in sites_to_process:
        process_site_send(
            site_config=SITES[s_key],
            subject=args.subject,
            template_path=args.template,
            custom_vars=custom_vars,
            is_send=args.send,
            is_yes=args.yes,
            test_email=args.test
        )

if __name__ == "__main__":
    main()
