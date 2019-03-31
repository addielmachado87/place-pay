@extends('layout')
@section('content')
<div class="col-md-12">
    <h1>Crear Pago</h1>
    @if(Session::has('error'))
        <p class="alert alert-danger">{{ Session::get('error') }}</p>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<div class="col-md-12">
    <div class="col-md-9 ">
    <form action="{{ route('create-payment') }}" target="_blank" name="buyer" method="POST" role="form">
        {!! csrf_field() !!}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre">
            </div>
            <div class="form-group col-md-6">
                <label>Apellidos</label>
                <input type="test" class="form-control" id="surname" name="surname" placeholder="Apellido">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Correo</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label>Movil</label>
                <input type="text" class="form-control" id="movile" name="movile" placeholder="Movil">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Documento</label>
                <input type="text" class="form-control" id="document" name="document" placeholder="Documento">
            </div>
            <div class="form-group col-md-6">
                <label>Tipo Documento </label>
                <input type="text" class="form-control" id="document_type" name="document_type"
                       placeholder="Tipo Documento">
            </div>
        </div>
        <div class="form-group">
            <label>Direccion</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="1234 Avenida">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label >Ciudad</label>
                <input type="text" class="form-control" id="city" name="city">
            </div>
            <div class="form-group col-md-4">
                <label >Pais</label>
                <input type="text" class="form-control" id="country" name="country">
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label >Monto</label>
                <input type="text" class="form-control" id="total" name="total">
            </div>
            <div class="form-group col-md-6">
                <label >Moneda</label>
                <select id="currency" name="currency"  class="form-control">
                    <option value="COP">COP</option>
                    <option value="USD">USD</option>
                </select>
            </div>

        </div>
        <div class="form-group">
            <div class="form-check">
                <button class="btn btn-primary" type="submit" >
                    Enviar
                </button>

            </div>
        </div>

    </form>
    </div>
</div>
@endsection