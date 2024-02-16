<?php
namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use Illuminate\Support\Str;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::where('id', '>', -1)
        ->orderBy('created_at', 'desc');

        if ($request->input('page') == null || 
            $request->input('page') == '') {
            $countries = $countries->get();
        } else {
            $countries = $countries->with(['category'])->paginate();
        }

        $data = [
            'success' => true,
            'countries' => $countries
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountryRequest $request)
    {
        $validated = $request->validated();

        $country = new Country;

        $country->name = $validated['name'] ?? null;
		$country->code = $validated['code'] ?? null;
		$country->phone_code = $validated['phone_code'] ?? null;
		$country->flag_icon_url = $validated['flag_icon_url'] ?? null;

        $country->save();

        $data = [
            'success'       => true,
            'country'   => $country
        ];

        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        $data = [
            'success' => true,
            'country' => $country
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $validated = $request->validated();

        $country->name = $validated['name'] ?? null;
		$country->code = $validated['code'] ?? null;
		$country->phone_code = $validated['phone_code'] ?? null;
		$country->flag_icon_url = $validated['flag_icon_url'] ?? null;

        $country->save();

        $data = [
            'success'       => true,
            'country'   => $country
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();

        $data = [
            'success' => true,
            'country' => $country
        ];

        return response()->json($data);
    }
}
