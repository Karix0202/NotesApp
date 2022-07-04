# NotesApp
### My first project in Symfony

Download project, if you haven't done it yet:
```
git clone https://github.com/Karix0202/NotesApp.git
```
Install dependencies:
```
composer install
```
Migrate:
```
php bin/console doctrine:migrations:migrate
```
Load some fake data:
```
php bin/console doctrine:fixtures:load
```
Run the app:
```
php -S 127.0.0.1:8000 -t public
```