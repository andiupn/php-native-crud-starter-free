#!/usr/bin/env bash
set -euo pipefail

repo_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

docker compose -f "$repo_root/docker-compose.yml" up -d --build

docker compose -f "$repo_root/docker-compose.yml" run --rm web sh -lc '
  find /var/www/html/app /var/www/html/config /var/www/html/public -name "*.php" -print0 |
  xargs -0 -n1 php -l
'

