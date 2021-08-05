.PHONY: dev
BLUE="\033[1;34m"
END_BLUE="\033[0m"
GREEN="\033[1;32m"
END_GREEN="\033[0m"

include .env

dev: prepare_infrastructure clear_cache prepare_app_dev fix_files_owners_and_permissions ready
install: prepare_infrastructure prepare_app prepare_app_conf prepare_database fix_files_owners_and_permissions ready


prepare_infrastructure:
	@echo ${BLUE}"Prepare Dockerized Infrastructure..."${END_BLUE}
	docker-compose stop
	docker-compose pull
	docker-compose build
	docker-compose up -d

prepare_app_dev:
	@echo ${BLUE}"Prepare App..."${END_BLUE}
	docker-compose exec php-fpm composer install
	@echo ${BLUE}"Prepare App - OK"${END_BLUE}

prepare_app:
	@echo ${BLUE}"Prepare App..."${END_BLUE}
	docker-compose exec php-fpm composer install
	@echo ${BLUE}"Prepare App - OK"${END_BLUE}

prepare_app_conf:
	@echo "${BLUE}Prepare App Configuration..."${END_BLUE}
	cp .env.example .env
	docker-compose exec php-fpm php artisan key:generate
	@echo ${BLUE}"Prepare App Configuration - OK"${END_BLUE}

prepare_database:
	@echo ${BLUE}"Prepare Database..."${END_BLUE}
	docker-compose exec php-fpm php artisan migrate:fresh --seed
	@echo ${BLUE}"Prepare Database - OK"${END_BLUE}


fix_codestyle:
	@echo ${BLUE}"Fixing PHP Codestyle to PSR-2..."${END_BLUE}
	docker-compose exec php-fpm php vendor/squizlabs/php_codesniffer/bin/phpcbf /application/app
	@echo ${GREEN}"Fixing PHP Codestyle to PSR-2 - OK"${END_GREEN}
	@echo ${GREEN}"Fixing JS Codestyle to Airbnb and Vue..."${END_GREEN}
	docker-compose exec node npm run lint
	@echo ${BLUE}"Fixing JS Codestyle to Airbnb and Vue - OK"${END_BLUE}

check_codestyle:
	@echo ${BLUE}"Check Codestyle..."${END_BLUE}
	docker-compose exec php-fpm php vendor/squizlabs/php_codesniffer/bin/phpcs

static_analyse_php_codebase:
	@echo ${BLUE}"Static analising PHP codebase..."
	docker-compose exec php-fpm ./vendor/bin/phpstan analyse --memory-limit=4G
	@echo ${BLUE}"Static analising PHP codebase - OK"${END_BLUE}

code_coverage_report:
	@echo ${BLUE}"Creating code coverage report..."${END_BLUE}
	docker-compose exec php-fpm php -dxdebug.coverage_enable=1 ./vendor/phpunit/phpunit/phpunit --coverage-html ./public/build/coverage-report ./tests
	@echo ${BLUE}"Creating code coverage report - OK"${END_BLUE}

clear_cache:
	@echo ${BLUE}"Clearing the cache..."${END_BLUE}
	docker-compose exec php-fpm php artisan cache:clear
	docker-compose exec php-fpm php artisan clear-compiled
	docker-compose exec php-fpm php artisan route:clear
	docker-compose exec php-fpm php artisan config:clear
	docker-compose exec php-fpm php artisan view:clear
	@echo ${BLUE}"Clearing the cache - OK"${END_BLUE}

restart_queue:
	@echo ${BLUE}"Restart queue..."${END_BLUE}
	docker-compose exec php-fpm php artisan queue:restart
	docker-compose stop queue
	docker-compose start queue
	@echo ${BLUE}"Restart queue - OK"${END_BLUE}

stop:
	@echo ${BLUE}"Stopping..."${END_BLUE}
	docker-compose stop
	docker-compose -f ${DOCKER_DATABASE_PATH}/babydriver/docker-compose.yml stop
	docker-compose -f ${DOCKER_DATABASE_PATH}/support/docker-compose.yml stop
	@echo ${GREEN}" "${END_GREEN}
	@echo ${GREEN}"====================================="${END_GREEN}
	@echo ${GREEN}"=     bitpanda is stopped. Bye!    ="${END_GREEN}
	@echo ${GREEN}"====================================="${END_GREEN}
	@echo ${GREEN}" "${END_GREEN}
	@echo ${BLUE}"Stopped!"${END_BLUE}

fix_files_owners_and_permissions:
	@echo ${BLUE}"Fixing files owners and permissions..."${END_BLUE}
	docker-compose exec php-fpm chown -R $(shell id -u):$(shell id -g) /application/storage/logs
	docker-compose exec php-fpm chown -R $(shell id -u):$(shell id -g) /application/database/migrations
	@echo ${BLUE}"Fixing files owners and permissions - OK"${END_BLUE}


ssl_renew:
	@echo ${BLUE}"Renew your certificates..."${END_BLUE}
	openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker/nginx/ssl/nginx.key -out docker/nginx/ssl/nginx.crt -subj "/C=AT/ST=AT/L=Vienna/O=Bambinifashion/OU=IT/CN=bitpanda.bambinifashion.local"
	@echo ${BLUE}"Renew your certificates - OK!"${END_BLUE}

#add_certificate_authority:
#	@echo ${BLUE}"Installing CA..."${END_BLUE}
#	cp ${CHECKOUT_PROJECT_PATH}/docker/nginx/ssl/nginx.crt ./docker/secure-nginx.crt
#	docker-compose exec php-fpm cp ./docker/secure-nginx.crt /usr/local/share/ca-certificates
#	docker-compose exec php-fpm update-ca-certificates
#	@echo ${BLUE}"Installing CA - done"${END_BLUE}

ready:
	@echo ${GREEN}" "${END_GREEN}
	@echo ${GREEN}"====================================="${END_GREEN}
	@echo ${GREEN}"=   Bitpanda is ready. Enjoy!      ="${END_GREEN}
	@echo ${GREEN}"====================================="${END_GREEN}
	@echo ${GREEN}" "${END_GREEN}
