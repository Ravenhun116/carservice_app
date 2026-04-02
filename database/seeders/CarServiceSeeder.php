<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Car;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CarSerViceSeeder extends Seeder
{
    public function run(): void
    {
        if (Client::count() == 0) {
            $clients = json_decode(File::get(database_path('data/clients.json')), true);

            //eltérés van a mezőnévabe a db-ben és a jsonben
            $clients = array_map(function($client) {
                return [
                    'id' => $client['id'],
                    'name' => $client['name'],
                    'card_number' => $client['idcard'],
                ];
            }, $clients);

            Client::insert($clients);
        }

        if (Car::count() == 0) {
            $cars = json_decode(File::get(database_path('data/cars.json')), true);
            Car::insert($cars);
        }

        if (Service::count() == 0) {
            $services = json_decode(File::get(database_path('data/services.json')), true);

            //eltérés van a mezőnévabe a db-ben és a jsonben
            $services = array_map(function($service) {
                return [
                    'id' => $service['id'],
                    'client_id' => $service['client_id'],
                    'car_id' => $service['car_id'],
                    'log_number' => $service['lognumber'],
                    'event' => $service['event'],
                    'event_time' => $service['eventtime'] ?? null,
                    'document_id' => $service['document_id'],
                ];
            }, $services);  

            //constraint miatt kell
            $uniqueData = [];
            $services = array_filter($services, function($service) use (&$uniqueData) {
                $key = $service['car_id'] . '-' . $service['log_number'];
                if (in_array($key, $uniqueData)) {
                    return false;
                }
                $uniqueData[] = $key;
                return true;
            });
            

            Service::insert(array_values($services));
        }
    }
}
