<?php

declare(strict_types=1);

namespace Modules\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

final class UsersChart extends ApexChartWidget
{
    /**
     * Chart Id.
     */
    protected static ?string $chartId = 'usersChart';

    /**
     * Widget Title.
     */
    protected static ?string $heading = 'Total users';

    /**
     * Sort.
     */
    protected static ?int $sort = 2;

    /**
     * Widget content height.
     */
    protected static ?int $contentHeight = 270;

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options.
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type'    => 'line',
                'height'  => 250,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => 'Users',
                    'data' => [4344, 5676, 6798, 7890, 8987, 9388, 10343, 10524, 13664, 14345, 15753, 16398],
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels'     => [
                    'style' => [
                        'fontWeight' => 400,
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontWeight' => 400,
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'fill' => [
                'type'     => 'gradient',
                'gradient' => [
                    'shade'            => 'dark',
                    'type'             => 'horizontal',
                    'shadeIntensity'   => 1,
                    'gradientToColors' => ['#ea580c'],
                    'inverseColors'    => true,
                    'opacityFrom'      => 1,
                    'opacityTo'        => 1,
                    'stops'            => [0, 100, 100, 100],
                ],
            ],

            'dataLabels' => [
                'enabled' => false,
            ],
            'grid' => [
                'show' => false,
            ],
            'markers' => [
                'size' => 2,
            ],
            'tooltip' => [
                'enabled' => true,
            ],
            'stroke' => [
                'width' => 4,
            ],
            'colors' => ['#f59e0b'],
        ];
    }
}
