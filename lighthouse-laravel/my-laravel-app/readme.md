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
- `Mutation` In contrast to the Query type, the fields of the `Mutation type` are `allowed to change data on the server`. In other words, you can insert, update, delete db data with `Mutation type`.
```graphql
type Mutation {
  createUser(name: String!, email: String!, password: String!): User
  updateUser(id: ID, email: String, password: String): User
  deleteUser(id: ID): User
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
- Scalar for type 
```graphql
scalar Email @scalar(class: "MLL\\GraphQLScalars\\Email")
```
- By using Enum... Queries now return `meaningful names instead of magic numbers`. (If the internal value of the enum is the same as the field name, @enum can be omitted)
