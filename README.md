# auth service

## mysql, php, laravel, APIs,

### ERD, MVC, Middleware

1. starting specify entities (User, Role, Permission) and drawing ERD to specify relationship between entities

2. create models and set relations and constraints then migrate

![alt text](https://user-images.githubusercontent.com/59757757/138011401-053c25a0-39e3-4873-8289-b9104d27074d.png)


3. but seeds for users, roles, permissions
4. install JWT package and
5. Create AuthController and write (register, login, logout) methods then create apis routes

# in our challenge

## - first identify and secure user's session by create Token with life time for user using JWT

## - I use MySQL as Datastore

## - keep user's session valid by session life time in (config/auth.php) expire time is the number of minutesthat the reset token should be considered valid

## - way to force invalidating sessions by using Logout end-point to invalidate the token with authrization or send it in bady of request

================

# Structure

## - (Roles and permissions) allways system structure must care about business Logic if our system allows to users have multi roles then [User and Roles] => [ many to many ] with pivot table else [many to one] otherwise Roles and permission one role have muliple permission and one permission can be in multiple roles so [M to N]

================

# assign specific user a specific role or permission

## we can do that by useing end-point (api/admin/user-role) to specify role for user Or create new role (api/admin/add-role) and new permissions (api/admin/add-permission) and give user this new role

==============

# authorization

validating whether logged user is permitted to do specific action or not.

## we can do that by using middlewares (IsAdmin, Ismanager) based on role and specify permissions for roles you can see Admin middleware in (app/Http/Middleware) - Or - we checks roles in controllers in methods of actions but i not prefer this way becouse (the middleware is awsome )

# Test

## i using postman to test end-points and check response in all possible scenarios

![alt text](https://user-images.githubusercontent.com/59757757/138284556-282d654c-f93b-4ac3-8c1f-5cf90fca26eb.PNG)
