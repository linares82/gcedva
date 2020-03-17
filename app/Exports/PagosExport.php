<?php

namespace App\Exports;

use App\Caja;
use App\Cliente;
use App\Plantel;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Auth;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosExport implements FromView, ShouldAutoSize
{
    use Exportable;
    protected $registros;
    protected $plantel;
    protected $data;
    protected $resumen;

    public function __construct($registros, $plantel, $data, $resumen)
    {

        $this->registros = $registros;

        $this->plantel = $plantel;

        $this->data = $data;
        $this->resumen = $resumen;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        return view('pagos.reportes.postAlumnosBecaExcel', [
            'registros' => $this->registros,
            'plantel' => $this->plantel,
            'data' => $this->data,
            'resumen' => $this->resumen
        ]);
    }
}
