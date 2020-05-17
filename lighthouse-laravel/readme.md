## Creat your own environment
- `composer install` to install all required package.
- `composer require nuwave/lighthouse` to install GraphQL client for Laravel.
- `composer require mll-lab/laravel-graphql-playground` to play around send query from web browser with GraphQL.
-  If you don't have GraphQL schema. (`php artisan vendor:publish --provider="Nuwave\Lighthouse\LighthouseServiceProvider" --tag=schema`)
- `docker-compose exec app bash` to get inside Docker.
- `cd my-laravel-app && php artisan migrate --seed` to migrate all required tables and run seed.
-  Access to `localhost:8000/graphql-playground` to do some queries. 
-  Or use Postman to do GraphQL, which might be faster. (or throw query from PhpStorm) 
