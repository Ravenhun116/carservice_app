<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Car;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    //Listázza az összes ügyfelet
    public function index()
    {
        $clients = Client::paginate(15);
        return view('clients', ['clients' => $clients]);
    }


    public function getCarsDetails(Client $client)
    {
        $cars = $client->cars->map(function($car) {
        $lastService = $car->services()->orderByDesc('log_number')->first();
        $car->last_event = $lastService?->event;
        $car->last_event_time = $lastService?->event_time;
        return $car;
        });

        return view('cars', ['cars' => $cars]);
    }

    public function getServicesForCar(Car $car)
    {
        $services = $car->services()->orderBy('log_number')->get()->map(function($service) use ($car) {
        return [
            'log_number' => $service->log_number,
            'event' => $service->event,
            'event_time' => ($service->event === 'regisztralt' && !$service->event_time)
                ? $car->registered
                : $service->event_time,
            'document_id' => $service->document_id,
            ];
        });

        return view('services', ['services' => $services]);
    }

    public function search(Request $request)
    {
        if ($request->name && $request->card_number) {
            return response()->json(['error' => 'Mindkét mező ki van töltve, csak az egyiket lehet'], 422);
        }

        if (!$request->name && !$request->card_number) {
            return response()->json(['error' => 'Egy mező kitöltése kötelező!'], 422);
        }

        if ($request->card_number && !preg_match('/^[a-zA-Z0-9]+$/', $request->card_number)) {
            return response()->json(['error' => 'Az okmányazonosító csak betűket és számokat tartalmazzon!'], 422);
        }

        $query = Client::query();

        if ($request->name) {
            $clients = $query->where('name', 'like', '%' . $request->name . '%')->get();

            if ($clients->count() > 1) {
                return response()->json(['error' => 'Több találat van, adjon meg több karaktert!'], 422);
            }

            if ($clients->count() === 0) {
                return response()->json(['error' => 'Nincs találat'], 422);
            }

            $client = $clients->first();
        }

        if ($request->card_number) {
            $client = $query->where('card_number', $request->card_number)->first();

            if (!$client) {
                return response()->json(['error' => 'Nincs találat!'], 422);
            }
        }

        $client->load('services');
        $carCount = $client->cars->count();
        $serviceCount = $client->cars->sum(fn($car) => $car->services->count());

        return response()->json([
            'id' => $client->id,
            'name' => $client->name,
            'card_number' => $client->card_number,
            'car_count' => $carCount,
            'service_count' => $serviceCount,
        ]);
    }
}