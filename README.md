## Simplestream Coding Task by Jonathan Pagel

## Install
- `git clone git@github.com:jpagel/simplestream_epg.git`
- `cd simplestream_epg/`
- `composer install`

## Configure
- in your local dev mysql instance, create 2 new databases (`epg_dev` and `epg_testing`)
- `cp .env.example .env`
- `cp .env.testing .env.testing`
- populate `.env` and `.env.testing` with your database settings

## Run Tests
`./vendor/bin/phpunit tests/`

## Populate your Dev Database
`php artisan migrate:fresh --seed`

## Start HTTP server
`php artisan serve`

Your service should be available on `http://localhost:8000`. Try the channel list endpoint at 
`http://localhost:8000/api/channels`

## Documents
Database schema is in `schema.mwb` (for opening in Mysql Workbench) and `schema.png` (for opening as an image).

There are some sample Postman calls described in `Simplestream EPG.postman_collection.json`, but the programme and 
channel requests will require modification before they will work. The seeder generate random uuids every time it is
run, so you will have to adjust the urls to reflect your own data. The `list channels` request should work without
modification.


## Files relevant to the task
- `app/Http/Controllers/Api.php`
- `app/Http/Resources/Channel.php`
- `app/Http/Resources/Programme.php`
- `app/Http/Resources/ProgrammeCollectionResource.php`
- `app/Models/Channel.php`
- `app/Models/Programme.php`
- `app/Models/Timetable.php`
- `database/factories/ProgrammeFactory.php`
- `database/factories/TimetableFactory.php`
- `database/migrations/2020_09_15_142035_channel.php`
- `database/migrations/2020_09_15_142042_programme.php`
- `database/migrations/2020_09_15_142057_timetable.php`
- `database/seeders/ChannelSeeder.php`
- `database/seeders/DatabaseSeeder.php`
- `database/seeders/ProgrammeSeeder.php`
- `database/seeders/TimetableSeeder.php`
- `routes/api.php`
- `tests/Feature/ApiFeaturesTest.php`
- `tests/Models/TimetableTest.php`

## Things I did not do
- There is no exception handling: given more time I would have thrown appropriate exceptions and generated
400 and 404 responses for invalid URLs
- Happy paths only are tested: given more time I would write tests for error cases eg `HTTP Not Found`
- There is no authentication. I would expect to add it as middleware and use the `WithoutMiddleware` trait
in the functional tests.
- There is no specific domain logic. In a more complicated system I would expect to write service classes in a
`Domain` folder.
- To meet the spec, the timezone is included in the channel-specific timetable request and does affect the time slice
of the query: however the displayed times are still in UTC. Given more time I would write a timezone handler into
the ProgrammeCollectionResource which would correct the displayed time.
- Standard timezones tend to contain slashes (eg `America/Curacao`). To make the timezone URL-compliant, we use 
a hyphen in the URL eg `America-Curacao`. I considered that this would be more readable than url-encoding it.
