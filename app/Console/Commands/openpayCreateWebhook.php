<?php

namespace App\Console\Commands;

use App\Param;
use App\Plantel;
use Openpay\Data\Openpay;
use Illuminate\Console\Command;

class openpayCreateWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:openpayCreateWebhook {plantel} {url} {user} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un webhook en la aplicacion openpay a traves de una Api';

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


        $webhookO = array(
            'url' => $datos['url'],
            'user' => $datos['user'],
            'password' => $datos['password'],
            'event_types' => array(
                'charge.refunded',
                'charge.failed',
                'charge.cancelled',
                'charge.created',
                'charge.succeeded',
                'chargeback.accepted'
            )
        );
        //dd($webhookO);
        $webhook = $openpay->webhooks->add($webhookO);
        dd($webhook);
    }
}
