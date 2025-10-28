# Installing

Clone this project:

```shell
git clone git@github.com:cazak/images.git
```

Init project:

```shell
make init
```

Check `Makefile` for other commands

# Images

Project structure:
```
.
├── docker/              # Образы nginx, php-fpm, php-cli
├── src/                 # PHP код приложения
    .../
    └── Model
        └── Example
            └── Application
            └── Domain
            └── Infrastructure
            └── Test
    .../
├── templates/           # Twig шаблоны
├── public/              # Публичные файлы (включая сборку фронтенда)
│   └── build/           # Сюда собирает Webpack Encore
├── assets/              # JS/CSS ресурсы
├── package.json         # NPM конфигурация
├── composer.json        # PHP зависимости
├── docker-compose.yml   # Docker окружение
```
