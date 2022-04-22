# PHP amphp/parallel example

## Setup

```bash
composer install
```

You can use docker to test it with PHP 7.1, see `docker-compose.yml`

## Run

```bash
time php src/command.php
```

The script parallel gets paginated data from a mock service. 

The final results will have data from page 1 to last page in order. 

And the maximum execution time will be the max `sleep_seconds`.
