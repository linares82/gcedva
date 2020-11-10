<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use App\Param;

class prbBS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ian:bs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $url=Param::where('llave','url_bSpace')->first();
        $client = new Client(['base_uri' => $url->valor]);
        $version=Param::where('llave','apiVersion_bSpace')->first();
        $result = $client->request('GET', "/d2l/api/lp/".$version->valor."/users/whoami");
        $request = $result->getBody()->getContents();
        dd($request);
        return response()->Json($request);
    }
}
