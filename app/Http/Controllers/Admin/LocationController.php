<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Locations\Distance;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Shipment;
use Exception;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    use Distance;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = Location::with('users')->orderBy('id')->get();
        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        $location = $id ? Location::findOrFail($id) : null;
        $users = User::all();
        return view('admin.locations.edit', compact('location', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = null)
    {
        $location = $id ? Location::findOrFail($id) : null;
        $this->validate($request, [
            'name' => 'required|max:30',
            'email' => 'required|email:rfc,strict,dns,spoof,filter',
            'address' => 'required|max:255',
            'address2' => 'max:255',
            'phone' => 'required|numeric|digits_between:0,9',
            'city' => 'required|string|max:30',
            'state' => 'required|string|max:30',
            'zip' => 'required|numeric|digits_between:0,9',
        ]);

        $data = $request->all();
        $location = Location::updateOrCreate(['id' => $location->id ?? null], $data);
        $location->users()->sync(($data['user_id'] ?? []));

        if ($location && !$id) {
            return redirect()->route('admin.location.index')->with('success', 'Location created successfully');
        } elseif ($location && $id) {
            return redirect()->route('admin.location.index')->with('success', 'Location updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::findOrFail($id);
        $shipments = $shipments = Shipment::where('location_id', $location->id)->orderBy('id', 'desc')->get();
        $users = User::all();

        return view('admin.locations.show', compact('location', 'shipments', 'users'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Assign users to location
     */
    public function assignUser(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->users()->sync($request->user_id);
        return redirect()->back()->with('success', 'User assigned successfully');
    }
    /**
     * import all the location
     */
    public function import(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 minutes

        $this->validate($request, [
            'csv' => 'required|mimes:csv,txt'
        ]);

        // check file exists and it's readable
        if (!file_exists($request->file('csv')) || !is_readable($request->file('csv'))) {
            return redirect()->back()->with('error', 'Unable to read file');
        }

        $logMessages = [];
        if (($handle = fopen($request->csv, 'r')) !== false) {
            $counter = 1;
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // skip if row is empty
                if (empty(array_filter($row))) {
                    $counter++;
                    continue;
                }

                // set the header row as key for the array
                if (!isset($header)) {
                    $header = $row;
                    $validateColumn = array_diff($this->getLocationCsvHeader(), $header);
                    if (!empty($validateColumn)) {
                        return redirect()->back()->with('error', \implode(',', $validateColumn) . ' columns does not exists in csv file');
                    }
                    $counter++;
                    continue;
                }

                $location = array_combine($header, $row);
                $notEmptyFields = [];

                if ($this->isEmpty($location['name'])) {
                    $notEmptyFields[] = 'name';
                }
                if ($this->isEmpty($location['address'])) {
                    $notEmptyFields[] = 'address';
                }
                if ($this->isEmpty($location['city'])) {
                    $notEmptyFields[] = 'city';
                }
                if ($this->isEmpty($location['state'])) {
                    $notEmptyFields[] = 'state';
                }
                if ($this->isEmpty($location['zip'])) {
                    $notEmptyFields[] = 'zip';
                }
                if ($this->isEmpty($location['email'])) {
                    $notEmptyFields[] = 'email';
                }
                if ($this->isEmpty($location['phone'])) {
                    $notEmptyFields[] = 'phone';
                }
                if ($this->isEmpty($location['active'])) {
                    $notEmptyFields[] = 'active';
                }
             
                if ($this->isEmpty($location['geo_lng']) && $this->isEmpty($location['geo_lat'])) {
                    $address = $location['address'] . (!empty($location['address2']) ? ', ' . $location['address2'] . ', ' : ', ') . $location['city'] . ', ' . $location['state'] . ' ' . $location['zip'] . ', ' . 'USA';
                    if ($this->getLatLong($address)) {
                        $location['geo_lat'] = $this->lat;
                        $location['geo_lng'] = $this->lng;
                    }
                }

                if (!empty($notEmptyFields)) {
                    $logMessages['validation'][] = $counter . ' Location has empty fields ' . implode(',', $notEmptyFields);
                    $counter++;
                    continue;
                }
                DB::beginTransaction();
                try {
                    Location::create($location);
                    DB::commit();
                    $logMessages['success'][] = $counter . ' Location created';
                } catch (Exception $e) {
                    DB::rollBack();
                    $logMessages['error'][] = $counter . ' Location has error.';
                }
                $counter++;
                continue;
            }
        }
        fclose($handle);

        return back()->with('importLog', $logMessages);
    }

    public function isEmpty($data)
    {
        if ($data == null || $data == '' || $data == 'null' || $data == 'NULL' || $data == 'Null' || $data == '-') {
            return true;
        }
        return false;
    }

    /**
     * Export the location
     */
    public function export()
    {
        $fileName = 'Location_' . date("Y-m-d") . '.csv';
        $locations = Location::select('name', 'address', 'address2', 'city', 'state', 'zip', 'email', 'phone', 'external_location_id', 'active', 'hours_of_opration', 'geo_lat', 'geo_lng')->get();

        $columns = $this->getLocationCsvHeader();
        $callback = function () use ($columns, $locations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($locations->toArray() as $key => $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };
        return response()->stream($callback, 200, ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$fileName", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"]);
    }

    public function getLocationCsvHeader()
    {
        return ['name', 'address', 'address2', 'city', 'state', 'zip', 'email', 'phone', 'external_location_id', 'active', 'hours_of_opration', 'geo_lat', 'geo_lng'];
    }
}
