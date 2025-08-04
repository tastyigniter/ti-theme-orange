<?php

namespace Igniter\Orange\Classes;

use Exception;
use Igniter\Orange\Contracts\AutocompleteService;
use Igniter\System\Traits\SessionMaker;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GMPlaceApiService implements AutocompleteService
{
    use SessionMaker;

    /**
     * @throws ConnectionException
     * @throws Exception
     */
    public function search(?string $query): array
    {
        if (empty($query)) {
            return [];
        }
        $response = $this->client()
            ->withHeader('X-Goog-FieldMask',
                'suggestions.placePrediction.placeId,suggestions.placePrediction.text.text,suggestions.placePrediction.structuredFormat.secondaryText.text')
            ->post(':autocomplete', [
                'input' => $query,
                'includedRegionCodes' => ['ng'],
                'sessionToken' => $this->getSessionToken(),
            ]);

        $data = $response->json();
        if ($response->failed()) {
            //TODO: Report error
            throw new Exception('Error fetching suggestions: ' . $data['error']['message']);
        }
        try {
            if ($data) {
                return collect($data['suggestions'])
                    ->map(fn($item) => [
                        'placeId' => $item['placePrediction']['placeId'],
                        'title' => $item['placePrediction']['text']['text'],
                        'description' => $item['placePrediction']['structuredFormat']['secondaryText']['text']
                    ])->toArray();
            } else return [];
        } catch (Exception $e) {
            //TODO: Report error
            throw new Exception('Error processing suggestions: ' . $e->getMessage());
        }
    }

    public function getSearchDetails(string $placeId): array
    {
        $response = $this->client()
            ->withHeader('X-Goog-FieldMask', 'formattedAddress,location,shortFormattedAddress')
            ->get('/' . $placeId, [
                'sessionToken' => $this->getSessionToken()
            ]);

        $data = $response->json();
        if ($response->failed()) {
            throw new Exception('Error fetching place details: ' . $data['error']['message']);
        }

        $this->clearSessionToken();
        return [
            'description' => $data['formattedAddress'],
            'latitude' => $data['location']['latitude'],
            'longitude' => $data['location']['longitude']
        ];
    }

    protected function client(): \Illuminate\Http\Client\PendingRequest
    {
        return Http::withHeaders([
            'X-Goog-Api-Key' => setting('maps_api_key'),
        ])->baseUrl('https://places.googleapis.com/v1/places');
    }

    protected function getSessionToken(): string
    {
        $sessionTokenExpiry = $this->getSession('gm_places_session_token_expires_at');

        if (!$sessionTokenExpiry || $sessionTokenExpiry->isPast()) {
            $sessionToken = Str::uuid()->toString();
            $this->putSession('gm_places_session_token', $sessionToken);
            $this->putSession('gm_places_session_token_expires_at', now()->addMinutes(3));
        } else {
            $sessionToken = $this->getSession('gm_places_session_token');
        }

        return $sessionToken;
    }

    protected function clearSessionToken(): void
    {
        $this->forgetSession('gm_places_session_token');
        $this->forgetSession('gm_places_session_token_expires_at');
    }
}
