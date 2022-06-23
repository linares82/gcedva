<?php

namespace App\Http\Controllers;

use Log;
use Auth;

use App\Param;
use XMLWriter;
use App\Plantel;
use App\FacturaG;
use Carbon\Carbon;
use App\FacturaGLinea;
use App\Http\Requests;
use GuzzleHttp\Client;
use App\CuentasEfectivo;
use Illuminate\Http\Request;
use App\CuentasEfectivoPlantel;

use App\Http\Controllers\Controller;
use App\Http\Requests\createFacturaG;

use App\Http\Requests\updateFacturaG;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\GuzzleException;

class FacturaGsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$facturaGs = FacturaG::getAllData($request);

		return view('facturaGs.index', compact('facturaGs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cuentas = CuentasEfectivo::where('bnd_banco', 1)->pluck('no_cuenta', 'id');
		return view('facturaGs.create', compact('cuentas'))
			->with('list', FacturaG::getListFromAllRelationApps());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(createFacturaG $request)
	{

		$input = $request->all();
		//dd($input);
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		$r = $request->hasFile('archivo');
		//dd($r);
		if ($r) {
			$archivo = $request->file('archivo');
			$input['archivo'] = $archivo->getClientOriginalName();
		}

		//create data
		$e = FacturaG::create($input);
		//dd($request->hasFile('archivo'));
		if ($request->hasFile('archivo')) {
			$file = $request->file('archivo');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			$r = Storage::disk('facturacion_global')->put($nombre, \File::get($file));

			//$e->archivo = $nombre;
			//$e->save();
		}

		//dd($file);
		$fp = fopen($file, "r");
		$i = 0;

		while (!feof($fp)) {
			$registro = array();
			//$file=storage_path('conciliaciones\\'.$nombre);


			$linea_aux = fgets($fp);
			$linea = utf8_decode($linea_aux);
			//dd(utf8_encode($linea));
			//Log::info("linea " . $i . ": " . $linea);
			if ($i > 1) {
				if (trim($linea) <> "") {
					$resultado = explode(',', $linea);
					$input = array();
					$input['factura_g_id'] = $e->id;
					$input['fecha_operacion'] = trim($resultado[0]);
					$input['concepto'] = trim($resultado[1]);
					$input['referencia'] = trim($resultado[2]);
					$input['referencia_ampliada'] = trim($resultado[3]);
					$input['cargo'] = ($resultado[4] == "" ? 0 : trim($resultado[4]));
					$input['abono'] = ($resultado[5] == "" ? 0 : trim($resultado[5]));
					$input['saldo'] = ($resultado[6] == "" ? 0 : trim($resultado[6]));
					$input['usu_alta_id'] = Auth::user()->id;
					$input['usu_mod_id'] = Auth::user()->id;
					$input['origen']='Archivo';

					FacturaGLinea::create($input);
				}
			}
			$i++;
		}

		fclose($fp);

		return redirect()->route('facturaGs.index')->with('message', 'Registro Creado.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$facturaG = FacturaG::find($id);
		return view('facturaGs.show', compact('facturaG'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$facturaG = FacturaG::find($id);
		$cuentas = CuentasEfectivo::where('bnd_banco', 1)->pluck('no_cuenta', 'id');
		return view('facturaGs.edit', compact('facturaG', 'cuentas'))
			->with('list', FacturaG::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FacturaG $facturaG)
	{
		$facturaG = $facturaG->find($id);
		return view('facturaGs.duplicate', compact('facturaG'))
			->with('list', FacturaG::getListFromAllRelationApps());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update($id, updateFacturaG $request)
	{
		$input = $request->all();
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$facturaG = FacturaG::find($id);
		$facturaG->update($input);

		$r = $request->hasFile('archivo');
		//dd($r);
		if ($r) {
			$archivo = $request->file('archivo');
			$input['archivo'] = $archivo->getClientOriginalName();
		}

		if ($request->hasFile('archivo')) {
			$file = $request->file('archivo');
			$extension = $file->getClientOriginalExtension();
			$nombre = date('dmYhmi') . $file->getClientOriginalName();
			$r = Storage::disk('facturacion_global')->put($nombre, \File::get($file));

			//$e->archivo = $nombre;
			//$e->save();
			//dd($file);
			$fp = fopen($file, "r");
			$i = 0;

			while (!feof($fp)) {
				$registro = array();
				//$file=storage_path('conciliaciones\\'.$nombre);


				$linea_aux = fgets($fp);
				$linea = utf8_decode($linea_aux);
				//dd(utf8_encode($linea));
				//Log::info("linea " . $i . ": " . $linea);
				if ($i > 1) {
					if (trim($linea) <> "") {
						$resultado = explode(',', $linea);
						$input = array();
						$input['factura_g_id'] = $facturaG->id;
						$input['fecha_operacion'] = trim($resultado[0]);
						$input['concepto'] = trim($resultado[1]);
						$input['referencia'] = trim($resultado[2]);
						$input['referencia_ampliada'] = trim($resultado[3]);
						$input['cargo'] = ($resultado[4] == "" ? 0 : trim($resultado[4]));
						$input['abono'] = ($resultado[5] == "" ? 0 : trim($resultado[5]));
						$input['saldo'] = ($resultado[6] == "" ? 0 : trim($resultado[6]));
						$input['usu_alta_id'] = Auth::user()->id;
						$input['usu_mod_id'] = Auth::user()->id;
						$input['origen']='Archivo';

						FacturaGLinea::create($input);
					}
				}
				$i++;
			}

			fclose($fp);
		}

		return redirect()->route('facturaGs.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, FacturaG $facturaG)
	{
		$facturaG = $facturaG->find($id);
		$facturaG->delete();

		return redirect()->route('facturaGs.index')->with('message', 'Registro Borrado.');
	}

	public function getPlantel(Request $request)
	{
		$datos = $request->all();
		if ($request->ajax()) {
			$plantel = CuentasEfectivoPlantel::where('cuentas_efectivo_id',$datos['cuenta'])
				->join('plantels as p', 'p.id', 'cuentas_efectivo_plantels.plantel_id')
				->join('plantels as matriz', 'matriz.id', 'p.matriz_id')
				->select('cuentas_efectivo_plantels.cuentas_efectivo_id', 'p.id as plantel', 'p.matriz_id')
				->distinct()
				->first();
				$matriz=Plantel::find($plantel->matriz_id);
			//dd($matriz->toArray());

			return json_encode(array(
				'plantel_id'=>$plantel->plantel,
				'matriz_id'=>$plantel->matriz_id,
				'lugar_expedicion'=>$matriz->cp,
				'emisor_nombre'=>$matriz->nombre_corto,
				'emisor_rfc'=>$matriz->rfc,
				'emisor_regimen_fiscal'=>$matriz->regimen_fiscal,
			));
		}
	}

	public function total(Request $request)
	{
		$datos = $request->all();
		$facturaG = FacturaG::find($datos['id']);
		$suma = FacturaGLinea::where('factura_g_id', $datos['id'])->where('bnd_incluido', 1)->sum('abono');

		$facturaG->total = $suma;
		$facturaG->save();

		/*$lineas=FacturaGLinea::where('factura_g_id', $datos['id'])->where('bnd_incluido', 1)->get();
		$i=1;
		foreach($lineas as $linea){
			$linea->folio=$i;
			$linea->save();
			$i++;
		}*/

		return redirect()->route('facturaGs.show', $facturaG->id)->with('message', 'Registro Borrado.');
	}

	public function generarFactura(Request $request)
	{
		$datos = $request->all();
		$facturaG = FacturaG::with('facturaGLineas')->find($datos['id']);

		$url = Param::where('llave', 'fact_global_url')->first();

		$fact_global_prb_activa = Param::where('llave', 'fact_global_prb_activa')->first();

		$data = array();

		if ($fact_global_prb_activa->valor == 1) {
			//'xmlns:iedu' => 'http://www.sat.gob.mx/iedu',
			$comprobante = array(
				'Version' => '4.0',
				'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
				'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/4',
				//'xmlns:divisas' => 'http://www.sat.gob.mx/divisas',
				//'xmlns:donat' => 'http://www.sat.gob.mx/donat',
				//'xmlns:notariospublicos' => 'http://www.sat.gob.mx/notariospublicos',
				//'xmlns:implocal' => 'http://www.sat.gob.mx/implocal',
				//'xmlns:ine' => 'http://www.sat.gob.mx/ine',
				//'xmlns:cartaporte20' => 'http://www.sat.gob.mx/CartaPorte20',
				//'xmlns:nomina12' => 'http://www.sat.gob.mx/nomina12',
				//'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/divisas http://www.sat.gob.mx/sitio_internet/cfd/divisas/divisas.xsd http://www.sat.gob.mx/donat http://www.sat.gob.mx/sitio_internet/cfd/donat/donat11.xsd http://www.sat.gob.mx/notariospublicos http://www.sat.gob.mx/sitio_internet/cfd/notariospublicos/notariospublicos.xsd http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd http://www.sat.gob.mx/ine http://www.sat.gob.mx/sitio_internet/cfd/ine/ine11.xsd http://www.sat.gob.mx/CartaPorte20 http://www.sat.gob.mx/sitio_internet/cfd/CartaPorte/CartaPorte20.xsd http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd',
				'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd',
				'Certificado' => '', //?
				'NoCertificado' => '', //?
				'Serie' => '', //?
				'Folio' => '', //?
				'Fecha' => Carbon::createFromFormat('Y-m-d h:i:s', $facturaG->fecha)->format('Y-m-d\TH:i:s'),
				'FormaPago' => $facturaG->forma_pago,
				//'CondicionesDePago' => 'CONTADO',
				'TipoDeComprobante' => $facturaG->tipo_comprobante,
				'Moneda' => 'MXN',
				'LugarExpedicion' => $facturaG->lugar_expedicion,
				'Exportacion' => $facturaG->exportacion,
				'SubTotal' => $facturaG->total,
				'Total' => $facturaG->total,
				'MetodoPago' => 'PUE',
				'Sello' => ''
			);

			$informacionGlobal = array(
				'Periodicidad' => '04',
				'Meses' => $facturaG->meses,
				'Anio' => $facturaG->anio
			);

			$emisor = array(
				'Rfc' => 'FILE7010034T9', //$facturaGeneral->plantel->rfc,
				'Nombre' => 'prueba flc', //$facturaGeneral->plantel->nombre_corto,
				'RegimenFiscal' => '612' //$facturaGeneral->plantel->regimen_fiscal
			);
			$receptor = array(
				'Rfc' => 'RECE8002036T7', //'XAXX010101000',
				'Nombre' => 'RECEPTOR DE PRUEBAS', //'PUBLICO EN GENERAL',
				'DomicilioFiscalReceptor' => '29000', //$facturaGeneral->plantel->cp, //Por definir
				'UsoCFDI' => 'S01', //Por definir
				'RegimenFiscalReceptor' => "616" //Definir default
			);

			$lineas = FacturaGLinea::where('factura_g_id', $facturaG->id)
				->where('bnd_incluido', 1)
				->get();

			$conceptos = array();
			//dd($facturaGeneral->facturaGeneralLineas->toArray());
			foreach ($lineas as $linea) {

				$concepto = array(
					'ClaveProdServ' => '01010101',
					'NoIdentificacion' => $linea->folio,
					'Cantidad' => '1',
					'ClaveUnidad' => 'ACT',
					'Unidad' => 'ACT',
					'Descripcion' => 'VENTA',
					'ValorUnitario' => $linea->abono,
					'Importe' => $linea->abono,
					'Descuento' => '0.00',
					'ObjetoImp' => "02",
					'Base' => $linea->abono,
					'Impuesto'=>'002',
					'TipoFactor'=>'Exento'
				);
				array_push($conceptos, $concepto);
			}

			$impuestos=array(
				'TotalImpuestosTrasladados'=> '0.00',
				'Base' => number_format($facturaG->total, 2, '.', ''),
				'Importe' => '0.00',
				'Impuesto' => '002',
				'TasaOCuota' => '0.000000',
				'TipoFactor' => 'Exento'
			);

			$fecha_solicitud_factura_service = date('Y-m-d\TH:i:s');
		} else {
			//'xmlns:iedu' => 'http://www.sat.gob.mx/iedu',
			$comprobante = array(
				'Version' => '4.0',
				'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
				'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/4',
				'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd',
				'Certificado' => '', //?
				'NoCertificado' => '', //?
				'Serie' => '', //?
				'Folio' => '', //?
				'Fecha' => Carbon::createFromFormat('Y-m-d h:i:s', $facturaG->fecha)->format('Y-m-d\TH:i:s'),
				'FormaPago' => $facturaG->forma_pago,
				//'CondicionesDePago' => 'CONTADO',
				'TipoDeComprobante' => $facturaG->tipo_comprobante,
				'Moneda' => 'MXN',
				'LugarExpedicion' => $facturaG->lugar_expedicion,
				'Exportacion' => $facturaG->exportacion,
				'SubTotal' => $facturaG->total,
				'Total' => $facturaG->total,
				'MetodoPago' => 'PUE',
				'Sello' => ''
			);

			$informacionGlobal = array(
				'Periodicidad' => $facturaG->periodicidad,
				'Meses' => $facturaG->meses,
				'Anio' => $facturaG->anio
			);

			$emisor = array(
				'Rfc' => $facturaG->emisor_rfc,
				'Nombre' => $facturaG->emisor_nombre,
				'RegimenFiscal' => $facturaG->emisor_regimen_fiscal
			);
			$receptor = array(
				'Rfc' => 'XAXX010101000',
				'Nombre' => 'PUBLICO EN GENERAL',
				'DomicilioFiscalReceptor' => $facturaG->lugar_expedicion, //Por definir
				'UsoCFDI' => 'S01', //Por definir
				'RegimenFiscalReceptor' => "616" //Definir default
			);

			$lineas = FacturaGLinea::where('factura_g_id', $facturaG->id)
				->where('bnd_incluido', 1)
				->get();

			$conceptos = array();
			//dd($facturaGeneral->facturaGeneralLineas->toArray());
			foreach ($lineas as $linea) {

				
				$concepto = array(
					'ClaveProdServ' => '01010101',
					'NoIdentificacion' => $linea->folio,
					'Cantidad' => '1',
					'ClaveUnidad' => 'ACT',
					//'Unidad' => 'ACT',
					'Descripcion' => 'VENTA',
					'ValorUnitario' => $linea->abono,
					'Importe' => $linea->abono,
					'Descuento' => '0.00',
					'ObjetoImp' => "02",
					'Base' => $linea->abono, // desglose de impuestos por concepto
					'Impuesto'=>'002', // desglose de impuestos por concepto
					'TipoFactor'=>'Exento' // desglose de impuestos por concepto
				);
				array_push($conceptos, $concepto);
			}

			$fecha_solicitud_factura_service = date('Y-m-d\TH:i:s');

			// desglose de impuestos de la factura
			$impuestos=array(
				'TotalImpuestosTrasladados'=> '0.00',
				'Base' => number_format($facturaG->total, 2, '.', ''),
				'Importe' => '0.00',
				'Impuesto' => '002',
				'TasaOCuota' => '0.000000',
				'TipoFactor' => 'Exento'
			);
		}
		
		$content = $this->crearXmlFactura($comprobante, $fecha_solicitud_factura_service, $informacionGlobal, $emisor, $receptor, $conceptos, $impuestos);

		$data = array();
		//dd($fact_global_prb_activa->valor);
		if ($fact_global_prb_activa->valor == 1) {
			$fact_global_id_cuenta_prb = Param::where('llave', 'fact_global_id_cuenta_prb')->first();
			$fact_global_pass_cuenta_prb = Param::where('llave', 'fact_global_pass_cuenta_prb')->first();
			$data = array(
				"cti" => $fact_global_id_cuenta_prb->valor,
				"pwd" => $fact_global_pass_cuenta_prb->valor,
				"idd" => "", //
				"ncer" => "",
				"nb64" => false, //si se establece en true el xml debe ser una cadena en formato json y si es false en base64
				//en el xml debe colocar los espacios de nombres
				"xml" => base64_encode($content)
			);
		} else {
			$data = array(
				"cti" => $facturaG->plantel->fact_global_id_cuenta,
				"pwd" => $facturaG->plantel->fact_global_pass_cuenta,
				"idd" => "",
				"ncer" => "",
				"nb64" => "false",
				"xml" => base64_encode($content)
			);
		}
		//dd($data);

		$client = new Client(['base_uri' => $url->valor]);
		$response = $client->post("sellar-y-timbrar/", [
			// un array con la data de los headers como tipo de peticion, etc.
			//'headers' => ['foo' => 'bar'],
			// array de datos del formulario
			'json' => $data
		]);
		$objR = json_decode($response->getBody()->getContents());
		//dd($objR);
		if ($objR->success == 0) {
			//$facturaG->error_last = $objR->data;
			//$facturaG->save();
			dd($objR);
		} else {
			$facturaG->uuid = $objR->data->uuid;
			$facturaG->xml = base64_decode($objR->data->xml);
			$facturaG->save();
		}

		return redirect()->route('facturaGs.show', $facturaG->id);
	}

	public function crearXmlFactura($comprobante, $fecha_solicitud_factura_service, $informacionGlobal, $emisor, $receptor, $conceptos, $impuestos)
	{
		//dd($impuestos);
		$objetoXML = new XMLWriter();
		//$objetoXML->openURI($facturaGeneral->plantel_id.$facturaGeneral->fec_inicio.$facturaGeneral->fec_fin.".xml");
		$objetoXML->openMemory();
		$objetoXML->setIndent(true);
		$objetoXML->setIndentString("\t");
		$objetoXML->startDocument('1.0', 'utf-8');

		$objetoXML->startElement("cfdi:Comprobante");
		$objetoXML->writeAttribute("Version", $comprobante["Version"]);
		$objetoXML->writeAttribute("xmlns:xsi", $comprobante["xmlns:xsi"]);
		$objetoXML->writeAttribute("xmlns:cfdi", $comprobante["xmlns:cfdi"]);
		//$objetoXML->writeAttribute("xmlns:divisas", $comprobante["xmlns:divisas"]);
		//$objetoXML->writeAttribute("xmlns:donat", $comprobante["xmlns:donat"]);
		//$objetoXML->writeAttribute("xmlns:notariospublicos", $comprobante["xmlns:notariospublicos"]);
		//$objetoXML->writeAttribute("xmlns:implocal", $comprobante["xmlns:implocal"]);
		//$objetoXML->writeAttribute("xmlns:ine", $comprobante["xmlns:ine"]);
		//$objetoXML->writeAttribute("xmlns:cartaporte20", $comprobante["xmlns:cartaporte20"]);
		//$objetoXML->writeAttribute("xmlns:nomina12", $comprobante["xmlns:nomina12"]);
		$objetoXML->writeAttribute("xsi:schemaLocation", $comprobante["xsi:schemaLocation"]);
		$objetoXML->writeAttribute("Serie", $comprobante["Serie"]);
		$objetoXML->writeAttribute("Folio", $comprobante["Folio"]);
		$objetoXML->writeAttribute("Fecha", $fecha_solicitud_factura_service);
		$objetoXML->writeAttribute("FormaPago", $comprobante["FormaPago"]);
		$objetoXML->writeAttribute("NoCertificado", $comprobante["NoCertificado"]);
		$objetoXML->writeAttribute("Certificado", $comprobante["Certificado"]);
		//$objetoXML->writeAttribute("CondicionesDePago", $comprobante["CondicionesDePago"]);
		$objetoXML->writeAttribute("SubTotal", $comprobante["SubTotal"]);
		$objetoXML->writeAttribute("Moneda", $comprobante["Moneda"]);
		$objetoXML->writeAttribute("Total", $comprobante["Total"]);
		$objetoXML->writeAttribute("TipoDeComprobante", $comprobante["TipoDeComprobante"]);
		$objetoXML->writeAttribute("Exportacion", $comprobante["Exportacion"]);
		$objetoXML->writeAttribute("MetodoPago", $comprobante["MetodoPago"]);
		$objetoXML->writeAttribute("LugarExpedicion", $comprobante["LugarExpedicion"]);

		$objetoXML->startElement('cfdi:InformacionGlobal');
		$objetoXML->writeAttribute("Periodicidad", $informacionGlobal["Periodicidad"]);
		$objetoXML->writeAttribute("Meses", $informacionGlobal["Meses"]);
		$objetoXML->writeAttribute("Años", $informacionGlobal["Anio"]);
		$objetoXML->endElement();

		$objetoXML->startElement('cfdi:Emisor');
		$objetoXML->writeAttribute("Rfc", $emisor["Rfc"]);
		$objetoXML->writeAttribute("Nombre", $emisor["Nombre"]);
		$objetoXML->writeAttribute("RegimenFiscal", $emisor["RegimenFiscal"]);
		$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.

		$objetoXML->startElement('cfdi:Receptor');
		$objetoXML->writeAttribute("Rfc", $receptor["Rfc"]);
		$objetoXML->writeAttribute("Nombre", $receptor["Nombre"]);
		$objetoXML->writeAttribute("DomicilioFiscalReceptor", $receptor["DomicilioFiscalReceptor"]);
		$objetoXML->writeAttribute("UsoCFDI", $receptor["UsoCFDI"]);
		$objetoXML->writeAttribute("RegimenFiscalReceptor", $receptor["RegimenFiscalReceptor"]);
		$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.

		$objetoXML->startElement('cfdi:Conceptos');
		foreach ($conceptos as $concepto) {
			$objetoXML->startElement('cfdi:Concepto');
				$objetoXML->writeAttribute("ClaveProdServ", $concepto["ClaveProdServ"]);
				$objetoXML->writeAttribute("NoIdentificacion", $concepto["NoIdentificacion"]);
				$objetoXML->writeAttribute("Cantidad", $concepto["Cantidad"]);
				$objetoXML->writeAttribute("ClaveUnidad", $concepto["ClaveUnidad"]);
				//$objetoXML->writeAttribute("Unidad", $concepto["Unidad"]);
				$objetoXML->writeAttribute("Descripcion", $concepto["Descripcion"]);
				$objetoXML->writeAttribute("ValorUnitario", $concepto["ValorUnitario"]);
				$objetoXML->writeAttribute("Importe", $concepto["Importe"]);
				$objetoXML->writeAttribute("ObjetoImp", $concepto["ObjetoImp"]);
				$objetoXML->startElement('cfdi:Impuestos');
					$objetoXML->startElement('cfdi:Traslados');
						$objetoXML->startElement('cfdi:Traslado');
						$objetoXML->writeAttribute("Base", $concepto["Base"]);
						$objetoXML->writeAttribute("Impuesto", $concepto["Impuesto"]);
						$objetoXML->writeAttribute("TipoFactor", $concepto["TipoFactor"]);
						$objetoXML->endElement();
					$objetoXML->endElement();
				$objetoXML->endElement();
			$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
			
			

		}
		$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
		$objetoXML->startElement('cfdi:Impuestos');
		$objetoXML->writeAttribute("TotalImpuestosTrasladados", $impuestos["TotalImpuestosTrasladados"]);
			$objetoXML->startElement('cfdi:Traslados');
				$objetoXML->startElement('cfdi:Traslado');
				$objetoXML->writeAttribute("Base", $impuestos["Base"]);
				$objetoXML->writeAttribute("Impuesto", $impuestos["Impuesto"]);
				$objetoXML->writeAttribute("TipoFactor", $impuestos["TipoFactor"]);
				$objetoXML->writeAttribute("TasaOCuota", $impuestos["TasaOCuota"]);
				$objetoXML->writeAttribute("Importe", $impuestos["Importe"]);
				$objetoXML->endElement();
			$objetoXML->endElement();
		$objetoXML->endElement();

		$objetoXML->fullEndElement(); // Final del elemento "obra" que cubre cada obra de la matriz.
		$objetoXML->endElement(); // Final del nodo raíz, "obras"
		$objetoXML->endDocument(); // Final del documento

		$content = $objetoXML->outputMemory();
		return $content;
	}

	public function descargarFactura(Request $request)
	{
		$datos = $request->all();
		
		$facturaG = FacturaG::with('facturaGLineas')->find($datos['id']);

		$url = Param::where('llave', 'fact_global_url')->first();

		$fact_global_prb_activa = Param::where('llave', 'fact_global_prb_activa')->first();

		$data = array();


		//'xmlns:iedu' => 'http://www.sat.gob.mx/iedu',
		$comprobante = array(
			'Version' => '4.0',
			'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
			'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/4',
			'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd',
			'Certificado' => '', //?
			'NoCertificado' => '', //?
			'Serie' => '', //?
			'Folio' => '', //?
			'Fecha' => Carbon::createFromFormat('Y-m-d h:i:s', $facturaG->fecha)->format('Y-m-d\TH:i:s'),
			'FormaPago' => $facturaG->forma_pago,
			//'CondicionesDePago' => 'CONTADO',
			'TipoDeComprobante' => $facturaG->tipo_comprobante,
			'Moneda' => 'MXN',
			'LugarExpedicion' => $facturaG->lugar_expedicion,
			'Exportacion' => $facturaG->exportacion,
			'SubTotal' => $facturaG->total,
			'Total' => $facturaG->total,
			'MetodoPago' => 'PUE',
			'Sello' => ''
		);

		$informacionGlobal = array(
			'Periodicidad' => $facturaG->periodicidad,
			'Meses' => $facturaG->meses,
			'Anio' => $facturaG->anio
		);

		$emisor = array(
			'Rfc' => $facturaG->emisor_rfc,
			'Nombre' => $facturaG->emisor_nombre,
			'RegimenFiscal' => $facturaG->emisor_regimen_fiscal
		);
		$receptor = array(
			'Rfc' => 'XAXX010101000',
			'Nombre' => 'PUBLICO EN GENERAL',
			'DomicilioFiscalReceptor' => $facturaG->lugar_expedicion, //Por definir
			'UsoCFDI' => 'S01', //Por definir
			'RegimenFiscalReceptor' => "616" //Definir default
		);

		$lineas = FacturaGLinea::where('factura_g_id', $facturaG->id)
			->where('bnd_incluido', 1)
			->get();

		$conceptos = array();
		//dd($facturaGeneral->facturaGeneralLineas->toArray());
		foreach ($lineas as $linea) {

			$concepto = array(
				'ClaveProdServ' => '01010101',
				'NoIdentificacion' => $linea->folio,
				'Cantidad' => '1',
				'ClaveUnidad' => 'ACT',
				//'Unidad' => 'ACT',
				'Descripcion' => 'VENTA',
				'ValorUnitario' => $linea->abono,
				'Importe' => $linea->abono,
				'Descuento' => '0.00',
				'ObjetoImp' => "02",
				'Base' => $linea->abono, // desglose de impuestos por concepto
				'Impuesto'=>'002', // desglose de impuestos por concepto
				'TipoFactor'=>'Exento' // desglose de impuestos por concepto
			);
			array_push($conceptos, $concepto);
		}

		$fecha_solicitud_factura_service = date('Y-m-d\TH:i:s');
		// desglose de impuestos de la factura
		$impuestos=array(
			'TotalImpuestosTrasladados'=> '0.00',
			'Base' => number_format($facturaG->total, 2, '.', ''),
			'Importe' => '0.00',
			'Impuesto' => '002',
			'TasaOCuota' => '0.000000',
			'TipoFactor' => 'Exento'
		);

		$content = $this->crearXmlFactura($comprobante, $fecha_solicitud_factura_service, $informacionGlobal, $emisor, $receptor, $conceptos, $impuestos);

		/*echo "<pre>";
		var_export($content);
		echo "</pre>";
		*/

		//dd($content);
		//comentando lineas que generan una descarga de archivo

		
		ob_end_clean();
		ob_start();
		header('Content-Type: application/xml; charset=UTF-8');
		header('Content-Encoding: UTF-8');
		header("Content-Disposition: attachment;filename=" . $facturaG->cuentasEfectivo->no_cuenta . $facturaG->fecha . ".xml");
		header('Expires: 0');
		header('Pragma: cache');
		header('Cache-Control: private');
		echo $content;
		
		//return redirect()->route('facturaGs.show', $facturaG->id);
	}

	public function solicitarFactura(Request $request)
	{
		$datos = $request->all();
		$facturaG = FacturaG::find($datos['id']);
		$url_aux = Param::where('llave', 'fact_global_url')->first();
		$url = $url_aux->valor . "descargar/";
		//dd($url);
		$fact_prb_activa = Param::where('llave', 'fact_prb_activa')->first();

		$data = array();

		if ($fact_prb_activa->valor == 1) {
			$fact_global_id_usu_prb = Param::where('llave', 'fact_global_id_usu_prb')->first();
			$fact_global_pass_usu_prb = Param::where('llave', 'fact_global_pass_usu_prb')->first();
			$data = array(
				"uid" => $fact_global_id_usu_prb->valor,
				"pwd" => $fact_global_pass_usu_prb->valor,
				"doc" => $facturaG->uuid,
				"res" => "ziplnk",
				"tpo" => "",
				"pln" => ""
			);
		} else {
			$data = array(
				"uid" => $facturaG->plantel->fact_global_id_usu,
				"pwd" => $facturaG->plantel->fact_global_pass_usu,
				"doc" => $facturaG->uuid,
				"res" => "ziplnk",
				"tpo" => "",
				"pln" => ""
			);
		}

		//dd($data);
		$opciones = array(
			"http" => array(
				"header" => "Content-type: application/x-www-form-urlencoded\r\n",
				"method" => "POST",
				"content" => http_build_query($data), # Agregar el contenido definido antes
			),
		);
		# Preparar petición
		$contexto = stream_context_create($opciones);

		//*****para ver el flujo durante la invocación
		$flujo = fopen($url, 'r', false, $contexto);
		stream_set_blocking($flujo, false);
		//***************

		//*******************respuestas en formato json
		$resultado = file_get_contents($url, false, $contexto);
		//dd($contexto);

		$data = json_decode($resultado, true);

		echo json_encode($data);

		if ($data["success"] == false) {
			echo "Error:" . $data["message"];
			exit;
		}

		# si fue existoso
		if ($data["success"] == true) {
			/*echo "<br>";
			echo "<br>";
			echo "<label>Puede descargar el zip dando click en el botón </label>";
			echo "<a href='".$data["data"]["link"]."'><button style='background:green;'>Descargar</button></a>";
			*/
			return redirect()->away($data["data"]["link"]);
		} {
			dd('Recurso no encontrado');
		}
	}
}
