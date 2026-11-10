#!/usr/bin/env bash
# ==============================================================================
# Unified Contact & Subscriber Inspection Script
# Queries live subscribers for both Buildstation and RSU Flow via Hostinger WP-CLI
# ==============================================================================
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

# Source .env if present
if [ -f "$ROOT_DIR/.env" ]; then
  # shellcheck source=/dev/null
  export $(grep -v '^#' "$ROOT_DIR/.env" | xargs)
elif [ -f "$SCRIPT_DIR/.env" ]; then
  # shellcheck source=/dev/null
  export $(grep -v '^#' "$SCRIPT_DIR/.env" | xargs)
fi

HOST_IP="${HOST_IP:-191.101.79.207}"
HOST_PORT="${HOST_PORT:-65002}"
HOST_UNAME="${HOST_UNAME:-u574213859}"

EXPORT_FLAG="${1:-}"

echo "================================================================================"
echo "📡 Fetching Live Subscriber Data from Hostinger ($HOST_IP:$HOST_PORT)..."
echo "================================================================================"

# Fetch raw JSON for Buildstation
BS_RAW=$(ssh -p "$HOST_PORT" -o StrictHostKeyChecking=accept-new "${HOST_UNAME}@${HOST_IP}" \
  "cd domains/buildstationai.com/public_html && wp option get buildstation_subscribers --format=json 2>/dev/null || echo '[]'")

# Fetch raw JSON for RSU Flow
RSU_RAW=$(ssh -p "$HOST_PORT" -o StrictHostKeyChecking=accept-new "${HOST_UNAME}@${HOST_IP}" \
  "cd domains/rsuflow.com/public_html && wp option get rsuflow_subscribers --format=json 2>/dev/null || echo '[]'")

export BS_RAW RSU_RAW EXPORT_FLAG ROOT_DIR
python3 - << 'EOF'
import os, json, sys, csv

bs_raw = os.environ.get('BS_RAW', '[]')
rsu_raw = os.environ.get('RSU_RAW', '[]')
export_flag = os.environ.get('EXPORT_FLAG', '')
root_dir = os.environ.get('ROOT_DIR', '.')

def parse_subs(raw):
    try:
        data = json.loads(raw)
        if isinstance(data, list):
            return data
        return []
    except:
        return []

bs_subs = parse_subs(bs_raw)
rsu_subs = parse_subs(rsu_raw)

def print_table(title, subs, site_key):
    print(f"\n🏷️  {title} (Total: {len(subs)})")
    print("=" * 80)
    if not subs:
        print("   [ No subscribers registered yet ]")
        return
    print(f"   {'#':<4} | {'EMAIL':<36} | {'DATE (UTC)':<20} | {'IP ADDRESS':<15}")
    print("   " + "-" * 77)
    for idx, item in enumerate(subs, 1):
        email = item.get('email', '') if isinstance(item, dict) else str(item)
        date = item.get('date', '-') if isinstance(item, dict) else '-'
        ip = item.get('ip', '-') if isinstance(item, dict) else '-'
        print(f"   {idx:<4} | {email:<36} | {date:<20} | {ip:<15}")

print_table("BUILDSTATION (buildstationai.com)", bs_subs, "buildstation")
print_table("RSU FLOW (rsuflow.com)", rsu_subs, "rsuflow")

print("\n" + "=" * 80)
print(f"📊 SUMMARY: {len(bs_subs)} Buildstation subscriber(s) | {len(rsu_subs)} RSU Flow subscriber(s)")
print("=" * 80)

if export_flag == "--export":
    # Export to local CSVs
    bs_csv = os.path.join(root_dir, "subscribers_buildstation.csv")
    with open(bs_csv, 'w', newline='', encoding='utf-8') as f:
        w = csv.writer(f)
        w.writerow(['index', 'email', 'date_utc', 'ip_address'])
        for idx, item in enumerate(bs_subs, 1):
            w.writerow([idx, item.get('email', ''), item.get('date', ''), item.get('ip', '')])
    print(f"💾 Exported Buildstation subscribers to: {bs_csv}")

    rsu_csv = os.path.join(root_dir, "subscribers_rsuflow.csv")
    with open(rsu_csv, 'w', newline='', encoding='utf-8') as f:
        w = csv.writer(f)
        w.writerow(['index', 'email', 'date_utc', 'ip_address'])
        for idx, item in enumerate(rsu_subs, 1):
            w.writerow([idx, item.get('email', ''), item.get('date', ''), item.get('ip', '')])
    print(f"💾 Exported RSU Flow subscribers to:      {rsu_csv}")
EOF
