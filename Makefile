# BIM Hub Portal - Make Commands
# Use: make [command]

.PHONY: help start stop restart logs test clean setup migrate migrate-up migrate-down migrate-status migrate-fresh seed db-reset db-info

help:
@echo "BIM Hub Portal - Available commands:"
@echo ""
@echo "Development:"
@echo "  start      - Start all Docker containers"
@echo "  stop       - Stop all Docker containers"
@echo "  restart    - Restart all containers"
@echo "  logs       - Show logs from all containers"
@echo "  test       - Run all tests"
@echo "  clean      - Remove all containers and volumes"
@echo "  setup      - Initial project setup"
@echo ""
@echo "Database:"
@echo "  migrate        - Show migration status"
@echo "  migrate-up     - Run all pending migrations"
@echo "  migrate-down   - Rollback last migration"
@echo "  migrate-status - Show migration status"
@echo "  migrate-fresh  - Drop all tables and re-run migrations"
@echo "  seed           - Seed database with test data"
@echo "  db-reset       - Reset database (migrate fresh + seed)"
@echo "  db-info        - Show database connection info"
@echo ""
@echo "Deployment:"
@echo "  deploy     - Deploy to production"
@echo "  backup     - Create database backup"

# Docker Commands
start:
docker-compose up -d
@echo "🚀 Containers started!"
@echo "🌐 Web: http://localhost:8080"
@echo "🗄️  Adminer: http://localhost:8081"
@echo "📧 Mailhog: http://localhost:8025"

stop:
docker-compose down
@echo "🛑 Containers stopped"

restart: stop start

logs:
docker-compose logs -f

test:
docker-compose exec web vendor/bin/phpunit

clean:
docker-compose down -v --remove-orphans
@echo "🧹 All containers and volumes removed"

setup: start
docker-compose exec web composer install
docker-compose exec web npm install
@echo "✅ Setup complete!"

# Database migrations
migrate:
docker-compose exec web php bin/migrate.php status

migrate-up:
docker-compose exec web php bin/migrate.php up

migrate-down:
docker-compose exec web php bin/migrate.php down

migrate-status:
docker-compose exec web php bin/migrate.php status

migrate-fresh:
docker-compose exec web php bin/migrate.php fresh

# Database seeding
seed:
docker-compose exec web php bin/seed.php

# Reset database (migrate fresh + seed)
db-reset: migrate-fresh seed

# Show database info
db-info:
@echo "📊 Database Information:"
@echo "Host: \$${DB_HOST:-localhost}"
@echo "Port: \$${DB_PORT:-5432}"
@echo "Database: \$${DB_DATABASE:-bimhub}"
@echo "Username: \$${DB_USERNAME:-bimhub}"
@echo "Connecting via Adminer: http://localhost:8081"

# Deployment
deploy:
./deploy-final.sh

backup:
docker-compose exec db pg_dump -U bimhub bimhub > backup-$(date +%Y%m%d-%H%M%S).sql
@echo "💾 Backup created"
