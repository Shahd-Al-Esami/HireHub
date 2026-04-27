<?php
namespace App\Contracts;

use App\Models\Offer;

interface OfferRepositoryInterface
{
    public function storeOffer(array $data,int $project_id);
    public function acceptOffer(Offer $offer);
    public function rejectOffer(Offer $offer);
}
