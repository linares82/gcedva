<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Caja;
use App\FacturaGeneral;
use App\FacturaGeneralLinea;
use App\Param;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\updateFacturaGeneral;
use App\Http\Requests\createFacturaGeneral;
use Luecano\NumeroALetras\NumeroALetras;
use SoapClient;
use Session;
use SimpleXMLElement;
use DOMDocument;

class FacturaGeneralsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$facturaGenerals = FacturaGeneral::getAllData($request);

		return view('facturaGenerals.index', compact('facturaGenerals'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('facturaGenerals.create')
			->with( 'list', FacturaGeneral::getListFromAllRelationApps() );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFacturaGeneral $request)
	{

		$input = $request->all();
		$input['usu_alta_id']=Auth::user()->id;
		$input['usu_mod_id']=Auth::user()->id;

		//create data
		FacturaGeneral::create( $input );

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		return view('facturaGenerals.show', compact('facturaGeneral'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		return view('facturaGenerals.edit', compact('facturaGeneral'))
			->with( 'list', FacturaGeneral::getListFromAllRelationApps() );
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		return view('facturaGenerals.duplicate', compact('facturaGeneral'))
			->with( 'list', FacturaGeneral::getListFromAllRelationApps() );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, FacturaGeneral $facturaGeneral, updateFacturaGeneral $request)
	{
		$input = $request->all();
		$input['usu_mod_id']=Auth::user()->id;
		//update data
		$facturaGeneral=$facturaGeneral->find($id);
		$facturaGeneral->update( $input );

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id,FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral=$facturaGeneral->find($id);
		$facturaGeneral->usu_eliminar_id=Auth::user()->id;
		$facturaGeneral->save();
		$facturaGeneral->delete();

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Borrado.');
	}

	public function recargarLineas($id){
		$facturaGeneral=FacturaGeneral::find($id);
		$lineas=FacturaGeneralLinea::where('factura_general_id',$facturaGeneral->id)->get();
		if($lineas->count()>0){
			foreach($lineas as $ln){
				$ln->delete();
			}
		}
		$registrosSinFactura=Caja::select('pla.razon','c.id as cliente_id','c.nombre','c.nombre2','c.ape_paterno',
			'c.ape_materno','cajas.fecha as fecha_caja','p.fecha as fecha_pago','cc.name as concepto','p.uuid',
			'cajas.id as caja_id','p.id as pago_id','p.monto','a.id as adeudo_id')
			->join('caja_lns as ln','ln.caja_id','=','cajas.id')
			->join('clientes as c','c.id','=','cajas.cliente_id')
			->join('adeudos as a','a.id','=','ln.adeudo_id')
			->join('caja_conceptos as cc','cc.id','=','ln.caja_concepto_id')
			->join('pagos as p','p.caja_id','=','cajas.id')
			->join('plantels as pla','pla.id','=','cajas.plantel_id')
			->where('a.pagado_bnd',1)
			->where('p.fecha','<=',$facturaGeneral->fec_fin)
			->where('p.fecha','>=',$facturaGeneral->fec_inicio)
			->where('cajas.fecha','<=',$facturaGeneral->fec_fin)
			->where('cajas.fecha','>=',$facturaGeneral->fec_inicio)
			->where('pla.id',$facturaGeneral->plantel_id)
			->where('a.pagado_bnd',1)
			->where('cc.bnd_mensualidad',1)
			->whereNull('p.uuid')
			->whereNull('a.deleted_at')
			->whereNull('cajas.deleted_at')
			->whereNull('ln.deleted_at')
			->whereNull('p.deleted_at')
			->orderBy('cajas.cliente_id')
			->orderBy('p.fecha')
			->get();
		//dd($registrosSinFactura->toArray());
		foreach($registrosSinFactura as $registro){
			$input['factura_general_id']=$facturaGeneral->id;
			$input['cliente_id']=$registro->cliente_id;
			$input['caja_id']=$registro->caja_id;
			$input['pago_id']=$registro->pago_id;
			$input['bnd_incluido']=1;
			$input['monto']=$registro->monto;
			$input['usu_mod_id']=Auth::user()->id;
			$input['usu_alta_id']=Auth::user()->id;
			FacturaGeneralLinea::create($input);
			$suma=$suma+$registro->monto;
		}
		$facturaGeneral->total=$suma;
		$facturaGeneral->save();

		//$this->detalle($facturaGeneral->id);
		return redirect()->route('facturaGenerals.detalle', $facturaGeneral->id);
	}

	public function detalle($id){
		$facturaGeneral=FacturaGeneral::find($id);
		$lineas=FacturaGeneralLinea::where('factura_general_id',$facturaGeneral->id)
		->with('caja')
		->with('pago')
		->with('cliente')
		->with('facturaGeneral')
		->get();
		
		//dd($facturaGeneral);
		
		//dd($registrosSinFactura->toArray());

		return view('facturaGenerals.detalle', compact('lineas','facturaGeneral'));
	}

	public function total(Request $request){
		$datos=$request->all();
		$facturaGeneral=FacturaGeneral::find($datos['id']);
		$suma=FacturaGeneralLinea::where('factura_general_id',$datos['id'])->where('bnd_incluido',1)->sum('monto');

		$facturaGeneral->total=$suma;
		$facturaGeneral->save();

		$lineas=FacturaGeneralLinea::where('factura_general_id',$facturaGeneral->id)
		->with('caja')
		->with('pago')
		->with('cliente')
		->with('facturaGeneral')
		->get();
		return view('facturaGenerals.detalle', compact('lineas','facturaGeneral'));
	}

	public function generarFactura(Request $request){
		$datos=$request->all();
		$facturaGeneral=FacturaGeneral::find($datos['id']);
		$suma=FacturaGeneralLinea::where('factura_general_id',$datos['id'])->where('bnd_incluido',1)->sum('monto');
		$lineas=$facturaGeneral->facturaGeneralLineas;
		$url = Param::where('llave', 'webServiceFacturacion')->first();
		try {
            $opts = array(
                'http' => array(
                    'user_agent' => 'PHPSoapClient'
                )
            );
            $context = stream_context_create($opts);

            $wsdlUrl = $url->valor;
            $soapClientOptions = array(
                'stream_context' => $context,
                'cache_wsdl' => WSDL_CACHE_NONE
            );

            $client = new SoapClient($wsdlUrl, $soapClientOptions);

            //dd($client->__getFunctions());
            //$fecha_solicitud_factura_tabla = date('Y-m-d H:i:s');
            //$fecha_solicitud_factura_service = date('Y-m-d\TH:i:s');

            
            $objetosArray = array();
            
                $objetosArray = array(
                    'credenciales' => array(
                        'Cuenta' => $plantel->fcuenta,
                        'Password' => $plantel->fpassword,
                        'Usuario' => $plantel->fusuario
                    ),
                    'cfdi' => array(
                        'Addenda' => array(
                            /*'DomicilioEmisor' => array(
                                'Calle' => $plantel->matriz->calle,
                                'CodigoPostal' => $plantel->matriz->cp,
                                'Colonia' => $plantel->matriz->colonia,
                                'Estado' => $plantel->matriz->estado,
                                //'Localidad' => $cliente->flocalidad,
                                'Municipio' => $plantel->matriz->municipio,
                                'NombreCliente' => $plantel->matriz->nombre_corto,
                                'NumeroExterior' => $plantel->matriz->no_ext,
                                'NumeroInterior' => $plantel->matriz->no_int,
                                'Pais' => 'Mexico',
                                //'Referencia'=>$cliente->,
                                //'Telefono'=>
                            ),*/
                            'DomicilioEmisor' => array(
                                'Calle' => $plantel->calle,
                                'CodigoPostal' => $plantel->cp,
                                'Colonia' => $plantel->colonia,
                                'Estado' => $plantel->estado,
                                //'Localidad' => $cliente->flocalidad,
                                'Municipio' => $plantel->municipio,
                                'NombreCliente' => $plantel->nombre_corto,
                                'NumeroExterior' => $plantel->no_ext,
                                'NumeroInterior' => $plantel->no_int,
                                'Pais' => 'Mexico',
                                //'Referencia'=>$cliente->,
                                //'Telefono'=>
                            ),
                            'DomicilioReceptor' => array(
                                'Calle' => $cliente->fcalle,
                                'CodigoPostal' => $cliente->fcp,
                                'Colonia' => $cliente->fcolonia,
                                'Estado' => $cliente->festado,
                                'Localidad' => $cliente->flocalidad,
                                'Municipio' => $cliente->fmunicipio,
                                'NombreCliente' => $cliente->fno_interior,
                                'NumeroExterior' => $cliente->fno_exterior,
                                'NumeroInterior' => $cliente->fno_interior,
                                'Pais' => $cliente->fpais,
                                //'Referencia'=>$cliente->,
                                //'Telefono'=>
                            )/*,
                            'DomicilioSucursal' => array(
                                'Calle' => $plantel->calle,
                                'CodigoPostal' => $plantel->cp,
                                'Colonia' => $plantel->colonia,
                                'Estado' => $plantel->estado,
                                //'Localidad' => $cliente->flocalidad,
                                'Municipio' => $plantel->municipio,
                                'NombreCliente' => $plantel->nombre_corto,
                                'NumeroExterior' => $plantel->no_ext,
                                'NumeroInterior' => $plantel->no_int,
                                'Pais' => 'Mexico',
                                //'Referencia'=>$cliente->,
                                //'Telefono'=>
                            ),*/
                        ),
                        'ClaveCFDI' => 'FAC', //Requerido valor default para ingresos segun documento tecnico del proveedor
                        //Plantel emisor de factura
                        'Emisor' => array(
                            'Nombre' => $cliente->plantel->nombre_corto,
                            'RegimenFiscal' => $cliente->plantel->regimen_fiscal, //Campo nuevo en planteles
                        ),
                        //Cliente
                        'Receptor' => array(
                            'Nombre' => $cliente->frazon,
                            'Rfc' => $cliente->frfc, //'TEST010203001',
                            'UsoCFDI' => $adeudo->cajaConcepto->uso_factura, //campo nuevo en conceptos de caja, Definir valor Default de acuerdo al SAT
                        ),
                        //'CondicionesDePago' => 'CONDICIONES', //opcional
                        'FormaPago' => $pago->formaPago->cve_sat, //No es Opcional Documentacion erronea, llenar en tabla campo nuevo
                        'Fecha' => $fecha_solicitud_factura_service,
                        'MetodoPago' => 'PUE', //No es Opcional Documentacion erronea, Definir default segun catalogo del SAT
                        'LugarExpedicion' => $cliente->plantel->cp, //CP del plantel, debe ser valido segun catalogo del SAT
                        'Moneda' => 'MXN', //Default
                        'Referencia' => $pago->csc_simplificado,  //Definir valor
                        'Conceptos' => array('ConceptoR' => array(
                            'Cantidad' => '1',
                            'ClaveProdServ' => $adeudo->combinacionCliente->grado->clave_servicio, //Definir valor defaul de acuerdo al SAT
                            'ClaveUnidad' => 'E48',
                            'Unidad' => 'Servicio', //Definir valor default
                            'Descripcion' => $caja->cajaLn->cajaConcepto->leyenda_factura . " " . $fecha_anio,
                            'Impuestos' => array('Traslados' => array('TrasladoConceptoR' => array( //no se manejan impuestos
                                'Base' => number_format($total_pagos, 2, '.', ''),
                                //'Importe' => '0.00',
                                'Impuesto' => '002',
                                //'TasaOCuota' => '0.000000',
                                'TipoFactor' => 'Exento'
                            ),),),
                            'InstEducativas' => array(
                                'AutRVOE' => $adeudo->combinacionCliente->grado->rvoe,
                                'CURP' => $cliente->curp,
                                'NivelEducativo' => $nivelEducativoSat->name,
                                'NombreAlumno' => $cliente->nombre . " " . $cliente->nombre2 . " " . $cliente->ape_paterno . " " . $cliente->ape_materno,
                                'RfcPago' => $cliente->frfc
                            ),
                            //'NoIdentificacion' => '00003', //Opcional
                            'Importe' => number_format($total_pagos, 2, '.', ''),
                            'ValorUnitario' => number_format($total_pagos, 2, '.', '')
                        ),),
                        'SubTotal' => number_format($total_pagos, 2, '.', ''),
                        'Total' => number_format($total_pagos, 2, '.', '')
                    )
                );
            

            //dd($objetosArray);
            $result = $client->GenerarCFDI($objetosArray)->GenerarCFDIResult;
            //dd($result);
            if (!is_null($result->ErrorDetallado) and $result->ErrorDetallado <> "" and $result->OperacionExitosa <> true) {
                Session::flash('error', $result->ErrorGeneral);
                return back();
            } elseif ($result->OperacionExitosa == true) {
                /*
                $p = xml_parser_create();
                xml_parse_into_struct($p, $result->XML, $vals, $index);
                xml_parser_free($p);
                dd($vals);
                */
                //dd($result);
                $xmlArray = $this->xmlstr_to_array($result->XML);
                //dd($xmlArray["cfdi:Complemento"]["tfd:TimbreFiscalDigital"]["@attributes"]["UUID"]);
                $pagos1 = Pago::where('caja_id', $adeudo->caja_id)->whereNull('deleted_at')->get();
                //dd($pagos->toArray());
                $folio = ++$plantel->folio_facturados;
                $plantel->save();
                foreach ($pagos1 as $pago1) {
                    $pago1->uuid = $xmlArray["cfdi:Complemento"]["tfd:TimbreFiscalDigital"]["@attributes"]["UUID"];
                    $pago1->cbb = $result->CBB;
                    $pago1->xml = $result->XML;
                    $pago1->fecha_solicitud_factura = $fecha_solicitud_factura_tabla;
                    $pago1->serie_factura = $plantel->serie_factura;
                    $pago1->folio_facturados = $folio;

                    $pago1->save();
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            dd($e->getMessage());
        }
	}

}
