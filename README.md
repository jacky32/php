# Run app in dev environment

```bash
  docker compose up
```

# Compile composer packages to /vendor

```bash
  docker compose exec php_app composer install --no-dev --prefer-dist
```

# External libraries used

## delight-im/PHP-auth

- for user authentication
- https://github.com/delight-im/PHP-Auth?tab=readme-ov-file#usage
