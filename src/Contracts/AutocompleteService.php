<?php

namespace Igniter\Orange\Contracts;

interface AutocompleteService
{
    public function search(string $query): array;

    public function getSearchDetails(string $placeId): array;
}
