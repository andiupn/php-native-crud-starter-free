#!/usr/bin/env bash
set -euo pipefail

repo_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
keep_up=0

if [[ "${1:-}" == "--keep-up" ]]; then
  keep_up=1
fi

if [[ "$keep_up" != "1" ]]; then
  trap 'docker compose -f "$repo_root/docker-compose.yml" down >/dev/null 2>&1 || true' EXIT
fi

wait_for_http() {
  local url="$1"
  for _ in $(seq 1 60); do
    if curl -fsS "$url" >/dev/null; then
      return
    fi
    sleep 1
  done

  echo "http failed: $url" >&2
  exit 1
}

find_item_id() {
  local name="$1"

  docker compose -f "$repo_root/docker-compose.yml" exec -T -e SMOKE_NAME="$name" web php -r '
require "/var/www/html/config/config.php";
$db = getDB();
$name = getenv("SMOKE_NAME");
$stmt = $db->prepare("SELECT id FROM items WHERE name = :name ORDER BY id DESC LIMIT 1");
$stmt->bindValue(":name", $name, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result ? $result->fetchArray(SQLITE3_ASSOC) : false;
if ($result instanceof SQLite3Result) {
    $result->finalize();
}
$stmt->close();
echo $row["id"] ?? "";
'
}

docker compose -f "$repo_root/docker-compose.yml" up -d --build

wait_for_http "http://localhost:8081/"
wait_for_http "http://localhost:8081/?route=item/index"
wait_for_http "http://localhost:8081/assets/vendor/bootstrap/bootstrap.min.css"

name="Codex Smoke Free $(date +%s)"
updated="${name} Updated"

curl -fsS -L \
  -d "name=$name" \
  -d "type=Smoke" \
  -d "description=Created by standalone smoke test" \
  -d "category=Verification" \
  -d "amount=123" \
  -d "email=smoke@example.com" \
  -d "phone=0800000000" \
  "http://localhost:8081/?route=item/create" >/dev/null

id="$(find_item_id "$name")"
if [[ -z "$id" ]]; then
  echo "create failed" >&2
  exit 1
fi

curl -fsS -L \
  -d "name=$updated" \
  -d "type=Smoke" \
  -d "description=Updated by standalone smoke test" \
  -d "category=Verification" \
  -d "amount=456" \
  -d "email=smoke@example.com" \
  -d "phone=0800000000" \
  "http://localhost:8081/?route=item/edit&id=$id" >/dev/null

curl -fsS -L \
  -d "confirm=yes" \
  "http://localhost:8081/?route=item/delete&id=$id" >/dev/null

echo "smoke ok: free"

if [[ "$keep_up" == "1" ]]; then
  echo "services kept running"
fi

