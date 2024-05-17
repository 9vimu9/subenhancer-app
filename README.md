## How to set up the application

```bash
cp .env.example .env
```

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

```bash
./vendor/bin/sail up
```

```bash
./vendor/bin/sail artisan key:generate
```

```bash
./vendor/bin/sail artisan migrate
```
```bash
./vendor/bin/sail artisan db:seed
```

## Running Tests 
```bash
./vendor/bin/sail  artisan test
```

![img.png](test_status.png)
```bash
./vendor/bin/sail  artisan test --coverage
```

![img.png](test_coverage.png)

## Other Resources
### ER Diagram

![img.png](e_r_diagram.png)
Click [here](https://dbdiagram.io/d/sub-enhancer_v_1-65d78b9a5cd04127749817b7) to see the latest version
