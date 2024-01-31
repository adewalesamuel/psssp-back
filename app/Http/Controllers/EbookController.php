<?php
namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEbookRequest;
use App\Http\Requests\UpdateEbookRequest;
use Illuminate\Support\Str;


class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'success' => true,
            'ebooks' => Ebook::where('id', '>', -1)
            ->orderBy('created_at', 'desc')->paginate()
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
    public function store(StoreEbookRequest $request)
    {
        $validated = $request->validated();

        $ebook = new Ebook;

        $ebook->name = $validated['name'] ?? null;
		$ebook->slug = $validated['slug'] ?? null;
		$ebook->type = $validated['type'] ?? null;
		$ebook->download_code = $validated['download_code'] ?? null;
		$ebook->description = $validated['description'] ?? null;
		$ebook->price = $validated['price'] ?? null;
		$ebook->initial_stock = $validated['initial_stock'] ?? null;
		$ebook->img_url = $validated['img_url'] ?? null;
		$ebook->file_url = $validated['file_url'] ?? null;
		
        $ebook->save();

        $data = [
            'success'       => true,
            'ebook'   => $ebook
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function show(Ebook $ebook)
    {
        $data = [
            'success' => true,
            'ebook' => $ebook
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function edit(Ebook $ebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEbookRequest $request, Ebook $ebook)
    {
        $validated = $request->validated();

        $ebook->name = $validated['name'] ?? null;
		$ebook->slug = $validated['slug'] ?? null;
		$ebook->type = $validated['type'] ?? null;
		$ebook->download_code = $validated['download_code'] ?? null;
		$ebook->description = $validated['description'] ?? null;
		$ebook->price = $validated['price'] ?? null;
		$ebook->initial_stock = $validated['initial_stock'] ?? null;
		$ebook->img_url = $validated['img_url'] ?? null;
		$ebook->file_url = $validated['file_url'] ?? null;
		
        $ebook->save();

        $data = [
            'success'       => true,
            'ebook'   => $ebook
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ebook $ebook)
    {   
        $ebook->delete();

        $data = [
            'success' => true,
            'ebook' => $ebook
        ];

        return response()->json($data);
    }
}