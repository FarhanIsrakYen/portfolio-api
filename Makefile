default: up migrate


build: down docker
	cp ./src/.env.example ./src/.env
	docker compose -f docker/docker-compose.yml build --no-cache
	docker compose -f docker/docker-compose.yml up -d
	docker exec php /bin/sh -c "composer install && npm install && chmod -R 777 storage && php artisan key:generate"

code-format-check:
	docker exec php /bin/sh -c "npm run format:check"

code-format:
	docker exec php /bin/sh -c "npm run format"

docker:
	rm -rf docker > /dev/null 2>&1
	git clone --single-branch --branch main git@github.com:FarhanIsrakYen/api.docker.git
	rm -rf docker/ > /dev/null 2>&1
	mkdir -p docker/
	cp -R api.docker/. docker/
	rm -rf api.docker > /dev/null 2>&1
	make owner
	rm -rf .env > /dev/null 2>&1
	cat src/.env.example >> docker/.env

down:
	docker ps -a -q | xargs -n 1 -P 8 -I {} docker stop {}
	docker builder prune --all --force
	docker system prune -f

flush-db:
	docker exec php /bin/sh -c "php artisan migrate:fresh"

flush-db-with-seeding:
	docker exec php /bin/sh -c "php artisan migrate:fresh --seed"

kill-app:
	docker compose down

ssh:
	docker exec -it php /bin/sh

migrate:
	sleep 5
	docker exec php /bin/sh -c "php artisan migrate"

mysql:
	docker exec -it mysql /bin/sh

owner:
    # docker
	chmod -R 777 docker
	# website var
	for d in $$(ls ../); do \
	chown -R www-data:www-data ../$$d \
	&& mkdir -p ../$$d/var/cache/$(APP_ENV)/ \
	&& mkdir -p ../$$d/var/log/ \
	&& touch ../$$d/var/log/$(APP_ENV).log \
	&& chmod 777 -R ../$$d/var/ \
	; done

test:
	docker exec php /bin/sh -c "php artisan test"

up:
	docker compose -f docker/docker-compose.yml up -d