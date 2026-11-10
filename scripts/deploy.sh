#!/usr/bin/env bash
# ==============================================================================
# Buildstation 1-Command Live Deployment Script
# Automatically syncs local theme files to Hostinger and flushes cache
# ==============================================================================
set -euo pipefail

ENV_FILE="$(dirname "$0")/.env"
if [ -f "$ENV_FILE" ]; then
  # shellcheck source=/dev/null
  export $(grep -v '^#' "$ENV_FILE" | xargs)
fi

HOST_IP="${HOST_IP:-191.101.79.207}"
HOST_PORT="${HOST_PORT:-65002}"
HOST_UNAME="${HOST_UNAME:-u574213859}"
REMOTE_PATH="domains/buildstationai.com/public_html/wp-content/themes/buildstation-theme/"

echo "🚀 Deploying Buildstation Theme to Hostinger ($HOST_IP:$HOST_PORT)..."

rsync -avz --delete \
  -e "ssh -p $HOST_PORT -o StrictHostKeyChecking=accept-new" \
  "$(dirname "$0")/buildstation-theme/" \
  "${HOST_UNAME}@${HOST_IP}:${REMOTE_PATH}"

echo "🧹 Flushing WordPress Cache..."
ssh -p "$HOST_PORT" -o StrictHostKeyChecking=accept-new "${HOST_UNAME}@${HOST_IP}" \
  "cd domains/buildstationai.com/public_html && wp cache flush"

echo "✅ Deployment complete! Check https://buildstationai.com"
