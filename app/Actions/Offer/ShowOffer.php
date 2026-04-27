<?php
namespace App\Actions\Offer;

use App\Models\Offer;

class ShowOffer{

public function show($offer_id){

          $offer=Offer::findOrFail($offer_id);


        if($offer->status==='accepted'){
            $freelancer=$offer->user;
            $project=$offer->project;
            return response()->json(['offer'=>$offer,'freelancer'=>$freelancer,'project'=>$project]);}
        else  if($offer->status==='rejected'){
           $offer=$offer->project;
        return response()->json($offer,['message'=>'offer is rejected']);
        }

        else{
            return response()->json(['message'=>'offer is pending']);
        }
}

}
