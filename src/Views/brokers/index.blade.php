@extends('activos::layouts.master')

@section('main_content')
<div class="row">
	<div class="col-md-6">
		<div class="box">

			<div class="box-header with-border">
				<h3 class="box-title">Listado de Broker's</h3>
			</div>

			<div class="box-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th rowspan="2" style="width: 10px">#</th>
							<th rowspan="2">Sigla</th>
							<th rowspan="2">Nombre</th>
							<th colspan="3">En Pesos</th>
							<th colspan="3">En Dólares</th>
						</tr>
						<tr>
							<th>Depósitos</th>
							<th>Extracciones</th>
							<th>Saldo</th>
							<th>Depósitos</th>
							<th>Extracciones</th>
							<th>Saldo</th>
						</tr>
						@php($posicion = 0)
						@php($suma_pesos = 0)
						@php($suma_dolares = 0)
						@foreach($movimientos as $movimiento)
						<tr>
							<td>{{ ++$posicion }}.</td>
							<td>{{ $movimiento->broker->sigla }}</td>
							<td>{{ $movimiento->broker->nombre }}</td>

							<td align="right">{{ number_format($movimiento->suma_de_depositos_en_pesos, 2, ',', '.') }}</td>
							<td align="right">{{ number_format($movimiento->suma_de_extracciones_en_pesos, 2, ',', '.') }}</td>
							@php($aportes = $movimiento->suma_de_depositos_en_pesos - $movimiento->suma_de_extracciones_en_pesos)
							@php($suma_pesos += $aportes)
							<td align="right">{{ number_format($aportes, 2, ',', '.') }}</td>

							<td align="right">{{ number_format($movimiento->suma_de_depositos_en_dolares, 2, ',', '.') }}</td>
							<td align="right">{{ number_format($movimiento->suma_de_extracciones_en_dolares, 2, ',', '.') }}</td>
							@php($aportes = $movimiento->suma_de_depositos_en_dolares - $movimiento->suma_de_extracciones_en_dolares)
							@php($suma_dolares += $aportes)
							<td align="right">{{ number_format($aportes, 2, ',', '.') }}</td>
						</tr>
						@endforeach
						<tr>
							<td></td>
							<td colspan="2"><b>Total de aportes netos</b></td>
							<td></td>
							<td></td>
							<td align="right"><b>{{ number_format($suma_pesos, 2, ',', '.') }}</b></td>
							<td></td>
							<td></td>
							<td align="right"><b>{{ number_format($suma_dolares, 2, ',', '.') }}</b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection