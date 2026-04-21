<?php
namespace App\Actions\Offer;

use App\Enums\OfferStatusEnum;
use App\Http\Requests\StoreOfferRequest;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class StoreOffer{

public function store(StoreOfferRequest $request){
      $offer = Offer::create([
                    'project_id'    => $request->project_id,
                    'freelancer_id' => Auth::user()->id,
                    'status'        => OfferStatusEnum::PENDING->value, // الحالة الافتراضية
                    'cover_letter'  => $request->cover_letter,
                    'price'         => $request->price,
                    'delivery_time' => $request->delivery_time,
                ]);

return $offer;
}
}
