init: down-clear pull build-pull up app-init front-init
down: down-clear
check: lint analyze test

up:
	docker compose up -d

down-clear:
	docker compose down -v --remove-orphans

pull:
	docker compose pull

build-pull:
	docker compose build --pull

app-init: composer-install migrate fixtures-load

front-init: npm-install npm-build

migrate:
	docker compose run --rm php-cli php bin/console d:m:m --no-interaction

fixtures-load:
	docker compose run --rm php-cli php bin/console doctrine:fixtures:load --no-interaction

composer-install:
	docker compose run --rm php-cli composer install

composer-autoload:
	docker compose run --rm php-cli composer dump-autoload

composer-validate:
	docker compose run --rm php-cli composer validate

analyze: phpstan

lint:
	docker compose run --rm php-cli ./vendor/bin/php-cs-fixer fix --dry-run --allow-risky=yes --diff

cs-fix:
	docker compose run --rm php-cli ./vendor/bin/php-cs-fixer fix --allow-risky=yes

phpstan:
	docker compose run --rm php-cli composer phpstan

test:
	docker compose run --rm php-cli composer test

npm-install:
	docker compose run --rm php-cli npm install

npm-build:
	docker compose run --rm php-cli npm run build
