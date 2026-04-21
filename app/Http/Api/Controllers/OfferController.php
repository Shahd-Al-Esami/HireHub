<?php

namespace App\Http\Api\Controllers;

use App\Actions\Offer\StoreOffer;
use App\Http\Api\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferController extends Controller
{

     public function __construct(protected StoreOffer $storeOffer) {}

    public function store(StoreOfferRequest $request, $project_id): JsonResponse
    {
        // 1. نمرر فقط البيانات النظيفة والمستخدم الموثق
      $offer = $this->storeOffer->store($request->validated(), $project_id);


return response()->json(['message' => 'تم تقديم العرض بنجاح', 'offer' => $offer], 201);

    }



    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
