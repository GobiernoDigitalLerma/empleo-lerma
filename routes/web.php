<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Pagina principal
use App\DatosEmpresa;
use App\RequisitosVacante;
use App\InformacionContacto;
use App\vacante;
use App\Fecha;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\EmpresaController;
/**
 * Landing
 */
Route::get('/eventos', 'EventoController@eventos')->name('eventos');
Route::any('/guardardatoseventos', 'EventoController@guardardatoseventos')->name('guardardatoseventos');
Route::any('/admineventos', function () { return view('admineventos');});
Route::get('/modificacioneventos', 'EventoController@modificacioneventos')->name('modificacioneventos');
Route::any('/updateeventos/{id}', 'EventoController@updateeventos')->name('updateeventos');
Route::any('eventos/{id}', 'EventoController@deleteeventos')->name('eventos.delete');
Route::get('/descrevento/{id}', 'EventoController@descrevento')->name('descrevento');
Route::get('/notificaciones', 'NotificationController@notificaciones')->name('notificaciones');
Route::get('/index', 'TestController@index')->name('index');
Route::any('/result', 'TestController@result')->name('result');
Route::get('/test', 'TestController@index')->name('test');
Route::any('/guardarTestAptitud', 'TestController@guardarTestAptitud')->name('guardarTestAptitud');
Route::any('/guardarTestPersonalidad', 'TestController@guardarTestPersonalidad')->name('guardarTestPersonalidad');
Route::any('/guardarTestHabilidades', 'TestController@guardarTestHabilidades')->name('guardarTestHabilidades');
Route::any('/guardarTestIntereses', 'TestController@guardarTestIntereses')->name('guardarTestIntereses');
Route::get('/descargarPDF', 'TestController@descargarPDF')->name('descargarPDF');
Route::get('/notificar-empresa/{id}', 'EmpresaController@notificarEmpresa')->name('notificarEmpresa');
Route::delete('/vacante/{id}/eliminar', 'VacantesController@destroy')->name('vacante.eliminar');
Route::patch('/vacantes/{id}/cubrir', 'VacantesController@marcarCubierta')->name('vacante.cubrir');


Route::get('/', function () {
    if(Auth()->guest())
    {
        $empresas = DatosEmpresa::orderBy('id_empresa','DESC')->limit('12')->get();
        $municipios = vacante::select('lugar_vacante')->distinct()->get();
        $vacantes = \DB::SELECT("SELECT * FROM vacantes 
                                INNER JOIN datos_empresas ON vacantes.id_empresa = datos_empresas.id_empresa 
                                INNER JOIN fechas ON vacantes.id_vacante = fechas.id_vacante
                                ORDER BY vacantes.created_at DESC LIMIT 10");
        $requisitos = RequisitosVacante::All();
        $info = InformacionContacto::All();
        $fechas = Fecha::All();
        $no_vacantes = \DB::table('vacantes')->where('is_covered', 0 )->count();
        
        return view('welcome', compact('empresas', 'municipios', 'vacantes','requisitos','info','fechas', 'no_vacantes'));
        //return view('welcome');
    }
    else
    {
        return redirect()->route('home');
    }
});

Route::get('/busco_empleo', function () {
    return view('buscoempleo');
});

Route::get('/ofrezco_empleo', function () {
    return view('ofrezcoempleo');
});

Route::get('/materialapoyo', function () {
    return view('materialapoyo');
});
Route::get('/creatucv', function () {
    return view('creatucv');
});
Route::get('/tipsentrevista', function () {
    return view('tipsentrevista');
});
Route::get('/controlaemociones', function () {
    return view('controlaemociones');
});

//Busqueda
Route::get('/search', 'VacantesController@index')->name('buscar'); 

/**
 * Auth
 */
Auth::routes();
Auth::routes(['verify' => true]);


//home
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/vacantesparati', 'HomeController@vacantesparati')->name('vacantesparati');
Route::get('/getMpios','HomeController@getMpios')->name('getMpios');
Route::get('/micuenta', 'HomeController@micuenta')->name('micuenta');

// Rutas PDF
Route::get('/cvpdf', 'HomeController@exportarpdf')->middleware('auth');
Route::get('/cvuserpdf/{nombre_completo}', 'VacantesController@cvuserpdf')->name('cvuserpdf')->middleware('auth');

// Curriculum
Route::get('/curriculum', 'HomeController@curriculum')->name('curriculum')->middleware('auth');
Route::POST('/guardarcurriculum', 'HomeController@guardarcurriculum')->name('guardarcurriculum')->middleware('auth');
Route::POST('/actualizarcurriculum', 'HomeController@actualizarcurriculum')->name('actualizarcurriculum')->middleware('auth');
Route::POST('/archivocv', 'HomeController@archivocv')->name('archivocv')->middleware('auth');
Route::POST('/archivocvact', 'HomeController@archivocvact')->name('archivocvact')->middleware('auth');

// Ciudadano
Route::POST('/guardardatosc', 'HomeController@guardardatosc')->name('guardardatosc');
Route::POST('/actualizardatosc', 'HomeController@actualizardatosc')->name('actualizardatosc');

// Empresa
Route::any('/guardardatosemp', 'HomeController@guardardatosemp')->name('guardardatosemp');
Route::any('/modificardatosemp', 'HomeController@modificardatosemp')->name('modificardatosemp');
Route::get('/modificarestadoemp', 'HomeController@modificarestadoemp')->name('modificarestadoemp');

// Vacantes
Route::get('vacante/{slug}', 'VacantesController@show')->name('vacante');
Route::any('/guardarvacante', 'VacantesController@create')->name('guardarvacante');
Route::get('vacante/{id}/editar', 'VacantesController@edit')->name('editarvacante');
Route::any('vacante/{id}/actualizar', 'VacantesController@update')->name('actualizarvacante');
Route::get('vacante/{id}/cubierta/{platform_support}', 'VacantesController@covered')->name('vacantecubierta');

// Postulacion
Route::POST('/postulacion', 'VacantesController@postulacion')->name('postulacion');

// Email
Route::get('/email_contacto/{email}', 'VacantesController@contactar')->name('correo');
Route::POST('/contacto','MailController@store')->name('contacto');

// Offline
Route::get('/offline', function () {    
    return view('vendor/laravelpwa/offline');

Route::get('/test-email', function() {
    Mail::raw('Este es un correo de prueba desde Laravel', function($message) {
        $message->to('jafetserrano21@gmail.com')
                ->subject('Prueba de correo');
    });
    
    return "Correo enviado, revisa tu bandeja de entrada";
});

});

