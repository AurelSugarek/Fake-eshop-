# Použije PHP built-in server
FROM php:8.2-cli

WORKDIR /app
COPY . /app

EXPOSE 1000

CMD ["php", "-S", "0.0.0.0:1000", "-t", "."]
