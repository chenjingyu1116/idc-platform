#!/bin/bash
set -e
cd "$(dirname "$0")"

case "$1" in
  up)
    echo "🚀 构建并启动..."
    docker compose up -d --build
    echo ""
    echo "⏳ 等待 MySQL 就绪..."
    sleep 15
    echo "📦 执行迁移和初始化..."
    docker compose exec app php artisan migrate --force
    docker compose exec app php artisan db:seed --force || true
    docker compose exec app php artisan storage:link || true
    docker compose exec app php artisan config:cache
    docker compose exec app php artisan route:cache
    docker compose exec app php artisan view:cache
    echo ""
    echo "✅ 部署完成！访问 http://localhost:8080"
    ;;
  down)
    docker compose down
    ;;
  restart)
    docker compose restart
    ;;
  logs)
    docker compose logs -f app
    ;;
  migrate)
    docker compose exec app php artisan migrate --force
    ;;
  seed)
    docker compose exec app php artisan db:seed --force
    ;;
  shell)
    docker compose exec app sh
    ;;
  status)
    docker compose ps
    ;;
  *)
    echo "用法:"
    echo "  bash deploy.sh up        启动全部服务"
    echo "  bash deploy.sh down      停止全部服务"
    echo "  bash deploy.sh restart   重启"
    echo "  bash deploy.sh logs      查看日志"
    echo "  bash deploy.sh status    查看状态"
    echo "  bash deploy.sh shell     进入容器"
    echo "  bash deploy.sh migrate   执行迁移"
    echo "  bash deploy.sh seed      填充数据"
    ;;
esac
