<?php
namespace App\valenceSdk\samples\BasicSample;
/**
 * Copyright (c) 2012 Desire2Learn Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the license at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

//require_once 'config.php';
//require_once $config['libpath'] . '/D2LAppContextFactory.php';
use App\valenceSdk\samples\BasicSample\config;
use App\valenceSdk\lib\D2LAppContextFactory;
use App\valenceSdk\lib\D2LHostSpec;
use App\Param;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;

class UsoApi{
    public $config=array();

    function __construct(){

        $this->config['libpath']='../../lib';
        
        $param=Param::where('llave','url_bSpace')->first();
        $this->config['host']=$param->valor;
        $this->config['port']=443;
        $this->config['scheme']='https';

        $param=Param::where('llave','id_bSpace')->first();
        $this->config['appId']=$param->valor;
        $param=Param::where('llave','key_bSpace')->first();
        $this->config['appKey']=$param->valor;

        $param=Param::where('llave','apiVersion_bSpace')->first();
        $this->config['LP_Version']=$param->valor;

        //dd($this->config);
    }

    /*public $config = array(
        'libpath'    => '../../lib',
    
        'host'       => 'cedvapwctest.brightspace.com',
        'port'       => 443,
        'scheme'     => 'https',
    
        'appId'      => 'TcOyM-3AvJNK8Tg81CwTPw',
        'appKey'     => '5OeObwfWqBbq7AKt4Rp98A',
    
        'LP_Version' => '1.0'
    );*/

    public function getPageURL() {
        $portString = '';
        if (($_SERVER['HTTPS'] == 'on' && $_SERVER['SERVER_PORT'] != 443)
         || ($_SERVER['HTTPS'] == 'off' && $_SERVER['SERVER_PORT'] != 80)) {
                $portString = ':' . $_SERVER['SERVER_PORT'];
        }
        return "http" . ($_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . $_SERVER['SERVER_NAME'] . $portString . $_SERVER['REQUEST_URI'];
    }

    public function deauthenticate(){
        session_start();
        unset($_SESSION['userId']);
        unset($_SESSION['userKey']);
        session_write_close();
        //header("location: index.php");
    }

    public function authenticate(){
        $redirectPage = str_replace('authenticateUser.php', 'postLogin.php', $this->getPageURL());
        //dd($redirectPage);
        $authContextFactory = new D2LAppContextFactory();
        $authContext = $authContextFactory->createSecurityContext($this->config['appId'], $this->config['appKey']);
        //dd($authContext);
        $hostSpec = new D2LHostSpec($this->config['host'], $this->config['port'], $this->config['scheme']);
        //dd($hostSpec);
        $url = $authContext->createUrlForAuthenticationFromHostSpec($hostSpec, $redirectPage);
        //dd($url);
        header("Location: $url");
        //return $url;
        //$client = new Client();
        //$result = $client->get($url);
        //dd($result);
        //$request = $result->getBody()->getContents();
        //dd($request);
    }
}


