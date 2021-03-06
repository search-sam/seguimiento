<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\Rules\Cedula;
use Illuminate\Support\Facades\Storage;

// Eventos
use App\Events\MarcarComoLeida;
use App\Events\ActualizarSession;
use App\Events\GenerarLineaTiempo;

// Modelos
use App\Empresa;
use App\Contacto;
use App\Usuario;
use App\LineaTiempo;

class EmpresaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['usuario']    = session( 'usuario' );
        $data['cliente']    = Empresa::where( 'usuario_id', Auth::id() )->get();
        $data['page_title'] = 'Perfil de Empresa';
        $data['usuarios']   = Usuario::all();
        return view('tablero.perfil_empresa', $data);
    }

    public function registro()
    {
        $data['usuario']    = session( 'usuario' );
        $data['page_title'] = 'Registrar Identidad Empresarial';
        $data['usuarios']   = Usuario::all();
        return view('tablero.entidad', $data);
    }

    public function registrar(Request $request)
    {
        $validate = $request->validate([
            'nombre_empresa' => 'required|string',
            'direccion'      => 'required|string',
            'foto'           => 'nullable|image',
            'nombre'         => 'required|string',
            'apellido'       => 'required|string',
            'cargo'          => 'required|string',
            'email'          => 'required|email',
            'telefono'       => 'required|string',
        ]);

        // Guardar Empresa
        $empresa = new Empresa;
        if ( !empty($request->nombre_empresa) and !empty($request->direccion)  )
        {
            $empresa->nombre_empresa    = trim( $request->nombre_empresa );
            $empresa->direccion_empresa = trim( $request->direccion );
            $empresa->usuario_id        = Auth::id();
            $empresa->save();
        }

        // Almacenar y guardar foto de usuario
        if ( isset( $request->foto ) )
        {
            // Subir foto
            $img_dir = $request->file( 'foto' )->storeAs( 'fotos', $this->fotos_name( Auth::user()->name ) );

            // Guardar foto
            $usuario = Usuario::find( Auth::id() );
            $usuario->foto_usuario = 'storage/' . $img_dir;
            $usuario->save();

            event(new ActualizarSession( Auth::user() ));
        }

        // Guarda datos de contacto
        if ( !is_null($request->nombre) and !is_null($request->apellido) and !is_null($request->cargo) and !is_null($request->email) and !is_null($request->telefono) )
        {
            $contacto = new Contacto;
            $contacto->nombre_contacto        = trim( $request->nombre );
            $contacto->apellido_contacto      = trim( $request->apellido );
            $contacto->cargo_contacto         = trim( $request->cargo );
            $contacto->email_contacto         = trim( $request->email );
            $contacto->telefono_institucional = trim( $request->telefono );
            $contacto->empresa_id             = $empresa->id_empresa;
            $contacto->save();
        }

        event( new GenerarLineaTiempo( Auth::user(), 5 ) );
        event( new MarcarComoLeida( Auth::user(), 'RegistrarEntidadEmpresarial' ) );
        return redirect()->route( 'perfil_empresa' );
    }

    // Generar nombre de archivo para la foto de empresa
    public function fotos_name( string $name )
    {
        // Elimina los espacios en blanco
        $name = str_replace( ' ', '', trim( $name ) );
        $name = strtolower( $name );
        return $name;
    }

    public function usuario_empresas()
    {
        $data['usuario']        = session('usuario');
        #$data['carreras']      = Carrera::all();
        $data['empresas']       = Empresa::all();
        $data['page_title']     = 'Empresas Registrados';
        $data['usuarios']       = Usuario::all();
        return view('usuario.empresas', $data);
    }

    public function perfil_empresa(Empresa $empresa)
    {
        $data['usuario']    = $empresa->usuario;
        $data['cliente']    = $empresa;
        $data['page_title'] = 'Perfil de Empresa';
        $data['usuarios']   = Usuario::all();
        return view('tablero.perfil_empresa', $data);
    }
}
