FROM php:8.3-cli-alpine

WORKDIR /app

COPY bin/ bin/
COPY data/ data/
COPY src/ src/

CMD ["php", "bin/report.php"]
