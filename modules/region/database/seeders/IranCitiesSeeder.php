<?php

declare(strict_types=1);

namespace Sadegh19b\LaravelIranCities\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Region\Models\City;
use Modules\Region\Models\Country;
use Modules\Region\Models\Province;

class IranCitiesSeeder extends Seeder
{
    public function run(): void
    {
        $provincesPath = __DIR__ . '/../../resources/data/provinces.json';
        $countiesPath  = __DIR__ . '/../../resources/data/counties.json';
        $citiesPath    = __DIR__ . '/../../resources/data/cities.json';

        $provinces = json_decode(file_get_contents($provincesPath), true);
        $counties  = json_decode(file_get_contents($countiesPath), true);
        $cities    = json_decode(file_get_contents($citiesPath), true);

        usort($provinces, fn ($a, $b): int => strcmp((string) Arr::get($a, 'name'), (string) Arr::get($b, 'name')));
        usort($counties, fn ($a, $b): int => strcmp((string) Arr::get($a, 'name'), (string) Arr::get($b, 'name')));
        usort($cities, fn ($a, $b): int => strcmp((string) Arr::get($a, 'name'), (string) Arr::get($b, 'name')));

        $cities = array_filter($cities, fn ($c): bool => ! preg_match('/\d/', (string) Arr::get($c, 'name')));

        foreach ($provinces as $provinceData)
        {
            $province = Province::query()
                ->firstOrCreate(['name' => Arr::get($provinceData, 'name')], ['tel_prefix' => Arr::get($provinceData, 'tel_prefix')]);

            $provinceCounties = array_filter($counties, fn ($c): bool => Arr::get($c, 'province_id') === Arr::get($provinceData, 'id'));

            foreach ($provinceCounties as $countyData)
            {
                $county = Country::query()
                    ->firstOrCreate(['province_id' => $province->id, 'name' => Arr::get($countyData, 'name')]);

                $countyCities = array_filter($cities, fn ($c): bool => Arr::get($c, 'county_id') === Arr::get($countyData, 'id'));

                foreach ($countyCities as $cityData)
                {
                    City::query()
                        ->firstOrCreate(['county_id' => $county->id, 'name' => Arr::get($cityData, 'name')], ['province_id' => $province->id]);
                }
            }
        }
    }
}
