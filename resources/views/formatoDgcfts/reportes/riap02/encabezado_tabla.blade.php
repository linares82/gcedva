                <table>
                    <thead>
                        <tr>
                            <th colspan="7" width="40%">INSCRIPCION</th>
                            <th colspan="{{ count($materias) }}" width="50%">ACREDITACION</th>
                            <th width="10%" colspan="2"></th>
                        </tr>
                        <tr>
                            <th rowspan="3">N<br />U<br />M<br />.</th>
                            <th rowspan="3">NUMERO DE CONTROL</th>
                            <th rowspan="3">NOMBRE DEL ALUMNO</th>
                            <th rowspan="3">EDAD</th>
                            <th rowspan="3">SEXO</th>
                            <th rowspan="3">ESCOLARIDAD</th>
                            <th rowspan="3">BECA %</th>
                            <th colspan="{{ count($materias) }}"> NOMBRE DE LA MATERIA</th>
                            <th rowspan="3">RESULTADO </th>
                            <th rowspan="3">FINAL</th>
                        </tr>
                        <tr>

                            @foreach ($materias as $materia)
                                <th>{{ $materia->name }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th colspan="{{ count($materias) }}">EVALUACIONES</th>
                        </tr>
                    </thead>