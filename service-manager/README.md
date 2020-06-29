# Service Manager

## Build Setup

```bash
# Install Composer Dependency
$ composer install

# Add your database configuration then migrate
$ php artisan migrate

# Generate JWT Secrect Key and make sure it's updated in .env file
$ php artisan jwt:secret

# Run your project to a specific port
$ php artisan serve --port=8000
```
    
