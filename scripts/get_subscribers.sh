#!/usr/bin/env bash
# ==============================================================================
# Buildstation Subscriber Retrieval Script
# Fetches subscriber emails from WordPress on Hostinger via WP-CLI
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
REMOTE_WP_PATH="domains/buildstationai.com/public_html"
OUTPUT_CSV="${ROOT_DIR}/subscribers.csv"
OUTPUT_JSON="${ROOT_DIR}/subscribers.json"

echo "📡 Connecting to Hostinger ($HOST_IP:$HOST_PORT) via WP-CLI..."

# Fetch raw JSON from WordPress option
RAW_DATA=$(ssh -p "$HOST_PORT" -o StrictHostKeyChecking=accept-new "${HOST_UNAME}@${HOST_IP}" \
  "cd $REMOTE_WP_PATH && wp option get buildstation_subscribers --format=json 2>/dev/null || echo '[]'")

# Pass variables cleanly into python
export RAW_DATA OUTPUT_CSV OUTPUT_JSON
python3 - << 'EOF'
import os, json, sys, csv

raw_data = os.environ.get('RAW_DATA', '[]')
output_csv = os.environ.get('OUTPUT_CSV', 'subscribers.csv')
output_json = os.environ.get('OUTPUT_JSON', 'subscribers.json')

try:
    data = json.loads(raw_data)
except Exception as e:
    data = []

count = len(data)
print(f"✅ Successfully fetched {count} subscriber(s).\n")

if count == 0:
    print("ℹ️  No subscribers recorded yet.")
    sys.exit(0)

# Display formatted terminal table
print(f"{'#':<4} | {'EMAIL':<34} | {'DATE (UTC)':<20} | {'IP ADDRESS':<16}")
print("-" * 80)
for idx, entry in enumerate(data, start=1):
    email = entry.get('email', '') if isinstance(entry, dict) else entry
    date = entry.get('date', '-') if isinstance(entry, dict) else '-'
    ip = entry.get('ip', '-') if isinstance(entry, dict) else '-'
    print(f"{idx:<4} | {email:<34} | {date:<20} | {ip:<16}")

# Save CSV locally
with open(output_csv, 'w', newline='', encoding='utf-8') as f:
    writer = csv.writer(f)
    writer.writerow(['ID', 'Email', 'Date', 'IP'])
    for idx, entry in enumerate(data, start=1):
        email = entry.get('email', '') if isinstance(entry, dict) else entry
        date = entry.get('date', '') if isinstance(entry, dict) else ''
        ip = entry.get('ip', '') if isinstance(entry, dict) else ''
        writer.writerow([idx, email, date, ip])

# Save JSON locally
with open(output_json, 'w', encoding='utf-8') as f:
    json.dump(data, f, indent=2)

print(f"\n💾 Saved CSV to:  {output_csv}")
print(f"💾 Saved JSON to: {output_json}")
EOF
