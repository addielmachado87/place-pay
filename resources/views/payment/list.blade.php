@extends('layout')
@section('content')
    <div class="col-md-12">
        <h1>Listar Pagos</h1>
        <div class="table-responsive">
            <table class="table_calls table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Estado</th>
                    <th>Referencia</th>
                    <th>Descripcion</th>
                    <th>Modena</th>
                    <th>Monto</th>
                </tr>
                </thead>
                <tbody>
                @if($payments->count()==0)
                    <tr>
                        <td colspan="6"><h2 class="note note-warning">Not results found!</h2></td>
                    </tr>
                @endif
                @foreach ($payments as $payment)
                    <tr >
                        <td>
                            {{ $payment->sessions->request_id }}
                        </td>
                        <td>
                            {{ $payment->s_status }}
                        </td>
                        <td>
                            {{ $payment->reference }}
                        </td>
                        <td>
                            {{ $payment->description}}

                        </td>
                        <td>
                            {{ $payment->amount_currency}}

                        </td>
                        <td>
                            {{ $payment->amount_total}}

                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            {!!
            $payments->appends([
            'search' => Request::get('search'),
            'limit' => Request::get('limit')
            ])->render()
            !!}
        </div>

    </div>
    @endsection