<?php
namespace App\Repositories;

use App\Contracts\OfferRepositoryInterface;
use App\Enums\OfferStatusEnum;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class OfferRepository implements OfferRepositoryInterface
{
    public function storeOffer(array $data,int $project_id)
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

    public function acceptOffer(Offer $offer)
    {
 $offer->update(['status' => 'accepted']);

            $offer->project->update(['status' => 'in_progress']);

     
            return $offer;
            }

    public function rejectOffer(Offer $offer)
    {

    if($offer->status==='accepted'){
        return false;
    }

    else{
        $offer->status='rejected';
        $offer->save();


        return true;
    }
    }

}
