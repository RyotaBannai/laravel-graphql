### Get started
- These are steps you take.
    - `composer install` to  install all laravel packages
    - `npm run dev` to install all node modules used in this laravel project.
    - create `migrations` table by hitting `create table migrations(id int(10) NOT NULL AUTO_INCREMENT, migration varchar(255), batch int(11), primary key(id));` and then make sure to change authentication method by hitting `alter user 'root'@'localhost' identified with mysql_native_password by 'root';`
    - hit the migration command `php artisan migrate`
    - insert seeds `php artisan db:seed`
    - run artisan server by hitting `php artisan serve`
    - access the Graphql playground route `http://localhost:8000/graphql-playground`
    - and finally _graphqling_ like bellow.
```graphql
query {
  articles(count: 10) {
    data {
      title
      author {
        name
      }
    }
  }
}
```
   - and there you go. you just got started graphql.
    
