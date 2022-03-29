<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Caja;
use App\FacturaGeneral;
use App\FacturaGeneralLinea;
use App\Mese;
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
use XMLWriter;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class FacturaGeneralsController extends Controller
{

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
			->with('list', FacturaGeneral::getListFromAllRelationApps());
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
		$input['usu_alta_id'] = Auth::user()->id;
		$input['usu_mod_id'] = Auth::user()->id;

		//create data
		FacturaGeneral::create($input);

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
		$facturaGeneral = $facturaGeneral->find($id);
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
		$facturaGeneral = $facturaGeneral->find($id);
		return view('facturaGenerals.edit', compact('facturaGeneral'))
			->with('list', FacturaGeneral::getListFromAllRelationApps());
	}

	/**
	 * Show the form for duplicatting the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function duplicate($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral = $facturaGeneral->find($id);
		return view('facturaGenerals.duplicate', compact('facturaGeneral'))
			->with('list', FacturaGeneral::getListFromAllRelationApps());
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
		$input['usu_mod_id'] = Auth::user()->id;
		//update data
		$facturaGeneral = $facturaGeneral->find($id);
		$facturaGeneral->update($input);

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Actualizado.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, FacturaGeneral $facturaGeneral)
	{
		$facturaGeneral = $facturaGeneral->find($id);
		$facturaGeneral->usu_eliminar_id = Auth::user()->id;
		$facturaGeneral->save();
		$facturaGeneral->delete();

		return redirect()->route('facturaGenerals.index')->with('message', 'Registro Borrado.');
	}

	public function recargarLineas($id)
	{
		$facturaGeneral = FacturaGeneral::find($id);
		$lineas = FacturaGeneralLinea::where('factura_general_id', $facturaGeneral->id)->get();
		if ($lineas->count() > 0) {
			foreach ($lineas as $ln) {
				$ln->delete();
			}
		}
		$registrosSinFactura = Caja::select(
			'pla.razon',
			'c.id as cliente_id',
			'c.nombre',
			'c.nombre2',
			'c.ape_paterno',
			'c.ape_materno',
			'cajas.fecha as fecha_caja',
			'p.fecha as fecha_pago',
			'cc.name as concepto',
			'p.uuid',
			'cajas.id as caja_id',
			'p.id as pago_id',
			'p.monto',
			'a.id as adeudo_id'
		)
			->join('caja_lns as ln', 'ln.caja_id', '=', 'cajas.id')
			->join('clientes as c', 'c.id', '=', 'cajas.cliente_id')
			->join('adeudos as a', 'a.id', '=', 'ln.adeudo_id')
			->join('caja_conceptos as cc', 'cc.id', '=', 'ln.caja_concepto_id')
			->join('pagos as p', 'p.caja_id', '=', 'cajas.id')
			->join('plantels as pla', 'pla.id', '=', 'cajas.plantel_id')
			->where('a.pagado_bnd', 1)
			->where('p.fecha', '<=', $facturaGeneral->fec_fin)
			->where('p.fecha', '>=', $facturaGeneral->fec_inicio)
			->where('cajas.fecha', '<=', $facturaGeneral->fec_fin)
			->where('cajas.fecha', '>=', $facturaGeneral->fec_inicio)
			->where('pla.id', $facturaGeneral->plantel_id)
			->where('a.pagado_bnd', 1)
			->where('cc.bnd_mensualidad', 1)
			->whereNull('p.uuid')
			->whereNull('a.deleted_at')
			->whereNull('cajas.deleted_at')
			->whereNull('ln.deleted_at')
			->whereNull('p.deleted_at')
			->orderBy('cajas.cliente_id')
			->orderBy('p.fecha')
			->get();
		//dd($registrosSinFactura->toArray());
		foreach ($registrosSinFactura as $registro) {
			$input['factura_general_id'] = $facturaGeneral->id;
			$input['cliente_id'] = $registro->cliente_id;
			$input['caja_id'] = $registro->caja_id;
			$input['pago_id'] = $registro->pago_id;
			$input['bnd_incluido'] = 1;
			$input['monto'] = $registro->monto;
			$input['usu_mod_id'] = Auth::user()->id;
			$input['usu_alta_id'] = Auth::user()->id;
			FacturaGeneralLinea::create($input);
			$suma = $suma + $registro->monto;
		}
		$facturaGeneral->total = $suma;
		$facturaGeneral->save();

		//$this->detalle($facturaGeneral->id);
		return redirect()->route('facturaGenerals.detalle', $facturaGeneral->id);
	}

	public function detalle($id)
	{
		$facturaGeneral = FacturaGeneral::find($id);
		$lineas = FacturaGeneralLinea::where('factura_general_id', $facturaGeneral->id)
			->where('bnd_manual', '<>', 1)
			->orWhereNull('bnd_manual')
			->with('caja')
			->with('pago')
			->with('cliente')
			->with('facturaGeneral')
			->get();
		//dd($lineas);
		$lineas_manuales = FacturaGeneralLinea::where('factura_general_id', $facturaGeneral->id)
			->where('bnd_manual', 1)
			->get();

		//dd($facturaGeneral);

		//dd($registrosSinFactura->toArray());

		return view('facturaGenerals.detalle', compact('lineas', 'lineas_manuales', 'facturaGeneral'));
	}

	public function total(Request $request)
	{
		$datos = $request->all();
		$facturaGeneral = FacturaGeneral::find($datos['id']);
		$suma = FacturaGeneralLinea::where('factura_general_id', $datos['id'])->where('bnd_incluido', 1)->sum('monto');

		$facturaGeneral->total = $suma;
		$facturaGeneral->save();

		$lineas = FacturaGeneralLinea::where('factura_general_id', $facturaGeneral->id)
			->where('bnd_manual', '<>', 1)
			->orWhereNull('bnd_manual')
			->with('caja')
			->with('pago')
			->with('cliente')
			->with('facturaGeneral')
			->get();
		$lineas_manuales = FacturaGeneralLinea::where('factura_general_id', $facturaGeneral->id)
			->where('bnd_manual', 1)
			->get();
		return view('facturaGenerals.detalle', compact('lineas', 'lineas_manuales', 'facturaGeneral'));
	}

	public function generarFactura(Request $request)
	{
		$datos = $request->all();
		$facturaGeneral = FacturaGeneral::with('plantel')->with('facturaGeneralLineas')->find($datos['id']);

		$url = Param::where('llave', 'fact_global_url')->first();
		
		$fact_global_prb_activa = Param::where('llave', 'fact_global_prb_activa')->first();

		$data = array();

		if ($fact_global_prb_activa->valor == 1) {
			//'xmlns:iedu' => 'http://www.sat.gob.mx/iedu',
			$comprobante = array(
				'Version' => '4.0',
				'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
				'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/4',
				'xmlns:divisas' => 'http://www.sat.gob.mx/divisas',
				'xmlns:donat' => 'http://www.sat.gob.mx/donat',
				'xmlns:notariospublicos' => 'http://www.sat.gob.mx/notariospublicos',
				'xmlns:implocal' => 'http://www.sat.gob.mx/implocal',
				'xmlns:ine' => 'http://www.sat.gob.mx/ine',
				'xmlns:cartaporte20' => 'http://www.sat.gob.mx/CartaPorte20',
				'xmlns:nomina12' => 'http://www.sat.gob.mx/nomina12',
				'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/divisas http://www.sat.gob.mx/sitio_internet/cfd/divisas/divisas.xsd http://www.sat.gob.mx/donat http://www.sat.gob.mx/sitio_internet/cfd/donat/donat11.xsd http://www.sat.gob.mx/notariospublicos http://www.sat.gob.mx/sitio_internet/cfd/notariospublicos/notariospublicos.xsd http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd http://www.sat.gob.mx/ine http://www.sat.gob.mx/sitio_internet/cfd/ine/ine11.xsd http://www.sat.gob.mx/CartaPorte20 http://www.sat.gob.mx/sitio_internet/cfd/CartaPorte/CartaPorte20.xsd http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd',
				'Certificado' => '', //?
				'NoCertificado' => '', //?
				'Serie' => '', //?
				'Folio' => '', //?
				'Fecha' => Carbon::createFromFormat('Y-m-d h:i:s', $facturaGeneral->fecha_factura)->format('Y-m-d\TH:i:s'),
				'FormaPago' => '01',
				'CondicionesDePago' => 'CONTADO',
				'TipoDeComprobante' => 'I',
				'Moneda' => 'MXN',
				'LugarExpedicion' => '29000', //$facturaGeneral->plantel->cp,
				'Exportacion' => '01',
				'SubTotal' => $facturaGeneral->total,
				'Total' => $facturaGeneral->total,
				'MetodoPago' => 'PUE',
				'Sello' => ''
			);

			$informacionGlobal = array(
				'Periodicidad' => '04',
				'Meses' => Carbon::createFromFormat('Y-m-d h:i:s', $facturaGeneral->fecha_factura)->format('m'),
				'Anio' => carbon::createFromFormat('Y-m-d h:i:s', $facturaGeneral->fecha_factura)->format('Y')
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

			$lineas = FacturaGeneralLinea::where('factura_general_id', $facturaGeneral->id)
				->where('bnd_incluido', 1)
				->get();

			$conceptos = array();
			//dd($facturaGeneral->facturaGeneralLineas->toArray());
			foreach ($lineas as $linea) {
				if ($linea->bnd_manual == 1) {
					$concepto = array(
						'ClaveProdServ' => '01010101',
						'NoIdentificacion' => $linea->serie_factura . " " . $linea->folio_facturado,
						'Cantidad' => '1',
						'ClaveUnidad' => 'ACT',
						'Unidad' => 'ACT',
						'Descripcion' => 'VENTA',
						'ValorUnitario' => $linea->monto,
						'Importe' => $linea->monto,
						'ObjetoImp' => "01"
					);
					array_push($conceptos, $concepto);
				} else {
					$concepto = array(
						'ClaveProdServ' => '01010101',
						'NoIdentificacion' => $linea->pago->serie_factura . " " . $linea->pago->folio_facturado,
						'Cantidad' => '1',
						'ClaveUnidad' => 'ACT',
						'Unidad' => 'ACT',
						'Descripcion' => 'VENTA',
						'ValorUnitario' => $linea->monto,
						'Importe' => $linea->monto,
						'Descuento' => '0.00',
						'ObjetoImp' => "01"
					);
					array_push($conceptos, $concepto);
				}
			}
			/*
			$impuestos = array('TotalImpuestosTrasladados' => 0.0);
			
			$mes = Carbon::createFromFormat('Y-m-d', $facturaGeneral->fec_inicio)->month;
			$mesLetra = Mese::find($mes);
			$anio = Carbon::createFromFormat('Y-m-d', $facturaGeneral->fec_inicio)->year;
			$adenda = array(
				'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
				'xsi:schemaLocation' => 'http://dev.induxsoft.net/xsd/cfdi/addendas/addendabasica.xsd http://dev.induxsoft.net/xsd/cfdi/addendas/addendabasica.xsd',
				'xmlns:induxsoft' => 'http://dev.induxsoft.net/xsd/cfdi/addendas/addendabasica.xsd',
				'notas' => 'Este comprobante corresponde a los ingresos globales de ' . $mesLetra->name . " " . $anio
			);

			$formatter = new NumeroALetras;
			$totalEntero = intdiv($facturaGeneral->total, 1);
			$centavos = round((round($facturaGeneral->total, 2) - $totalEntero) * 100);
			//dd($centavos);
			$totalLetra = $formatter->toMoney($totalEntero, 2, "", 'Centavos');
			//dd($totalLetra);

			$adendaEtiquetas = array(
				array(
					'id' => 'NumLetraTotalDocumento',
					'titulo' => 'Total con letras',
					'valor' => '(' . $totalLetra . 'PESO MEXICANO ' . $centavos . '/100 MXN)'
				),
				array(
					'id' => 'DirEmisor',
					'titulo' => 'Domicilio de expedición',
					'valor' => $facturaGeneral->plantel->calle . " " . $facturaGeneral->plantel->no_ext . " " . $facturaGeneral->plantel->colonia,
					'valor2' => $facturaGeneral->plantel->municipio . " " . $facturaGeneral->plantel->estado . " Mexico"
				)
			);*/
			$fecha_solicitud_factura_service = date('Y-m-d\TH:i:s');
		} else {
			//'xmlns:iedu' => 'http://www.sat.gob.mx/iedu',
			$comprobante = array(
				'Version' => '4.0',
				'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
				'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/4',
				'xmlns:divisas' => 'http://www.sat.gob.mx/divisas',
				'xmlns:donat' => 'http://www.sat.gob.mx/donat',
				'xmlns:notariospublicos' => 'http://www.sat.gob.mx/notariospublicos',
				'xmlns:implocal' => 'http://www.sat.gob.mx/implocal',
				'xmlns:ine' => 'http://www.sat.gob.mx/ine',
				'xmlns:cartaporte20' => 'http://www.sat.gob.mx/CartaPorte20',
				'xmlns:nomina12' => 'http://www.sat.gob.mx/nomina12',
				'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/divisas http://www.sat.gob.mx/sitio_internet/cfd/divisas/divisas.xsd http://www.sat.gob.mx/donat http://www.sat.gob.mx/sitio_internet/cfd/donat/donat11.xsd http://www.sat.gob.mx/notariospublicos http://www.sat.gob.mx/sitio_internet/cfd/notariospublicos/notariospublicos.xsd http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd http://www.sat.gob.mx/ine http://www.sat.gob.mx/sitio_internet/cfd/ine/ine11.xsd http://www.sat.gob.mx/CartaPorte20 http://www.sat.gob.mx/sitio_internet/cfd/CartaPorte/CartaPorte20.xsd http://www.sat.gob.mx/nomina12 http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd',
				'Serie' => '', //?
				'Folio' => '', //?
				'Fecha' => Carbon::createFromFormat('Y-m-d h:i:s', $facturaGeneral->fecha_factura)->format('Y-m-d\TH:i:s'),
				'NoCertificado' => '', //?
				'Moneda' => 'MXN',
				'SubTotal' => $facturaGeneral->total,
				'TipoDeComprobante' => 'I',
				'LugarExpedicion' => $facturaGeneral->plantel->cp,
				'Exportacion' => '01',
				'Total' => $facturaGeneral->total,
				'FormaPago' => '01',
				'MetodoPago' => 'PUE',
				'CondicionesDePago' => 'CONTADO',
				'Certificado' => '',
				'Sello' => ''
			);

			$informacionGlobal = array(
				'Periodicidad' => '04',
				'Meses' => Carbon::createFromFormat('Y-m-d h:i:s', $facturaGeneral->fecha_factura)->format('m'),
				'Anio' => carbon::createFromFormat('Y-m-d h:i:s', $facturaGeneral->fecha_factura)->format('Y')
			);

			$emisor = array(
				'Rfc' => $facturaGeneral->plantel->rfc,
				'Nombre' => $facturaGeneral->plantel->nombre_corto,
				'RegimenFiscal' => $facturaGeneral->plantel->regimen_fiscal
			);
			$receptor = array(
				'Rfc' => 'XAXX010101000',
				'Nombre' => 'PUBLICO EN GENERAL',
				'DomicilioFiscalReceptor' => $facturaGeneral->plantel->cp, //Por definir
				'UsoCFDI' => 'S01', //Por definir
				'RegimenFiscalReceptor' => "616" //Definir default
			);

			$lineas = FacturaGeneralLinea::where('factura_general_id', $facturaGeneral->id)
				->where('bnd_incluido', 1)
				->get();

			$conceptos = array();
			//dd($facturaGeneral->facturaGeneralLineas->toArray());
			foreach ($lineas as $linea) {
				if ($linea->bnd_manual == 1) {
					$concepto = array(
						'ClaveProdServ' => '01010101',
						'NoIdentificacion' => $linea->serie_factura . " " . $linea->folio_facturado,
						'Cantidad' => '1',
						'ClaveUnidad' => 'ACT',
						'Unidad' => 'ACT',
						'Descripcion' => 'VENTA',
						'ValorUnitario' => $linea->monto,
						'Importe' => $linea->monto,
						'ObjetoImp' => "01"
					);
					array_push($conceptos, $concepto);
				} else {
					$concepto = array(
						'ClaveProdServ' => '01010101',
						'NoIdentificacion' => $linea->pago->serie_factura . " " . $linea->pago->folio_facturado,
						'Cantidad' => '1',
						'ClaveUnidad' => 'ACT',
						'Unidad' => 'ACT',
						'Descripcion' => 'VENTA',
						'ValorUnitario' => $linea->monto,
						'Importe' => $linea->monto,
						'Descuento' => '0.00',
						'ObjetoImp' => "01"
					);
					array_push($conceptos, $concepto);
				}
			}
			/*
			$impuestos = array('TotalImpuestosTrasladados' => 0.0);

			$mes = Carbon::createFromFormat('Y-m-d', $facturaGeneral->fec_inicio)->month;
			$mesLetra = Mese::find($mes);
			$anio = Carbon::createFromFormat('Y-m-d', $facturaGeneral->fec_inicio)->year;
			$adenda = array(
				'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
				'xsi:schemaLocation' => 'http://dev.induxsoft.net/xsd/cfdi/addendas/addendabasica.xsd http://dev.induxsoft.net/xsd/cfdi/addendas/addendabasica.xsd',
				'xmlns:induxsoft' => 'http://dev.induxsoft.net/xsd/cfdi/addendas/addendabasica.xsd',
				'notas' => 'Este comprobante corresponde a los ingresos globales de ' . $mesLetra->name . " " . $anio
			);

			$formatter = new NumeroALetras;
			$totalEntero = intdiv($facturaGeneral->total, 1);
			$centavos = round((round($facturaGeneral->total, 2) - $totalEntero) * 100);
			$totalLetra = $formatter->toMoney($totalEntero, 2, "", 'Centavos');
		

			$adendaEtiquetas = array(
				array(
					'id' => 'NumLetraTotalDocumento',
					'titulo' => 'Total con letras',
					'valor' => '(' . $totalLetra . 'PESO MEXICANO ' . $centavos . '/100 MXN)'
				),
				array(
					'id' => 'DirEmisor',
					'titulo' => 'Domicilio de expedición',
					'valor' => $facturaGeneral->plantel->calle . " " . $facturaGeneral->plantel->no_ext . " " . $facturaGeneral->plantel->colonia,
					'valor2' => $facturaGeneral->plantel->municipio . " " . $facturaGeneral->plantel->estado . " Mexico"
				)
			);*/
			$fecha_solicitud_factura_service = date('Y-m-d\TH:i:s');
		}

		$content = $this->crearXmlFactura($comprobante, $fecha_solicitud_factura_service, $informacionGlobal, $emisor, $receptor, $conceptos);

		/*echo "<pre>";
		var_export($content);
		echo "</pre>";
		*/

		//dd($content);
		//comentando lineas que generan una descarga de archivo

		/*
		ob_end_clean();
		ob_start();
		header('Content-Type: application/xml; charset=UTF-8');
		header('Content-Encoding: UTF-8');
		header("Content-Disposition: attachment;filename=" . $facturaGeneral->plantel_id . $facturaGeneral->fec_inicio . $facturaGeneral->fec_fin . ".xml");
		header('Expires: 0');
		header('Pragma: cache');
		header('Cache-Control: private');
		echo $content;
		*/
		$data=array();
		//dd($fact_global_prb_activa->valor);
		if($fact_global_prb_activa->valor==1){
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
		}else{
			$data = array(
				"cti" => $facturaGeneral->plantel->fact_global_id_cuenta,
				"pwd" => $facturaGeneral->plantel->fact_global_pass_cuenta,
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
			$facturaGeneral->error_last = $objR->data;
			$facturaGeneral->save();
		} else {
			$facturaGeneral->uuid = $objR->data->uuid;
			$facturaGeneral->xml = base64_decode($objR->data->xml);
			$facturaGeneral->save();
		}

		return redirect()->route('facturaGenerals.detalle', $facturaGeneral->id);
	}

	public function crearXmlFactura($comprobante, $fecha_solicitud_factura_service, $informacionGlobal, $emisor, $receptor, $conceptos)
	{
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
		$objetoXML->writeAttribute("xmlns:divisas", $comprobante["xmlns:divisas"]);
		$objetoXML->writeAttribute("xmlns:donat", $comprobante["xmlns:donat"]);
		$objetoXML->writeAttribute("xmlns:notariospublicos", $comprobante["xmlns:notariospublicos"]);
		$objetoXML->writeAttribute("xmlns:implocal", $comprobante["xmlns:implocal"]);
		$objetoXML->writeAttribute("xmlns:ine", $comprobante["xmlns:ine"]);
		$objetoXML->writeAttribute("xmlns:cartaporte20", $comprobante["xmlns:cartaporte20"]);
		$objetoXML->writeAttribute("xmlns:nomina12", $comprobante["xmlns:nomina12"]);
		$objetoXML->writeAttribute("xsi:schemaLocation", $comprobante["xsi:schemaLocation"]);
		$objetoXML->writeAttribute("Certificado", $comprobante["Certificado"]);
		$objetoXML->writeAttribute("NoCertificado", $comprobante["NoCertificado"]);
		$objetoXML->writeAttribute("Serie", $comprobante["Serie"]);
		$objetoXML->writeAttribute("Folio", $comprobante["Folio"]);
		$objetoXML->writeAttribute("Fecha", $fecha_solicitud_factura_service);
		$objetoXML->writeAttribute("FormaPago", $comprobante["FormaPago"]);
		$objetoXML->writeAttribute("CondicionesDePago", $comprobante["CondicionesDePago"]);
		$objetoXML->writeAttribute("TipoDeComprobante", $comprobante["TipoDeComprobante"]);
		$objetoXML->writeAttribute("Moneda", $comprobante["Moneda"]);
		$objetoXML->writeAttribute("LugarExpedicion", $comprobante["LugarExpedicion"]);
		$objetoXML->writeAttribute("Exportacion", $comprobante["Exportacion"]);
		$objetoXML->writeAttribute("SubTotal", $comprobante["SubTotal"]);
		$objetoXML->writeAttribute("Total", $comprobante["Total"]);
		$objetoXML->writeAttribute("MetodoPago", $comprobante["MetodoPago"]);

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
		$objetoXML->writeAttribute("Nombre", $receptor["Nombre"]);
		$objetoXML->writeAttribute("DomicilioFiscalReceptor", $receptor["DomicilioFiscalReceptor"]);
		$objetoXML->writeAttribute("Rfc", $receptor["Rfc"]);
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
			$objetoXML->writeAttribute("Unidad", $concepto["Unidad"]);
			$objetoXML->writeAttribute("Descripcion", $concepto["Descripcion"]);
			$objetoXML->writeAttribute("ValorUnitario", $concepto["ValorUnitario"]);
			$objetoXML->writeAttribute("Importe", $concepto["Importe"]);
			$objetoXML->writeAttribute("ObjetoImp", $concepto["ObjetoImp"]);
			$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
		}
		$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
		/*
		$objetoXML->startElement('cfdi:Impuestos');
		$objetoXML->writeAttribute("TotalImpuestosTrasladados", $impuestos["TotalImpuestosTrasladados"]);
		$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
		*/
		/*
		$objetoXML->startElement('cfdi:Addenda');
		$objetoXML->startElement('induxsoft:addenda');
		$objetoXML->writeAttribute("xmlns:xsi", $adenda["xmlns:xsi"]);
		$objetoXML->writeAttribute("xsi:schemaLocation", $adenda["xsi:schemaLocation"]);
		$objetoXML->writeAttribute("xmlns:induxsoft", $adenda["xmlns:induxsoft"]);
		$objetoXML->writeAttribute("notas", $adenda["notas"]);
		foreach ($adendaEtiquetas as $etiqueta) {
			$objetoXML->startElement('induxsoft:etiqueta');
			$objetoXML->writeAttribute("id", $etiqueta["id"]);
			$objetoXML->writeAttribute("titulo", $etiqueta["titulo"]);
			$objetoXML->writeAttribute("valor", $etiqueta["valor"]);
			if(isset($etiqueta["valor2"])){
				$objetoXML->writeAttribute("valor2", $etiqueta["valor2"]);
			}
			$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
		}

		$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
		$objetoXML->endElement(); // Final del elemento que cubre todos los miembros técnicos.
		*/
		$objetoXML->fullEndElement(); // Final del elemento "obra" que cubre cada obra de la matriz.
		$objetoXML->endElement(); // Final del nodo raíz, "obras"
		$objetoXML->endDocument(); // Final del documento

		$content = $objetoXML->outputMemory();
		return $content;
	}

	public function descargarFactura(Request $request)
	{
		$datos = $request->all();
		$facturaGeneral = FacturaGeneral::find($datos['id']);
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
				"doc" => $facturaGeneral->uuid,
				"res" => "ziplnk",
				"tpo" => "",
				"pln" => ""
			);
		} else {
			$data = array(
				"uid" => $facturaGeneral->plantel->fact_global_id_usu,
				"pwd" => $facturaGeneral->plantel->fact_global_pass_usu,
				"doc" => $facturaGeneral->uuid,
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
