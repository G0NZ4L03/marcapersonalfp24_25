@extends('layouts.master')

@section('content')
    <div class="row m-4">

        <div class="col-sm-4">

            <a href="#" class="image featured"
                title="Sakatsp, CC BY-SA 4.0 &lt;https://creativecommons.org/licenses/by-sa/4.0&gt;, via Wikimedia Commons"><img
                    width="256" alt="Award icon"
                    src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Award_icon.png"></a>

        </div>
        <div class="col-sm-8">
            <h3><strong>Estudiante ID: </strong>{{ $reconocimiento->estudiante_id }}</h3>
            <h4><strong>Actividad ID: </strong>{{ $reconocimiento->actividad_id }}</h4>
            <h4><strong>Documento: </strong>
                <a href="{{ $reconocimiento->documento }}">{{ $reconocimiento->documento }}</a>
            </h4>
            <h4><strong>Fecha: </strong>{{ $reconocimiento->fecha }}</h4>
            <h4><strong>Docente Validador: </strong>{{ $reconocimiento->docente_validador }}</h4>
            <a href="{{ route('reconocimientos.edit', $reconocimiento->id) }}" class="btn btn-primary">Editar
                Reconocimiento</a>
            <a href="{{ route('reconocimientos.index') }}" class="btn btn-secondary">Volver al Listado</a>
        </div>
    </div>
    </div>
@endsection
