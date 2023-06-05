<?php

namespace App\Http\Resources;

use AshAllenDesign\ShortURL\Models\ShortURL;

class QrCodeResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($qr_model)
    {
        $merge_array = array();

        foreach($qr_model as $qr) {
            $short_url = (!is_null($qr->redirect_link)) ? ShortURL::findByDestinationURL($qr->redirect_link)->first() : null;
            $merge_array[] =  [
                'qrcode' =>  [
                    'id' => $qr->id,
                    'qr_contact_types' =>  [
                        'id' => $qr->qr_contact_type_id,
                        'qr_contact_type' =>  [
                            'name' => $qr->qrContactType->name,
                            'format_link' => $qr->qrContactType->format_link
                        ]
                    ],
                    'users' =>  [
                        'id' => $qr->user_id,
                        'email' => $qr->user->email,
                        'office_name' => $qr->user->office->name,
                    ],
                    'redirect_link' => $qr->redirect_link ?? null,
                    'vcard_string' => $qr->vcard_string ?? null,
                    'usage_limit' => $qr->usage_limit,
                    'status' => $qr->status,
                ],
                'short_url' =>  [
                    'destination_url' => $short_url->destination_url ?? [],
                    'default_short_url' => $short_url->default_short_url ?? [],
                    'url_key' => $short_url->url_key ?? [],
                ]
            ];
        }

        return $merge_array;
    }
}
