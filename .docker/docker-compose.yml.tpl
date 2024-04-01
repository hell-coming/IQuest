version: "3"
services:
  front:
    image: ${CI_REGISTRY_IMAGE}/front:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-front
    networks:
      - server
  back:
    image: ${CI_REGISTRY_IMAGE}/back:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back
    volumes:
      - ./storage:/app/storage/app/public
    env_file:
      - .env
    networks:
      - server
  back-schedule:
    image: ${CI_REGISTRY_IMAGE}/back:${CI_COMMIT_TAG}
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-back-schedule
    entrypoint: ["/usr/local/bin/php", "artisan", "schedule:work"]
    volumes:
      - ./storage:/app/storage/app/public
    env_file:
      - .env
    networks:
      - server
  db:
    image: harbor.tomsk-it.ru/dockerhub/bitnami/postgresql:15.3.0-debian-11-r17
    container_name: ${CI_PROJECT_NAME}-${CI_ENVIRONMENT_NAME}-db
    environment:
      - POSTGRESQL_USERNAME=${DB_USERNAME}
      - POSTGRESQL_PASSWORD=${DB_PASSWORD}
      - POSTGRESQL_DATABASE=${DB_DATABASE}
    volumes:
      - ./postgresql_data:/bitnami/postgresql
    networks:
      - server
networks:
  server:
    external: true
