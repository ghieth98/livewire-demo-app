<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class TotalRevenueChart extends Component
{
    protected function getData(): array
    {
        $data = Order::query()
            ->select('order_date', DB::raw('sum(total) as total'))
            ->where('order_date', '>=', now()->subDays(7))
            ->groupBy('order_date')
            ->get();
        return [
            'datasets' => [
                [
                    'label' => 'Total revenue from last 7 days',
                    'data' => $data->map(fn(Order $order) => $order->total / 100),
                ]
            ],
            'labels' => $data->map(fn(Order $order) => Carbon::parse($order->order_date)->format('d/m/Y')),
        ];
    }

    public function updateChartData(): void
    {
        $this->emitSelf('updateChartData', [
            'data' => $this->getData(),
        ]);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.total-revenue-chart');
    }
}
