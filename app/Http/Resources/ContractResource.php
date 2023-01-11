<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     // 
        //     'id' => $this->id,
        //     'manager_name' => $this->manager_name,
        //     'company_name' => $this->company_name,
        //     // 'subscription_id' => SubscriptionResource::collection($this->subscription_id),
        // ];
        // {
        //     "data": {
        //         "id": 1,
        //         "user_id":3,
        //         "subscription": {
        //                             "id":2 ,
        //                             "nbr_passages":9,  // nombre de passages
        //                             "nbr_hours":2,    // durée de passage
        //                             "nbr_months":6,   // la durée 
        //                             "price":350,     // la somme 

        //                         },
        //         "manager_name": "Carolina Effertz",  // nom et prénom du gérant / représentant 
        //         "cin_number": "xxxxxxxx",  // numero de la CIN 
        //         "company_name": "Russel and Kuphal",   // Raison social / dénomination social 
        //         "adress": "8104 Borer Shoals Suite 153",
        //         "city": "Mohammedia", // lieu d'immatriculation / ville
        //         "rc_number": "20317",  // numéro RC
        //         "capital": "42556",  // capital social
        //         "storage_path": null,
        //         "status": "pending",
        //         "created_at": "2023-01-02T11:44:41.000000Z",
        //         "updated_at": "2023-01-02T11:44:41.000000Z"
        //     }
        // }
    }
}
