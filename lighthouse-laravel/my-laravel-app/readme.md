## Creat your own environment
- `composer install` to install all required package.
- `composer require nuwave/lighthouse` to install GraphQL client for Laravel.
- `composer require mll-lab/laravel-graphql-playground` to play around send query from web browser with GraphQL.
-  If you don't have GraphQL schema. (`php artisan vendor:publish --provider="Nuwave\Lighthouse\LighthouseServiceProvider" --tag=schema`)
- `docker-compose exec app bash` to get inside Docker.
- `cd my-laravel-app && php artisan migrate --seed` to migrate all required tables and run seed.
-  Access to `localhost:8000/graphql-playground` to do some queries. 
-  Or use Postman to do GraphQL, which might be faster.
## Notes
- Just like in Eloquent, we express the relationship between our types using the `@belongsTo` and `@hasMany` directives
- `Renaming Relations`: 
```graphql
type Post {
  author: User! @belongsTo(relation: "user")
}
```
- A `schema`: defines the capabilities of a GraphQL server. Much like a database schema, it describes the structure and the types your API can return.
- A `trailing exclamation mark `is used to denote a field that uses a `Non‐Null` type like this: `name: String!`.
- `Input`: When `non-null` is applied to the type of an input, like an argument, input object field or a variable, it makes that `input required`. For example:
```graphql
type Query {
  getUser(id: ID!, status: Status): User
}
```
- the `id argument` is non-null. because the status argument is `nullable`, it's `optional` and can be omitted. This applies to variables as well:
```graphql
query MyQuery ($foo: ID!) {
    getUser(id: $foo)
 }
```

|Argument|Variable|Valid?|
|:---:|:---:|:---:|
| String   | String   |   ✅   |
| String   | String!  |   ✅   |
| String!  | String   |   ❌   |
| String!  | String!  |   ✅   |
- [Ref](https://stackoverflow.com/questions/50684231/what-is-an-exclamation-point-in-graphql)
### The **Root** Types
- `Query`: Every GraphQL schema **must** have a `Query type` which contains `the queries your API offers`. Think of `queries as REST resources` which can take arguments and return a fixed result.
- `Mutation` In contrast to the Query type, the fields of the `Mutation type` are `allowed to change data on the server`. In other words, you can insert, update, delete db data with `Mutation type`. <<`You don't need to define create, update methods in Eloquent model to do this. ALl completed by GraphQL.`>>
- When you use `input` type, you do need to **wrap variables** with `input{}`. If don't then put them in parentheses `methodName([here])`
```graphql
type Mutation {
  createUser(name: String!, email: String!, password: String!): User
  updateUser(id: ID, email: String, password: String): User
  deleteUser(id: ID): User
}
```
- If the name of the Eloquent model does not match the return type of the field, or is located in a non-default namespace, set it with the `model` argument.
```graphql
type Mutation {
  createPost(title: String!): Post @create(model: "Foo\\Bar\\MyPost")
}
```
- `Subscription`: Rather than providing a single response, the fields of the Subscription type return a stream of responses, with real-time updates. 
```graphql
type Subscription {
  newUser: User
}
```
### **Types**
- `Object Type` are closely related to `Eloquent models`.
- Scalar for type. You can also use third-party scalars like `Email`.
```graphql
scalar Email @scalar(class: "MLL\\GraphQLScalars\\Email")
```
```shell script
composer require mll-lab/graphql-php-scalars
```
- The above type spit an error if input is invalid email type. So no need validation on Laravel itself. 
```shell script
"message": "Field \"createUser\" argument \"input\" requires type Email!, found \"ryota\"; The given string \"ryota\" is not a valid Email.",
```
- By using Enum... Queries now return `meaningful names instead of magic numbers`. (If the internal value of the enum is the same as the field name, @enum can be omitted)
- The GraphQL `interface`: It defines `a set of common fields` that all implementing types must also provide. A common use-case for interfaces with a Laravel project would be `polymorphic relationships`. (an abstract type)
- You can also provide a custom type resolver. Run `php artisan lighthouse:interface <Interface name>` to create a custom interface class

### Field
- _Every_ field has a function associated with it that is called when the field is requested as part of a query. This function is called a `resolver`.
- By default, `Lighthouse` looks for a class with `the capitalized name of the field` in `App\GraphQL\Queries` or `App\GraphQL\Mutations` and calls its `__invoke` function with the usual resolver arguments.
- to create resolver: 
```shell script
php artisan lighthouse:query Hello
```
- just as simple as put like 
```graphql
query{
  hello
}
```
- then the return to below will..
```json
{
    "data": {
        "hello": "world!"
    }
}
```
```graphql
type Query {
  user: User!
}

type User {
  id: ID!
  name: String!
  email: String
}
```
- First graphql resolves the `User!` which is `App\Model\User`, then id and email (`the field sub-selection`) are resolved.
- Conveniently, `the first argument of each resolver` is `the return value of the parent field`, in this case a User model.
- A naive implementation of  a resolver for id might look like this:
```php
<?php

use App\Models\User;

function resolveUserId(User $user): string
{
    return $user->id;
}
```
- but this can get repetitive as methods increase, so use fourth and fifth resolver argument(which will give us access to the requested field name, to dynamically access the matching property.) 
```php
<?php

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

function resolveUserAttribute(User $user, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
{
    return $user->{$resolveInfo->fieldName};
}
```
- Fortunately, **the underlying GraphQL implementation already provides a sensible default resolver**, that plays quite nicely with the data you would typically return from a root resolver, e.g. Eloquent models or associative arrays. This means that in most cases, **you will only have to provide resolvers for the root fields** and make sure they return data in the proper shape.
- If you need to implement custom resolvers for fields that `are not on one of the root types Query or Mutation`, you can use either the `@field` or `@method` directive. You may also **change the default resolver** if you need.
```graphql
type User {
  mySpecialData: String! @method(name: "getMySpecialData")
}
```
### Eloquent
- Pagination: You can leverage the `@paginate` directive to query a large list of models in chunks.
```graphql
type Query {
  posts: [Post!]! @paginate
}
```
- this automatically transformed to this:
```graphql
type Query {
  posts(first: Int!, page: Int): PostPaginator
}

type PostPaginator {
  data: [Post!]!
  paginatorInfo: PaginatorInfo!
}
```
### Schema Organisation
- As you add more and more types to your schema, it can grow quite large. Learn how to split your schema across multiple files and organise your types.
- Imports always begin on a separate line with `#import`, followed by `the relative path` to the imported file. The contents of other.graphql are pasted in the final schema.
- The orders of importing files `won't cause any dependency problems` as long as you import all needed files!
- glob is like this. 
```graphql
#import post/*.graphql
```
- Now you want to add a few queries to actually fetch posts. You could add them to the `main Query type` in your main file, but `that spreads the definition apart`:(, and `could also grow quite large over time` :(. Another way would be to `extend the Query type` and `colocate the type definition` with its Queries in other.graphql, something like below.
```graphql
type Post {
  title: String
  author: User @belongsTo
}

extend type Query {
  posts: [Post!]! @paginate
}
```
- Apart from object types type, you can also extend `input, interface and enum types`. Lighthouse will merge the fields (or values) with the original definition and **always produce a single type in the final schema**.
### Built-in directives
- Adding `Query Constraints`: @create, @update, @upsert, @delete
