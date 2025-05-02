Hello everyone! 👋

This is a testing project built on **Laravel 12** with a **MySQL** database, fully containerized using **Docker** via **Laravel Sail**. It integrates **Laravel Scout** with the **Typesense** driver for lightning-fast full-text search and is seeded with **1,000,000** Product records to showcase high-throughput indexing and querying.  
On the frontend, we use **jQuery** to render and search the product list, and—for simplicity—our `/products` route returns a Blade view directly instead of going through a conventional controller.  
Feel free to clone, explore the Docker setup, and see how Scout + Typesense performs at scale!

## Getting Started

### Clone the Repository
To get started, clone this repository to your local machine:

```bash
git clone https://github.com/lomhodev/laravel-typo-search-with-typesence.git
cd laravel-typo-search-with-typesence
```

### Install Laravel Dependencies
Ensure you have Composer installed, then run the following command to install Laravel dependencies:

```bash
composer install
```

### Generate Application Key
After installing dependencies, generate the application key:

Next, copy the `.env.example` file to create your `.env` file:

### Run Migration 
To run the database migrations and seed the database with sample data, execute the following commands:

```bash
php artisan migrate
php artisan db:seed
```

This will create the necessary database tables and populate them with 1,000,000 Product records for testing.

-----------------------------------------------------------

### Below are steps that I did for this project.:

#### Install Scout
```bash
    composer require laravel/scout
    php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
```

#### To get started using Typesense with Scout, install the Typesense PHP SDK via the Composer package manager:
```bash
    composer require typesense/typesense-php
```

1.	Install & Configure Sail
    a. Require Sail (if you haven’t already):

```bash
    composer require laravel/sail --dev
    php artisan sail:install
```

    b. Install Sail with the required services:

```bash
    php artisan sail:install --with=mysql,redis,typesense
```

2.	Publish & Customize the Dockerfile (Optional)
    a. Publish Sail's Docker configuration files to customize them:

```bash
    php artisan sail:publish
```

3.	Environment Variables & Startup
    Set up environment variables in your `.env` file:

```env
    SCOUT_DRIVER=typesense
    TYPESENSE_HOST=typesense
    TYPESENSE_PORT=8108
    TYPESENSE_PROTOCOL=http
    TYPESENSE_API_KEY=masterKey
```

4. Install Docker:

    a. Download Docker from [https://docker.com](https://docker.com) and install it.
    b. Verify the installation by running the following command in your terminal:

```bash
    docker --version
```

    c.	Once Docker is running, navigate back to your project and re-run:

```bash
        ./vendor/bin/sail up -d
```

5.	Clear and rebuild your containers by running:

```bash
        ./vendor/bin/sail down
        ./vendor/bin/sail up -d --build
```

6.	Verify Typesense:

```bash
    curl -H "X-TYPESENSE-API-KEY: masterKey" http://localhost:8108/health
```

    This command checks the health of your Typesense server. If everything is set up correctly, it should return a response like:

```json
    {
        "ok": true
    }
```

7.	Proceed with Scout & Typesense Setup
    
    a. Add the `Searchable` trait to your models:

```php
    use Laravel\Scout\Searchable;

    class Product extends Model
    {
        use Searchable;
    }
```

    b. Run the following command to import your model's data into Typesense:

```bash
    php artisan scout:import "App\Models\Product"
```

```bash
    php artisan scout:import "App\Models\Product"
```

    c.	Test a search:

```php
    $results = App\Models\Product::search('shirt')->get();

    foreach ($results as $product) {
        echo $product->name . "\n";
    }
```

8.	Cast Your Model’s ID to a String
```php
    use Laravel\Scout\Searchable;

    class Product extends Model
    {
        use Searchable;

        /**
         * Ensure Scout uses a string ID.
         */
        public function getScoutKey(): string
        {
            return (string) $this->getKey();
        }

        /**
         * Prepare the data array for indexing.
         */
        public function toSearchableArray(): array
        {
            $array = $this->toArray();
            $array['id'] = (string) $this->getKey();
            // Cast or add any other fields as needed...
            return $array;
        }
    }
```

9.	Correct Your Typesense Schema in config/scout.php
Under model-settings → App\Models\Product, define id as type string (or omit it entirely—Typesense will auto-handle id as a string):
```php
'model-settings' => [
    App\Models\Product::class => [
        'collection-schema' => [
            'name' => 'products',
            'fields' => [
                ['name' => 'id',   'type' => 'string'],      // ← must be string
                ['name' => 'name', 'type' => 'string'],
                ['name' => 'description', 'type' => 'string'],
            ],
            'default_sorting_field' => 'name',
        ],
        'search-parameters' => [
            'query_by' => 'name,description',
        ],
    ],
],
```

Aligning your schema’s id field with Typesense’s requirement avoids the malformed-request error

10.	Flush and Reimport Your Index
    ```bash
    php artisan config:clear
    php artisan scout:flush "App\\Models\\Product"
    php artisan scout:import "App\\Models\\Product"
    ```

