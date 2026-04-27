<?php
namespace App\Actions\Offer;

use App\Enums\OfferStatusEnum;
use App\Http\Requests\StoreOfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreOffer{

public function store(array $data,int $project_id)
{
      $offer = Offer::create([
                    'project_id'    => $project_id,
                    'freelancer_id' => Auth::user()->id,
                    'status'        => OfferStatusEnum::PENDING,
                    'cover_letter'  => $data['cover_letter'],
                    'price'         => $data['price'],
                    'delivery_time' => $data['delivery_time'],
                ]);
                

return $offer;
}
}
