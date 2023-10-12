<?php

namespace App\Http\Livewire\Chart;

use App\Helpers\AppHelper;
use App\Models\Shipment;
use Carbon\Carbon;
use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ApexChart extends Component
{
    public string $chartId;
    public $table;
    public Collection $seriesDataPending;
    public Collection $seriesDataCompleted;
    public $title;
    public Collection $categories;
    public $seriesName;

    public function mount()
    {
        $this->categories = collect(null);
        $this->seriesDataPending = collect(null);
        $this->seriesDataCompleted = collect(null);
        $this->getChartData();
    }

    public function getChartData()
    {
        $record = Shipment::select('status', DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(updated_at) as day_name"), DB::raw("DAY(updated_at) as day"))

            ->where('updated_at', '>', Carbon::today()->subMonth(11))
            ->groupBy('day_name', 'day')
            ->orderBy('day');

        if (AppHelper::isVendor()) {
            $locationId = auth()->user()->settings ? auth()->user()->settings['selectedLocation'] : null;
            $record->where('location_id', $locationId);
        }

        $record = $record->get();

        if (!$record->isEmpty()) {
            $data = [];
            $label = [];
            foreach ($record as $row) {
                $label[] = $row->day_name;
                if ($row->status  == 'pending') {
                    $data['pending'][] = (int) $row->count;
                } else {
                    $data['pending'][] = (int) 0;
                }
                if ($row->status == 'completed') {
                    $data['completed'][] = (int) $row->count;
                } else {
                    $data['completed'][] = (int) 0;
                }
            }
            $this->categories = collect($label);
            $this->seriesDataPending = collect($data['pending']);
            $this->seriesDataCompleted = collect($data['completed']);
        }
    }

    public function render()
    {
        return view('livewire.chart.apex-chart');
    }
}
