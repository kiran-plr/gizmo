<?php

namespace App\Console\Commands;

use App\Models\Shipment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckShipmentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipment:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all the shipments status every day at 3:00 AM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'https://leads.gizmogul.com/giz/get_paks.php';

        $trackingNo = Shipment::pluck('tracking_no', 'id')->filter(function ($shipment) {
            return $shipment != '';
        })->implode(',');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . '?test=8393827',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $items = json_decode(json_encode((array)simplexml_load_string(str_replace('<?xml version="1.0"? >', '<?xml version="1.0"?>', $response))), true);
        if (isset($items['pak'])) {
            collect($items['pak'])->map(function ($item) {
                $shipment = Shipment::where('tracking_no', $item['id'])->first();
                if ($shipment) {
                    $shipment->update(['shipment_status' => $item['status']]);
                    if ($item['status'] == 'Completed') {
                        $shipment->update(['status' => 'completed']);
                    }
                }
            });
            Log::channel('cron')->info('CheckShipmentStatus::class => Shipment status updated successfully');
        }
    }
}
