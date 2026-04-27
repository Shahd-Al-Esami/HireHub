<?php
namespace App\Services;

use App\Contracts\OfferRepositoryInterface;
use App\Jobs\SendOfferAcceptdJob;
use App\Jobs\SendOfferRejectedJob;
use App\Models\Offer;
use App\Models\Project;
use App\Notifications\OfferAcceptedNotification;
use App\Notifications\OfferCreatedNotification;
use App\Notifications\OfferRejectedNotification;
use App\Repositories\OfferRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OfferService{


    public function __construct(protected OfferRepository $repo)
    {
    }

public function storeOffer(array $data,int $project_id){
  $offer=$this->repo->storeOffer($data,$project_id);

    return $offer;
}





public function acceptOffer(Offer $offer)
    {
        return DB::transaction(function () use ($offer) {
           $this->repo->acceptOffer($offer);

            // رفض جميع العروض الأخرى للمشروع
            Offer::where('project_id', $offer->project_id)
                ->where('id', '!=', $offer->id)
                ->update(['status' => 'rejected']);


// $offer->user->notify(new OfferAcceptedNotification($offer));
         SendOfferAcceptdJob::dispatch($offer->id);
             Cache::tags(['projects'])->flush();


            return $offer;
        });
    }
public function rejectOffer($offer){

    $this->repo->rejectOffer($offer);

     SendOfferRejectedJob::dispatch($offer->id);
// $offer->user->notify(new OfferRejectedNotification($offer));


        return true;
    }
}

