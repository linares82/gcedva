<?php

namespace App\Observers;

use App\Lead;
use App\LeadHEstatus;

class LeadObserver
{
    private $lead;
    public function created(Lead $lead)
    {
        $input = [
            'lead_id' => $lead->id,
            'anterior_st_lead_id' => null,
            'nuevo_st_lead_id' => $lead->st_lead_id,
            'fecha' => date('Y-m-d'),
            'usu_alta_id' => $lead->usu_alta_id,
            'usu_mod_id' => $lead->usu_mod_id
        ];
        LeadHEstatus::create($input);
    }

    public function updating(Lead $lead)
    {
        $this->lead = $lead;
        $lead_antes = Lead::find($lead->id);

        if ($lead_antes->st_lead_id <> $this->lead->st_lead_id) {
            $input = [
                'lead_id' => $this->lead->id,
                'anterior_st_lead_id' => $lead_antes->st_lead_id,
                'nuevo_st_lead_id' => $this->lead->st_lead_id,
                'fecha' => date('Y-m-d'),
                'usu_alta_id' => $this->lead->usu_mod_id,
                'usu_mod_id' => $this->lead->usu_mod_id
            ];
            LeadHEstatus::create($input);
        }
    }
}
