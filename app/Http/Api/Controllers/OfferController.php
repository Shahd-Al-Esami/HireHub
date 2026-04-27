<?php

namespace App\Http\Api\Controllers;

use App\Actions\Offer\ShowOffer;
use App\Actions\Offer\StoreOffer;
use App\Enums\OfferStatusEnum;
use App\Http\Api\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Services\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{

     public function __construct( ) {}

    public function store(OfferService $service,StoreOfferRequest $request,int $project_id)
    {


      $offer = $service->storeOffer($request->validated(),$project_id);

           return new OfferResource($offer);

    }

public function acceptOffer(OfferService $service, Offer $offer): JsonResponse
    {
        $result = $service->acceptOffer($offer);


            return response()->json(['message' => 'Offer accepted successfully.']);


    }



    public function rejectOffer(OfferService $service,  $offer): JsonResponse
    {
        $result = $service->rejectOffer($offer);

        if ($result) {
            return response()->json(['message' => 'Offer rejected successfully.']);
        } else {
            return response()->json(['message' => 'Offer is already accepted and cannot be rejected.'], 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(ShowOffer $action,Offer $offer)
    {
        $offer = $action->show($offer->id);
        return new OfferResource($offer);
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
