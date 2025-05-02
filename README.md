Hello everyone! 👋

This is a testing project built on **Laravel 12** with a **MySQL** database, fully containerized using **Docker** via **Laravel Sail**. It integrates **Laravel Scout** with the **Typesense** driver for lightning-fast full-text search and is seeded with **1,000,000** Product records to showcase high-throughput indexing and querying.  
On the frontend, we use **jQuery** to render and search the product list, and—for simplicity—our `/products` route returns a Blade view directly instead of going through a conventional controller.  
Feel free to clone, explore the Docker setup, and see how Scout + Typesense performs at scale!

Some installing steps:
1.	Install & Configure Sail
    a.	Require Sail (if you haven’t already):
        composer require laravel/sail --dev
        php artisan sail:install
    b.	php artisan sail:install --with=mysql,redis,typesense
2.	Publish & Customize the Dockerfile (Optional)
    a.	php artisan sail:publish
3.	Environment Variables & Startup
    SCOUT_DRIVER=typesense
    TYPESENSE_HOST=typesense
    TYPESENSE_PORT=8108
    TYPESENSE_PROTOCOL=http
    TYPESENSE_API_KEY=masterKey
4.	Install docker
    a.	Download from https://docker.com and install
    b.	Check and verify by open terminal and run: docker –version
    c.	Once Docker is running, navigate back to your project and re-run:
        ./vendor/bin/sail up -d
5.	Clear and rebuild your containers by running:
        ./vendor/bin/sail down
        ./vendor/bin/sail up -d –build

6.	Verify Typesense
    curl -H "X-TYPESENSE-API-KEY: masterKey" http://localhost:8108/health

7.	Proceed with Scout & Typesense Setup
    a.	Add Searchable trait to your models
    b.	Run php artisan scout:import "App\\Models\\Product"
    c.	Test a search:
        $results = App\Models\Product::search('shirt')->get();

8.	Cast Your Model’s ID to a String
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

9.	Correct Your Typesense Schema in config/scout.php
Under model-settings → App\Models\Product, define id as type string (or omit it entirely—Typesense will auto-handle id as a string):

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

Aligning your schema’s id field with Typesense’s requirement avoids the malformed-request error

10.	Flush and Reimport Your Index
    php artisan config:clear
    php artisan scout:flush "App\\Models\\Product"
    php artisan scout:import "App\\Models\\Product"

