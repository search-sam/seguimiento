@extends('layouts.admin_template')

@section('content')
    @php use Carbon\Carbon; @endphp
    <div class='row'>
        @if (count($cliente))
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset( $usuario->foto_usuario ) }}" alt="User profile picture">
                    @if($usuario->empresa->nombre_empresa)
                    <h3 class="profile-username text-center">{{ $usuario->empresa->nombre_empresa }}</h3>
                    @endif
                    @if($usuario->nombre_usuario)
                    <p class="text-muted text-center">{{ $usuario->nombre_usuario }} {{ $usuario->apellido_usuario }}</p>
                    @endif
                    <ul class="list-group list-group-unbordered">
                        @if($usuario->empresa->contacto->cargo_contacto)
                        <li class="list-group-item">Cargo Contacto: <b class="pull-right">{{ $usuario->empresa->contacto->cargo_contacto }}</b></li>
                        @endif
                        @if($usuario->email_usuario)
                        <li class="list-group-item">Email: <b class="pull-right">{{ $usuario->email_usuario }}</b></li>
                        @endif
                        @if($usuario->estado_usuario)
                        <li class="list-group-item">Estado Usuario:
                            <b class="pull-right time-label">
                                @if ( $usuario->estado_usuario )
                                    <span class="bg-green">Activo</span>
                                @else
                                    <span class="bg-red">Inactivo</span>
                                @endif
                            </b>
                        </li>
                        @endif
                    </ul>
                    @if ($usuario->tipo_usuario == 1)
                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    @endif
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">                    
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Direcci&oacute;n</strong>
                    <p class="text-muted">{{ $usuario->empresa->direccion_empresa }}</p>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-9">
            <div class="box box-primary">

                <!-- /.box-header -->
                <div class="box-body">

                    @php $carbon = new Carbon($usuario->fecha_registro); @endphp

                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">

                        @foreach ($usuario->linea_tiempo as $evento)
                            <!-- timeline time label -->
                            @php
                                $update = new Carbon($evento->updated_at);
                            @endphp
                            @if ($loop->first)
                                @php $carbon = $update; @endphp
                                <li class="time-label"><span class="bg-purple">{{ $update->toFormattedDateString() }}</span></li><!-- /.timeline-label -->
                            @else
                                @if ( !$update->isSameDay($carbon) )
                                    @php $carbon = $update; @endphp
                                    <li class="time-label"><span class="bg-purple">{{ $update->toFormattedDateString() }}</span></li><!-- /.timeline-label -->
                                @endif
                            @endif

                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-user bg-aqua"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ $update->format('h:i A') }}</span>
                                    <h3 class="timeline-header no-border"><h3>{{ $evento->tipo_evento->evento }}</h3>
                                </div>
                            </li>
                            <!-- END timeline item -->
                        @endforeach

                        <li><i class="fa fa-clock-o bg-gray"></i></li>
                    </ul>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!-- /.nav-tabs-custom -->
        @else
            <p style="margin-left:20px; margin-bottom:0;">Perfil vacio, por favor registre la entidad de la empresa.</p>
            <div class="flex-center">
                <div class="content">
                    <img src="{{ asset('storage/slogo.svg') }}" alt="Seguimiento" height="300px">
                </div>
            </div>
        @endif
    </div><!-- /.row -->
@endsection
