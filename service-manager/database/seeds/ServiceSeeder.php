<?php

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getRegisteredServices() as $registeredService){
            Service::create($registeredService);
        }
    }


    private function getRegisteredServices() : array
    {
        return [
            [
                'code' => Str::random(32),
                'name' => 'Auth Service',
                'root' => 'http://127.0.0.1:8001/',
                'platform' => 'Laravel 7.4',
                'version' => '1.00',
                'enabled' => true
            ],
            [
                'code' => Str::random(32),
                'name' => 'Purchase Service',
                'root' => 'http://127.0.0.1:8002/',
                'platform' => 'Lumen 7.x',
                'version' => '1.0.5',
                'enabled' => true
            ],
            [
                'code' => Str::random(32),
                'name' => 'Sale Service',
                'root' => 'http://127.0.0.1:8003/',
                'platform' => 'Nodejs v10.19.0',
                'version' => '2.0.5',
                'enabled' => true
            ],
            [
                'code' => Str::random(32),
                'name' => 'Account Service',
                'root' => 'http://127.0.0.1:8004/',
                'platform' => 'Flask',
                'version' => '1.15.5',
                'enabled' => false
            ],
            [
                'code' => Str::random(32),
                'name' => 'Inventory Service',
                'root' => 'http://127.0.0.1:8005/',
                'platform' => 'python',
                'version' => '5.0.0',
                'enabled' => true
            ],
            [
                'code' => Str::random(32),
                'name' => 'Report Service',
                'root' => 'http://127.0.0.1:8006/',
                'platform' => 'Laravel',
                'version' => '5.0.0',
                'enabled' => true
            ]
        ];
    }
}
