# Wishlist API

Wishlist API is a Symfony + API Platform application allowing users to manage their and view other's wishlists. There is also a console command allowing to export wishlist report to a CSV file


# Features

## API Platform
The application is created using Symfony 5 with API Platform and is running in Docker.
API Platfrom is a really powerful REST and GraphQL framework. It helps create a really reliable and stable API which can be really easily documented, tested and extended. API Platform gives a fully working CRUD API for all registered entities out of the box. There is no need to re-write CRUD over an over again pulling data through all layers of MVC by yourself which makes it much more stable and reliable. API platform supports multiple formats for normalization/denormalization so every endpoint can easily accept almost any request format and return the response in any suitable format too. Searching, filtering and pagination are available from under the hood too and can be easily configured using annotations. Plus API Platform has swagger installed by default.
## Authentication and Security
Application has a security level with api-key authentication configured. Only authenticated users can get access to the resources using API. The api key is sent in a "*X-KEY*" header (can be configured using parameters). Swagger is already configured for this, so you can authenticate by clicking "Authorize" in a top-right corner of the page and pasting the API key in the field.
**Where to get the API key from?**
As one of the application setup steps you can apply fixtures adding two users to the database. API keys are generated per every user and are basically uuids. So after applying fixtures you can find the desired API key in the database (tblUser table). Alternatively you can create user using the API. POST /users is the only endpoint requiring no authentication to use. 

Except for the Symfony Guard Authenticator there are a couple more security features:

 **Ownership Resolver.** Ownership resolver is a service allowing to get the owner of any entity instance in the database. It is wrapped into OwnershipValidator and is used in the following places:
 

 1. *IsResourceOwner* constraint validator. This constraint is being applied to any field which should only be writable to it's owner (e.g. once you create a wishlist item you should only be able to link it to a wishlist owned by you). The validation takes place once the entity is persisted.
 2. *AccessControlNormalizer* - is a custom normalizer decorating the default API Platform normalizer. It is used to configure normalization and denormalization context so that no sensitive data is outputted to anyone, but the owner (e.g. if you call GET /users/{id} with not yours user ID the apiKey field will not be added to the response as it will be filtered out by the dynamic normalization context).

**"ME" alias**
For the GET /user/{id} endpoint you can use "**me**" alias instead of id to get current authenticated user details. This is achieved by creating a custom KernelEventSubscribers.
## Wishlist Report
As API Platform s a really powerful tool it allows to easily implement a wishlist report generation and CSV formatting functionality literally without writing any custom code except for a couple getter entity methods to behave as a virtual property accessor. This is I why this feature is implemented too (GET /wishlists/export). It event allows to select from a number of formats to serialize data to. 
Though this approach has a couple of cons:

 1. API Platform uses ORM a lot and pagination is disabled for this endpoint (obviously because this is a report) which can lead to serious efficiency issues if there's huge volumes of data in the DB.
 2. I have to mention that the task was to create a command for the data export. API Platform can not be used as a service. It's only entrypoint is one single vendor controller action accepting all requests and forwarding them to internal services. As Symfony commands are fully isolated from HTTPKernel it makes impossible to just forward the call to ApiPlatfrom controller action (even this would be a bad practice in case it would be possible). So the only option to reuse the API endpoint was to call API as an external service from the command which is an awful option. This is why it was decided to create separate services  for reports data gathering and formatting but slightly improve it to fix the issue mentioned in pt. 1. This is why the data is being fetched by *WishlistReportDataFetcher* in batches of the configurable size, the next batch beginning is identified by latest fetched item id (which increases efficiency in comparison with using *OFFSET*),  and Doctrine is operating the data in PDO mode which increases efficiency even more. The command name is *app:wishlist-report-generate*, so you can run it using 

> make console command="app:wishlist-report-generate"

You can pass a filename as an option and *--force* / *-f* flag to run the command with no additional input requested. If no filename was specified the command generates the filename automatically

> make console command="app:wishlist-report-generate report.csv --force"

So currently there are two options of generating a wishlist report.

## Docker
The application is running in Docker with Nginx + fpm PHP 7.3 and MySQL 5.6 instance.
HTTP port is forwarded to 8888 so you don't likely have to stop your local web server in case it is running.
The environment is fully configured to work and be operated from Docker container, so
there's a Makefile configured which gives you a list of most useful commands which will be forwarded into the container.
## Unit Tests
It is a bit tricky to find a service to cover with unit tests because most of the logic is handled by API Platform, so there's only two unit tests running with PHPUnit 8.5 and "unit-test" Makefile command to run them.

# Setup
In order to start the project execute the following commands:
> touch .env.local
> make start
> make composer command="install"
> make console command="doctrine:database:create"
> make console command="doctrine:migrations:migrate"

Or just run

> ./setup_environment.sh

If you would like to apply fixtures adding a couple of products and users you can run the following command:
> make console command="doctrine:fixtures:load"

in order to run unit tests:
> make unit-test
>
in order to run cs-fixer inspection:
> make php-cs-fixer
