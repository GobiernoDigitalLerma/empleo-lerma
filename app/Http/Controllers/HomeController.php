<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\curriculumusers;
use App\EntidadFed;
use App\EdoCivil;
use App\Municipio;
use App\UltimoGrado;
use App\Motivo;
use App\ExpPuesto;
use App\TipoEmpleo;
use App\DatosCiudadano;
use App\Escolaridad;
use App\PerfilLaboral;
use App\SituacionLaboral;
use App\PuestoDeseado;
use App\idioma;
use App\usercv;
use App\User;
use App\DatosEmpresa;
use App\vacante;
use App\RequisitosVacante;
use App\InformacionContacto;
use App\Fecha;
use App\Notifications\ActiveAccount;
use App\Postulacion;
use App\reciente;
use Barryvdh\DomPDF\Facade as PDF;
use Session;
use DB;
use App\Notifications\NuevaNotificacion;
use App\Notifications\ActualizacionDatos;


class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // Pagina principal cuando se inicia sesión
   public function index()
{
    // ✅ Empresas con vacantes activas, sin duplicados, máximo 12
    $empresas = DatosEmpresa::whereHas('vacantes', function ($query) {
        $query->where('is_covered', 0); // Solo vacantes activas
    })
    ->with(['vacantes' => function ($query) {
        $query->where('is_covered', 0); // Para contar en la vista
    }])
    ->get()
    ->unique('id_empresa') // Asegura que no se repitan
    ->values()
    ->take(12); // Solo las primeras 12

    // Municipios únicos de vacantes
    $municipios = Vacante::select('lugar_vacante')->distinct()->get();

    // Vacantes más recientes (con sus fechas y empresa)
    $vacantes = \DB::select("SELECT * FROM vacantes 
                             INNER JOIN datos_empresas ON vacantes.id_empresa = datos_empresas.id_empresa 
                             INNER JOIN fechas ON vacantes.id_vacante = fechas.id_vacante
                             WHERE vacantes.is_covered = 0
                             ORDER BY vacantes.created_at DESC
                             LIMIT 10");

    // Resto de los datos
    $requisitos   = RequisitosVacante::all();
    $info         = InformacionContacto::all();
    $fechas       = Fecha::all();
    $id           = auth()->id();
    $recientes    = reciente::distinct('slug')
                        ->where('id_usuario', $id)
                        ->orderBy('created_at', 'DESC')
                        ->limit(7)
                        ->get();

    $no_vacantes = \DB::table('vacantes')->where('is_covered', 0)->count();

    return view('home', compact(
        'empresas', 'municipios', 'vacantes',
        'requisitos', 'info', 'fechas', 'recientes', 'no_vacantes'
    ));
}

    public function vacantesparati()
    {
        $empresas   = DatosEmpresa::orderBy('id_empresa','DESC')->limit('12')->get();
        $municipios = vacante::select('lugar_vacante')->distinct()->get();
        $vacantes   = \DB::SELECT("SELECT * FROM vacantes 
                                INNER JOIN datos_empresas ON vacantes.id_empresa = datos_empresas.id_empresa 
                                INNER JOIN fechas ON vacantes.id_vacante = fechas.id_vacante
                                ORDER BY vacantes.created_at DESC LIMIT 10");
        $requisitos = RequisitosVacante::All();
        $info       = InformacionContacto::All();
        $fechas     = Fecha::All();
        $id         = auth()->id();
        $recientes  = reciente::distinct('slug')
                                ->where('id_usuario',$id)
                                ->orderBy('created_at','DESC')
                                ->limit('7')
                                ->get();
        $no_vacantes = \DB::table('vacantes')->where('is_covered', 0 )->count();

        return view('vacantesparati', compact('empresas','municipios','vacantes','requisitos','info','fechas','recientes', 'no_vacantes'));
    }
    
    // Mi cuenta 
    public function micuenta()
    {
        $rol = auth()->user()->tipo_user;
        if($rol == 'user')
        {
            $ents       = EntidadFed::All();
            $edoscivil  = EdoCivil::All();
            $ultimosgr  = UltimoGrado::All();
            $motivos    = Motivo::All();
            $tiposemp   = TipoEmpleo::All();
            $exppuestos = ExpPuesto::All();
            $idioma     = idioma::All();
        
            $id          = auth()->id();
            $datos       = \DB::SELECT("SELECT * FROM DatosCiudadano WHERE id='$id'");
            $escolaridad = \DB::SELECT("SELECT * FROM Escolaridad WHERE id='$id'");
            $perfil      = \DB::SELECT("SELECT * FROM PerfilLaboral WHERE id='$id'");
            $puesto      = \DB::SELECT("SELECT * FROM PuestoDeseado WHERE id='$id'");
            $situacion   = \DB::SELECT("SELECT * FROM SituacionLaboral WHERE id='$id'");
            $usercv      = \DB::SELECT("SELECT * FROM usercv WHERE id='$id'");
            $curriculum  = \DB::SELECT("SELECT * FROM curriculumusers WHERE id='$id' ORDER BY id_curriculum DESC LIMIT 1");
            

            if(empty($datos) && empty($escolaridad)){
                $municipios = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='Aguascalientes'");
                return view('micuentausernew',[
                    'ents'      => $ents,
                    'edoscivil' => $edoscivil,
                    'ultimosgr' => $ultimosgr,
                    'motivos'   => $motivos,
                    'tiposemp'  => $tiposemp,
                    'exppuestos'=> $exppuestos,
                    'idioma'    => $idioma])
                ->with('curriculum',$curriculum)
                ->with('municipios',$municipios)
                ->with('datos', $datos);
            }
            else
            {
                if(empty($datos) && $escolaridad)
                {
                    $municipios = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='Aguascalientes'");

                    return view('micuentausercv',[
                        'ents'      => $ents,
                        'edoscivil' => $edoscivil,
                        'ultimosgr' => $ultimosgr,
                        'motivos'   => $motivos,
                        'tiposemp'  => $tiposemp,
                        'exppuestos'=> $exppuestos,
                        'idioma'    => $idioma])
                    ->with('curriculum',$curriculum)
                    ->with('datos', $datos)
                    ->with('municipios',$municipios)
                    ->with('escolaridad', $escolaridad)
                    ->with('perfil', $perfil)
                    ->with('puesto', $puesto)
                    ->with('usercv', $usercv)
                    ->with('situacion', $situacion);
                }
                else
                {
                    if(empty($escolaridad) && $datos)
                    {  
                        $entidad = DatosCiudadano::where('id',$id)->first();
                        $entmun = $entidad->EntFed;
                        $municipios = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='$entmun'");

                        return view('micuentauserdatos',[
                            'ents'      => $ents,
                            'edoscivil' => $edoscivil,
                            'ultimosgr' => $ultimosgr,
                            'motivos'   => $motivos,
                            'tiposemp'  => $tiposemp,
                            'exppuestos'=> $exppuestos,
                            'idioma'    => $idioma])
                        ->with('curriculum',$curriculum)
                        ->with('datos', $datos)
                        ->with('municipios',$municipios)
                        ->with('escolaridad', $escolaridad)
                        ->with('perfil', $perfil)
                        ->with('puesto', $puesto)
                        ->with('situacion', $situacion);
                    }
                    else
                    {

                        $entidad = DatosCiudadano::where('id',$id)->first();
                        $entmun = $entidad->EntFed;
                        $municipios = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='$entmun'");

                        $postulaciones = \DB::SELECT("SELECT * FROM postulaciones 
                                        INNER JOIN vacantes ON postulaciones.id_vacante = vacantes.id_vacante
                                        INNER JOIN datos_empresas ON postulaciones.id_empresa = datos_empresas.id_empresa 
                                        INNER JOIN fechas ON vacantes.id_vacante = fechas.id_vacante
                                        WHERE postulaciones.id_usuario = '$id' ORDER BY postulaciones.created_at DESC LIMIT 2");
                        $postulacions = Postulacion::where('postulaciones.id_usuario',$id)
                                        ->join('vacantes', 'postulaciones.id_vacante','=','vacantes.id_vacante')
                                        ->join('datos_empresas','postulaciones.id_empresa', '=', 'datos_empresas.id_empresa')
                                        ->join('fechas', 'fechas.id_vacante', '=', 'vacantes.id_vacante')
                                        ->orderBy('postulaciones.created_at','DESC')
                                        ->paginate(6)
                                        ->appends(request()->query());
                        return view('micuentauser',[
                            'ents'      => $ents,
                            'edoscivil' => $edoscivil,
                            'ultimosgr' => $ultimosgr,
                            'motivos'   => $motivos,
                            'tiposemp'  => $tiposemp,
                            'exppuestos'=> $exppuestos,
                            'idioma'    => $idioma])
                        ->with('curriculum',$curriculum)
                        ->with('datos', $datos)
                        ->with('municipios',$municipios)
                        ->with('escolaridad', $escolaridad)
                        ->with('perfil', $perfil)
                        ->with('usercv', $usercv)
                        ->with('puesto', $puesto)
                        ->with('situacion', $situacion)
                        ->with('postulaciones',$postulaciones)
                        ->with('postulacions',$postulacions);
                    }
                }
            }
        }
        else
        {
            if($rol == 'company')
            {
                $id       = auth()->id();
                $empresa  = DatosEmpresa::where('id',$id)->first();
                if(empty($empresa))
                {
                    $ents       = EntidadFed::All();
                    $municipios = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='Aguascalientes'");
                    $tiposemp   = TipoEmpleo::All();
                    $munvacante = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='México'");
                    $exppuestos = ExpPuesto::All();
                    return view('micuentacompany',compact('empresa'))
                                ->with('ents', $ents)
                                ->with('tiposemp', $tiposemp)
                                ->with('munvacante',$munvacante)
                                ->with('exppuestos', $exppuestos)
                                ->with('municipios',$municipios);
                }
                else
                {
                    $ide      = $empresa->id_empresa;
                    $contadorp = vacante::where('id_empresa',$ide)->count();
                    $contadorc = Postulacion::where('id_empresa',$ide)->count();
                    $vacantes = vacante::orderBy('vacantes.id_vacante', 'DESC')
                                ->join('datos_empresas', 'datos_empresas.id_empresa', '=', 'vacantes.id_empresa')
                                ->join('fechas', 'fechas.id_vacante', '=', 'vacantes.id_vacante')
                                ->where('vacantes.id_empresa',$ide)
                                ->where('vacantes.is_covered',0)
                                ->paginate(4)
                                ->appends(request()->query());
                    $exppuestos = ExpPuesto::All();
                    $ents       = EntidadFed::All();
                    $tiposemp   = TipoEmpleo::All();
                    $entmun = $empresa->estado;
                    $municipios = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='$entmun'");
                    $munvacante = \DB::SELECT("SELECT * FROM Municipio WHERE EntFed='México'");
                    $postulantes = \DB::SELECT("SELECT * FROM postulaciones 
                                    INNER JOIN vacantes ON postulaciones.id_vacante = vacantes.id_vacante
                                    INNER JOIN DatosCiudadano ON postulaciones.id_persona = DatosCiudadano.id_persona
                                    INNER JOIN users ON postulaciones.id_usuario = users.id
                                    WHERE postulaciones.id_empresa = '$ide' ORDER BY postulaciones.created_at DESC LIMIT 2");
                    $postulants = Postulacion::orderBy('postulaciones.created_at','DESC')
                                    ->join('vacantes', 'postulaciones.id_vacante','=','vacantes.id_vacante')
                                    ->join('DatosCiudadano','postulaciones.id_persona', '=', 'DatosCiudadano.id_persona')
                                    ->join('users','postulaciones.id_usuario','=','users.id')
                                    ->where('postulaciones.id_empresa',$ide)
                                    ->paginate(6)
                                    ->appends(request()->query());

                    return view('micuentacompany',compact('contadorp','contadorc','empresa','vacantes'))
                                ->with('exppuestos', $exppuestos)
                                ->with('ents', $ents)
                                ->with('municipios',$municipios)
                                ->with('munvacante',$munvacante)
                                ->with('tiposemp', $tiposemp)
                                ->with('postulantes', $postulantes)
                                ->with('postulants', $postulants);    
                }
            }
            else
            {
                if($rol == 'admin')
                {   
                    $contciudadanos  = User::where('tipo_user','user')->count();
                    $contpostulados  = Postulacion::distinct('id_usuario')->count('id_usuario');
                    $contvacantes    = vacante::count();
                    $contvacactivas  = vacante::count();
                    $contempactivas  = DatosEmpresa::count();
                    $datosciudadanos = DatosCiudadano::select('DatosCiudadano.nombre_completo','DatosCiudadano.telefono','users.email','DatosCiudadano.id_persona')
                                        ->join('users', 'DatosCiudadano.id','=','users.id')
                                        ->paginate(15)
                                        ->appends(request()->query());
                    $datosempresas   = DatosEmpresa::paginate(15)
                                        ->appends(request()->query());
                    $vacantes        = vacante::orderBy('vacantes.id_vacante','asc')
                                        ->join('datos_empresas','datos_empresas.id_empresa','=','vacantes.id_empresa')
                                        ->paginate(15)
                                        ->appends(request()->query());

                    return view('micuentaadmin',compact('contciudadanos',
                                                        'contpostulados',
                                                        'contvacantes',
                                                        'contvacactivas',
                                                        'contempactivas'))
                                ->with('datosciudadanos',$datosciudadanos)
                                ->with('datosempresas',$datosempresas)
                                ->with('vacantes',$vacantes);
                }
            }
        }
    }

    // Municipios para combobox dinamico
    public function getMpios(Request $req)
    {
        $id    = $req->EntFed;
        $mpios = Municipio::where('EntFed',$id)->select('IdMunicipio','Municipio')->get();
             return Response()->json($mpios->toJson());
    }

    // Guarda los datos del usuario ciudadano
    public function guardardatosc(Request $req)
    {
        $id   = auth()->id();
        $file = $req->file('photoUser');

        if ($req->hasFile('foto_perfil')) {
            $file = $req->file('foto_perfil');
            $nombreImagen = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('archivo'), $nombreImagen);
        } else {
            $nombreImagen = "sinfoto.png"; 
        }
        $datoc = new DatosCiudadano;
        $datoc -> nombre_completo   = $req -> userName;
        $datoc -> telefono          = $req -> phoneUser;
        $datoc -> fecha_nacimiento  = $req -> dateUser;
        $datoc -> genero            = $req -> genereUser;
        $datoc -> edo_civil         = $req -> edocivil;
        $datoc -> lugar_nacimiento  = $req -> entidadnac;
        $datoc -> EntFed            = $req -> entfed;
        $datoc -> municipio         = $req -> municipio;
        $datoc -> calle             = $req -> calle;
        $datoc -> numero            = $req -> num;
        $datoc -> colonia           = $req -> colonia;
        $datoc -> CP                = $req -> codpost;
        $datoc -> discapacidad      = $req -> discap;
        $datoc -> curp              = $req -> curp;
        $datoc -> ComSeEnt          = $req -> comoentero;
        $datoc -> foto_perfil       = $nombreImagen;
        $datoc -> id                = $id;
        $datoc -> save();
        
        $userName= $req -> userName;
        $userPhone= $req -> phoneUser;
        \DB::UPDATE("UPDATE users SET nombre='$userName', telefono='$userPhone' WHERE id='$id'");

        echo '<script language="javascript">alert("Datos guardado correctamente");</script>';
        return redirect()->route('micuenta');
    }

    // Actualiza los datos del usuario ciudadano
    public function actualizardatosc(Request $req)
    {
        $id = auth()->id();
        $file = $req->file('photoUser');
        if($file!="")
        {
            $ldate = date('Ymd_His_');
            $img   = $file->getClientOriginalName();
            $img2  = $ldate.$img;
            \Storage::disk('local')->put($img2, \File::get($file));
        }
        else
        {
            $img2 = $req->actual;      
        }

        $nombre_completo   = $req -> userName;
        $telefono          = $req -> phoneUser;
        $fecha_nacimiento  = $req -> dateUser;
        $genero            = $req -> genereUser;
        $edo_civil         = $req -> edocivil;
        $lugar_nacimiento  = $req -> entidadnac;
        $EntFed            = $req -> entfed;
        $municipio         = $req -> municipio;
        $calle             = $req -> calle;
        $numero            = $req -> num;
        $colonia           = $req -> colonia;
        $CP                = $req -> codpost;
        $discapacidad      = $req -> discap;
        $curp              = $req -> curp;
        $ComSeEnt          = $req -> comoentero;
        $foto_perfil       = $img2;

        \DB::UPDATE("UPDATE users SET nombre='$nombre_completo', telefono='$telefono' WHERE id='$id'");
        \DB::UPDATE("UPDATE DatosCiudadano SET 
                    nombre_completo='$nombre_completo',
                    telefono='$telefono',
                    fecha_nacimiento='$fecha_nacimiento',
                    genero='$genero',
                    edo_civil='$edo_civil',
                    lugar_nacimiento='$lugar_nacimiento',
                    EntFed='$EntFed',
                    municipio='$municipio',
                    calle='$calle',
                    numero='$numero',
                    colonia='$colonia',
                    CP='$CP',
                    discapacidad='$discapacidad',
                    curp='$curp',
                    ComSeEnt='$ComSeEnt',
                    foto_perfil='$img2'
                    WHERE id='$id'");

        return redirect()->route('micuenta');
    }

    // Guarda los datos de curriculum del usuario ciudadano
    public function guardarcurriculum(Request $req)
    {
        $id = auth()->id();
        $escolaridad = new Escolaridad;
        $escolaridad -> grado_estudios       = $req -> ultimogrado;
        $escolaridad -> carrera_especialidad = $req -> carrera;
        $escolaridad -> situacion_academica  = $req -> situacionacad;
        $escolaridad -> idioma               = $req -> idioma;
        $escolaridad -> dominio              = $req -> domidio;
        $escolaridad -> conocimientos_esp    = $req -> conhabc;
        $escolaridad -> habilidades_esp      = $req -> conhabh;
        $escolaridad -> cursos               = $req -> cursos;
        $escolaridad -> id                   = $id;
        $escolaridad -> save();

        $sitlab = new SituacionLaboral;
        $sitlab -> trabajo_actual       = $req -> trabajaact;
        $sitlab -> motivo               = $req -> motivo;
        $sitlab -> fecha_busquedaempleo = $req -> fechacombus;
        $sitlab -> disponibilidad       = $req -> disponibilidad;
        $sitlab -> id                   = $id;
        $sitlab -> save();

        $perflab = new PerfilLaboral;
        $perflab -> nombre_RS             = $req -> nombrerazsoc;
        $perflab -> titulo_puesto         = $req -> puestoocu;
        $perflab -> funciones_actividades = $req -> funcrealiz;
        $perflab -> salario_mensual       = $req -> salario;
        $perflab -> tipo_empleo           = $req -> tipoempleo;
        $perflab -> fecha_ingreso         = $req -> fechaingr;
        $perflab -> fecha_separacion      = $req -> fechasep; 
        $perflab -> id                    = $id;
        $perflab -> save();

        $puestodes = new PuestoDeseado;
        $puestodes -> puesto_deseado      = $req -> puestodeseado;
        $puestodes -> ocupacion           = $req -> ocupacion;
        $puestodes -> experiencia_puesto  = $req -> exppuesto;
        $puestodes -> tipo_empleo         = $req -> tipoempleo;
        $puestodes -> salario_mensual     = $req -> salariopre;
        $puestodes -> dispo_viajar        = $req -> dispviajar;
        $puestodes -> dispo_radicar_fuera = $req -> dispcamres; 
        $puestodes -> id                  = $id;
        $puestodes -> save();

        echo '<script language="javascript">alert("Curriculum guardado correctamente");</script>';
        return redirect()->route('micuenta');
    }

    // Actualiza los datos de curriculum del usuario ciudadano
    public function actualizarcurriculum(Request $req)
    {
        $id = auth()->id();

        $grado_estudios       = $req -> ultimogrado;
        $carrera_especialidad = $req -> carrera;
        $situacion_academica  = $req -> situacionacad;
        $idioma               = $req -> idioma;
        $dominio              = $req -> domidio;
        $conocimientos_esp    = $req -> conhabc;
        $habilidades_esp      = $req -> conhabh;
        $cursos               = $req -> cursos;

        $trabajo_actual       = $req -> trabajaact;
        $motivo               = $req -> motivo;
        $fecha_busquedaempleo = $req -> fechacombus;
        $disponibilidad       = $req -> disponibilidad;

        $nombre_RS             = $req -> nombrerazsoc;
        $titulo_puesto         = $req -> puestoocu;
        $funciones_actividades = $req -> funcrealiz;
        $salario_mensual       = $req -> salario;
        $tipo_empleo           = $req -> tipoempleo;
        $fecha_ingreso         = $req -> fechaingr;
        $fecha_separacion      = $req -> fechasep; 

        $puesto_deseado      = $req -> puestodeseado;
        $ocupacion           = $req -> ocupacion;
        $experiencia_puesto  = $req -> exppuesto;
        $tipo_empleo1        = $req -> tipoempleo;
        $salario_mensual     = $req -> salariopre;
        $dispo_viajar        = $req -> dispviajar;
        $dispo_radicar_fuera = $req -> dispcamres; 

        \DB::UPDATE("UPDATE Escolaridad SET
                    grado_estudios='$grado_estudios',
                    carrera_especialidad='$carrera_especialidad',
                    situacion_academica='$situacion_academica',
                    idioma='$idioma',
                    dominio='$dominio',
                    conocimientos_esp='$conocimientos_esp',
                    habilidades_esp='$habilidades_esp',
                    cursos='$cursos'
                    WHERE id='$id'");

        \DB::UPDATE("UPDATE SituacionLaboral SET
                    trabajo_actual='$trabajo_actual',
                    motivo='$motivo',
                    fecha_busquedaempleo='$fecha_busquedaempleo',
                    disponibilidad='$disponibilidad'
                    WHERE id='$id'");

        \DB::UPDATE("UPDATE PerfilLaboral SET
                    nombre_RS='$nombre_RS',
                    titulo_puesto='$titulo_puesto',
                    funciones_actividades='$funciones_actividades',
                    salario_mensual='$salario_mensual',
                    tipo_empleo='$tipo_empleo',
                    fecha_ingreso='$fecha_ingreso',
                    fecha_separacion='$fecha_separacion'
                    WHERE id='$id'");

        \DB::UPDATE("UPDATE PuestoDeseado SET
                    puesto_deseado='$puesto_deseado',
                    ocupacion='$ocupacion',
                    experiencia_puesto='$experiencia_puesto',
                    tipo_empleo='$tipo_empleo1',
                    salario_mensual='$salario_mensual',
                    dispo_viajar='$dispo_viajar',
                    dispo_radicar_fuera='$dispo_radicar_fuera'
                    WHERE id='$id'");

        return redirect()->route('micuenta');
    }

    // Datos del Curriculum de usuario ciudadano. Versión 1.0
    public function curriculum(Request $request)
    {
        $id = auth()->id();
        $curriculum = new curriculumusers;
        $curriculum -> objetivo_prof            = $request -> objUser;
        $curriculum -> experiencia_prof         = $request -> expUser;
        $curriculum -> area_especialidad        = $request -> specUser;
        $curriculum -> habilidades              = $request -> skillsUser;
        $curriculum -> educacion                = $request -> educationUser;
        $curriculum -> idiomas                  = $request -> langUser;
        $curriculum -> cursos_y_certificaciones = $request -> certsUser;
        $curriculum -> id                       = $id;
        $curriculum -> save();
        echo '<script language="javascript">alert("Curriculum guardado correctamente");</script>';
        return redirect()->route('micuenta');
    }

    // Crea el PDF del curriculum del usuario ciudadano automaticamente    
    public function exportarpdf() 
    {
        $id          = auth()->id();
        $datos       = \DB::SELECT("SELECT * FROM DatosCiudadano WHERE id='$id'");
        $escolaridad = \DB::SELECT("SELECT * FROM Escolaridad WHERE id='$id'");
        $perfil      = \DB::SELECT("SELECT * FROM PerfilLaboral WHERE id='$id'");
        $puesto      = \DB::SELECT("SELECT * FROM PuestoDeseado WHERE id='$id'");
        $situacion   = \DB::SELECT("SELECT * FROM SituacionLaboral WHere id='$id'");
        $cv          = \DB::SELECT("SELECT * FROM curriculumusers WHERE id='$id' ORDER BY id_curriculum DESC LIMIT 1");
        $pdf         = PDF::loadview('cv.pdf', compact('cv'),[
                        'datos'       => $datos,
                        'escolaridad' => $escolaridad,
                        'perfil'      => $perfil,
                        'puesto'      => $puesto,
                        'situación'   => $situacion]);  
        return $pdf->stream('cv.pdf');
        //return $pdf->download('CV.pdf'); 
    }

    // Sube el archivo de curriculum personalizado del usuario ciudadano
    public function archivocv(Request $req)
    {
        $id = auth()->id();
        $file = $req->file('userCV');

        if($file!="")
        {
            $ldate = date('Ymd_His_');
            $cv    = $file->getClientOriginalName();
            $cv2   = $ldate.$cv;
            \Storage::disk('local')->put($cv2, \File::get($file));
        }
        else
        {
            $cv2 = "sincv";      
        }

        $usercv = new usercv;
        $usercv -> nombre_cv = $cv2;
        $usercv -> id = $id;
        $usercv -> save();

        echo '<script language="javascript">alert("Curriculum guardado correctamente");</script>';
        return redirect()->route('micuenta');
    }

    // Actualiza el curriculum personalizado del usuario ciudadano
    public function archivocvact(Request $req)
    {
        $id = auth()->id();
        $file = $req->file('userCV');

        if($file!="")
        {
            $ldate = date('Ymd_His_');
            $cv    = $file->getClientOriginalName();
            $cv2   = $ldate.$cv;
            \Storage::disk('local')->put($cv2, \File::get($file));
        }
        else
        {
            $cv2 = "sincv";      
        }

        $nombre_cv = $cv2;

        \DB::UPDATE("UPDATE usercv SET nombre_cv='$nombre_cv' WHERE id='$id'");

        echo '<script language="javascript">alert("Curriculum actualizado correctamente");</script>';
        return redirect()->route('micuenta');
    }
    //Guarda los datos de empresa
    
    public function guardardatosemp(Request $req)
    {
        $id   = auth()->id();
        $file = $req->file('photoCompany');
    
        if ($file != "") {
            $ldate = date('Ymd_His_');
            $img   = $file->getClientOriginalName();
            $img2  = $ldate . $img;
            \Storage::disk('local')->put($img2, \File::get($file));
        } else {
            $img2 = "sinfoto.png";
        }
    
        $emp = new DatosEmpresa;
        $emp->nombre_RS           = $req->companyName;
        $emp->calle               = $req->calleCompany;
        $emp->numero              = $req->numeroCompany;
        $emp->colonia             = $req->coloniaCompany;
        $emp->CP                  = $req->cpCompany;
        $emp->municipio           = $req->municipio;
        $emp->estado              = $req->entfed;
        $emp->RFC                 = $req->CompanyRFC;
        $emp->tel1                = $req->phoneUser1;
        $emp->tel2                = $req->phoneUser2;
        $emp->email               = $req->emailCompany;
        $emp->pagina_electronica  = $req->pagElectronica;
        $emp->actividad_economica = $req->acteco;
        $emp->numero_empleados    = $req->numemple;
        $emp->ComoSeEnt           = $req->ComoSeEnt;
        $emp->foto_perfil         = $img2;
        $emp->id                  = $id;
        $emp->save();
    
        
    \DB::UPDATE("UPDATE users SET nombre='$emp->nombre_RS', telefono='$emp->tel1', email='$emp->email' WHERE id='$id'");
    
    $correoDestino = "empleo.lerma@gmail.com";

    Notification::route('mail', $correoDestino)->notify(new NuevaNotificacion($emp, $correoDestino));

    return redirect()->route('micuenta');
    }
    

    public function modificarestadoemp(Request $req){
        
        $empresa = DatosEmpresa::where('id_empresa', $req->emp_id)->first();
        //change status
        if($empresa->is_active){
            $empresa->is_active = 0;
        }else{
            $empresa->is_active = 1;
        }
        $empresa->save();
        //send notification to company
        if($empresa->is_active){
            $user = User::find($empresa->id);
            Notification::send($user, new ActiveAccount($empresa));
        }
        return response()->json(['success'=>'Se ha modificado satisfactoriamente', 
                                 'name'=>$empresa->nombre_RS,
                                 'is_active'=>$empresa->is_active]);
    }

    //Modifica los datos de empresa
    
    public function modificardatosemp(Request $req)
    {
        $id = auth()->id();
        if (!$id) {
            return redirect()->route('micuenta')->with('error', 'Usuario no autenticado');
        }
    
        $empresa = DatosEmpresa::where('id', $id)->first();
        if (!$empresa) {
            return redirect()->route('micuenta')->with('error', 'No se encontró la empresa');
        }
    
        if ($req->hasFile('photoCompany')) {
            $ldate = date('Ymd_His_');
            $img   = $req->file('photoCompany')->getClientOriginalName();
            $img2  = $ldate . $img;
            \Storage::disk('local')->put($img2, \File::get($req->file('photoCompany')));
            $empresa->foto_perfil = $img2;
        }
    
        $empresa->nombre_RS           = $req->companyName;
        $empresa->calle               = $req->calleCompany;
        $empresa->numero              = $req->numeroCompany;
        $empresa->colonia             = $req->coloniaCompany;
        $empresa->CP                  = $req->cpCompany;
        $empresa->municipio           = $req->municipio;
        $empresa->estado              = $req->entfed;
        $empresa->RFC                 = $req->CompanyRFC;
        $empresa->tel1                = $req->phoneUser1;
        $empresa->tel2                = $req->phoneUser2;
        $empresa->email               = $req->emailCompany;
        $empresa->pagina_electronica  = $req->pagElectronica;
        $empresa->actividad_economica = $req->acteco;
        $empresa->numero_empleados    = $req->numemple;
        $empresa->ComoSeEnt           = $req->ComoSeEnt;
        $empresa->save();
    
        User::where('id', $id)->update([
            'nombre'  => $req->companyName,
            'telefono' => $req->phoneUser1,
            'email'   => $req->emailCompany
        ]);
    
        Notification::route('mail', 'yoseclzad18@gmail.com')->notify(new ActualizacionDatos($empresa, 'yoseclzad18@gmail.com'));
    
        return redirect()->route('micuenta')->with('success', 'Datos actualizados correctamente');
    }

    public function enviarNotificaciones()
    {
        $empresas = Empresa::all(); 

        foreach ($empresas as $empresa) {
            $empresa->notify(new ActiveAccount());
        }

        return response()->json(['message' => 'Notificaciones enviadas correctamente.']);
    }

}
//