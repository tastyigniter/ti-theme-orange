<?php

namespace Igniter\Orange\Classes;

use Exception;
use Igniter\Orange\Contracts\AutocompleteService;
use Igniter\System\Facades\Country;
use Igniter\System\Models\Country as ModelCountry;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class OSNominatimApiService implements AutocompleteService
{

    public function search(string $query): array
    {
        $response = $this->client()
            ->get('search', [
                'q' => $query,
                'format' => 'json',
                'countrycodes' => strtolower(Country::getCountryCodeById(ModelCountry::getDefaultKey()))
            ]);

        if ($response->failed()) {
            throw new Exception('Error fetching suggestions: ' . $response->body());
        }
        try {
            $data = $response->json();
            if (!empty($data)) {
                return collect($data)
                    ->map(fn($item) => [
                        'placeId' => $item['place_id'],
                        'title' => $item['name'],
                        'description' => $item['display_name'],
                        'lat' => $item['lat'] ?? null,
                        'lon' => $item['lon'] ?? null,
                        'geocoder' => 'nominatim'
                    ])->toArray();
            }
            return [];
        } catch (Exception $e) {
            //TODO: Report error
            throw new Exception('Error processing suggestions: ' . $e->getMessage());
        }
    }

    public function getSearchPosition(string|int $placeId): array
    {
        throw new Exception('OSNominatim does not support getSearchPosition method');
    }

    protected function client(): PendingRequest
    {
        return Http::withHeader('Referer', request()->fullUrl())
            ->withUserAgent(request()->userAgent())->acceptJson()
            ->baseUrl('https://nominatim.openstreetmap.org');
    }
}
