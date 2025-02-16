<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Illuminate\Support\Carbon;


class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'حركة الطلبات خلال آخر 7 أيام';
    protected function getData(): array
    {
        $dates = collect(range(6, 0))->map(function ($daysAgo) {
            return Carbon::now()->subDays($daysAgo)->format('Y-m-d');
        });

        $orders = Order::whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->selectRaw('DATE(created_at) as date, COUNT(id) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $ordersData = $dates->map(fn ($date) => $orders[$date] ?? 0)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'عدد الطلبات',
                    'data' => $ordersData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $dates->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // يمكن تغييره إلى 'bar' أو 'pie' حسب الحاجة
    }
}
