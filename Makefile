TAG_DEV=w7493/framework

help:
	@echo "'deploy' - Deploy project. Use 127.0.0.1:8080 in your browser"
	@echo "'delete' - Remove project"
	@echo "'build' - Build docker image"
	@echo "'composer.install' - Install vendors using the composer.lock file"
	@echo "'composer.require package='core/something ^1.0' - Add a package to composer.json"
	@echo "'composer.remove package='core/something ^1.0' - Remove a package to composer.json"
	@echo "'composer.update' - Update vendors"
	@echo "'test' - Run unit tests"
	@echo "'docker.attach' - Attach your terminal into a docker shell"

.PHONY: deploy
deploy: build
	docker-compose up -d

.PHONY: delete
delete:
	docker-compose down

.PHONY: build
build:
	docker build -t ${TAG_DEV}:latest .

.PHONY: composer.install
composer.install:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer install --prefer-dist

.PHONY: composer.require
composer.require:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer require ${package}

.PHONY: composer.remove
composer.remove:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer remove ${package}

.PHONY: composer.update
composer.update:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest composer update

.PHONY: test
test:
	docker run --rm -i -v $(shell pwd):/app -t ${TAG_DEV}:latest bin/phpunit test

.PHONY: docker.attach
docker.attach:
	docker run --rm -i -v $(shell pwd):/app -ti ${TAG_DEV}:latest /bin/bash
