<?php

namespace App\Console\Commands;

use App\Param;
use App\Plantel;
use Openpay\Data\Openpay;
use Illuminate\Console\Command;

class openpayDeleteWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:openpayDeleteWebhook {plantel} {webhook_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borra un webhook especifico dentro de un plantel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $datos = $this->arguments();
        //dd($datos);
        $plantel = Plantel::find($datos['plantel']);
        $ip = Param::where('llave', 'ip_localhost')->first();
        $openpay = Openpay::getInstance($plantel->oid, $plantel->oprivada, 'MX', $ip->valor);
        $openpay_productivo = Param::where('llave', 'openpay_productivo')->first();

        if ($openpay_productivo->valor == 1) {
            //$openpay->setProductionMode(true);
            Openpay::setProductionMode(true);
        } else {
            //$openpay->setProductionMode(false);
            Openpay::setProductionMode(false);
        }

        $webhook = $openpay->webhooks->get($datos['webhook_id']);
        $webhook->delete();
        dd($webhook);
    }
}
