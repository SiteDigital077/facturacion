<?php

Route::group(['middleware' => ['auths','administrador']], function () {
    //

Route::get('gestion/factura', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@index');
Route::get('gestion/factura/editar-empresa', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editarempresa');
Route::get('gestion/factura/crear-producto', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@createproducto');
Route::post('gestion/factura/actualizar-empresa', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@update');
Route::get('gestion/factura/factura-cliente/juridico', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@juridico');
Route::post('gestion/factura/crear-cliente', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@create');
Route::get('gestion/factura/editar-cliente/juridica/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editarclientejuridica');
Route::get('gestion/factura/editar-cliente/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editarcliente');
Route::post('gestion/factura/actualizar-cliente/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@actualizar');
Route::get('gestion/factura/lista-facturas/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@facturaempresa');
Route::post('gestion/factura/crear-factura', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@createfactura');
Route::get('gestion/factura/editar-factura/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editarfactura');
Route::post('gestion/factura/actualizar-factura/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@updatefactura');
Route::get('gestion/factura/generar-factura/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@pdf');
Route::get('gestion/factura/generar-facturacopia/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@pdfcopia');
Route::post('gestion/factura/creargasto', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@creargasto');

Route::resource('gestion/factura/generar-producto', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@facturaproducto');
Route::post('gestion/factura/creacion-producto', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@creatproducto');

Route::get('gestion/factura/eliminar-producto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@eliminarproducto');
Route::get('gestion/factura/editar-producto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editarproducto');
Route::post('gestion/factura/actualizar-producto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@actualizarproducto');
Route::get('gestion/factura/factura-cliente', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@crearcliente');
Route::get('gestion/factura/control-gastos', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@gastos');
Route::get('gestion/factura/crear-gasto', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@creargastos');
Route::get('gestion/factura/crear-concepto', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@crearconcepto');
Route::post('gestion/factura/ingresarconcepto', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@ingresarconcepto');
Route::get('gestion/factura/eliminar-concepto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@eliminarconcepto');
Route::get('gestion/factura/editar-concepto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editarconcepto');
Route::post('gestion/factura/updateconcepto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@updateconcepto');

Route::resource('gestion/factura/actualizarinput', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@actualizarinput');


Route::get('gestion/factura/eliminar-cliente/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@eliminarcliente');
Route::get('gestion/factura/eliminar-almacen/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@eliminaralmacen');
Route::get('gestion/factura/editar-almacen/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editaralmacen');
Route::get('gestion/factura/crear-facturacion/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@crearfactura');
Route::get('gestion/factura/eliminar-gasto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@eliminargasto');
Route::get('gestion/factura/editar-gasto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@editargasto');
Route::post('gestion/factura/actualizargasto/{id}', 'DigitalsiteSaaS\Facturacion\Http\FacturacionController@actualizargasto');

Route::get('gestion/factura/informe', function()
{
	$clientes = DB::table('clientes')->get();
 return View::make('facturacion::informe', compact('clientes'));
});

Route::get('informe/cliente/{id}', function($id) {

   $users = DB::table('facturas')
      ->join('productos', 'facturas.ids', '=', 'productos.factura_id')
      ->where('productos.cliente', '=', $id)->get();
   $total = DB::table('productos')->where('cliente', '=', $id)->sum('v_total');
   $iva = DB::table('productos')->where('cliente', '=', $id)->sum('costoiva');
   $retefuente = DB::table('productos')->where('cliente', '=', $id)->sum('rtefte');
   $ica = DB::table('productos')->where('cliente', '=', $id)->sum('rteica');
   $prefijo = DB::table('empresas')->where('id', 1)->get();


	$pdf = PDF::loadView('vista', compact('users', 'total', 'iva','retefuente', 'ica', 'prefijo'));
	return $pdf->stream();
});


Route::post('informe/general', function(){
       
       $min_price = Input::has('min_price') ? Input::get('min_price') : 0;
       $max_price = Input::has('max_price') ? Input::get('max_price') : 10000000;
       $clientes =  Input::get('cliente') ;
       $estados =  Input::get('estado') ;
   
       $users = DB::table('clientes')
         ->join('facturas', 'clientes.id', '=', 'facturas.cliente_id')
         ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
         ->get();

         $unitarios =  $productos = DB::table('productos')
        ->join('facturas', 'productos.factura_id', '=', 'facturas.id')
        ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
          ->selectRaw('sum(v_total) as sum')
          ->selectRaw('sum(masiva) as sumiva')
          ->selectRaw('sum(rtefte) as rtefte')
          ->selectRaw('sum(rteica) as rteica')
          ->selectRaw('factura_id as mus')
          ->groupBy('factura_id')
          ->get();


         $total = DB::table('productos')
         ->join('facturas', 'productos.factura_id', '=', 'facturas.id')
         ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
         
         ->sum('v_total');

          $iva = DB::table('productos')
         ->join('facturas', 'productos.factura_id', '=', 'facturas.id')
         ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
         
         ->sum('costoiva');

         $fuente = DB::table('productos')
         ->join('facturas', 'productos.factura_id', '=', 'facturas.id')
         ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
         
         ->sum('rtefte');

         $ica = DB::table('productos')
         ->join('facturas', 'productos.factura_id', '=', 'facturas.id')
         ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
         ->sum('rteica');

         $productos = DB::table('productos')
        ->join('facturas', 'productos.factura_id', '=', 'facturas.id')
        ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
          ->selectRaw('sum(v_total) as sum')
          ->selectRaw('sum(masiva) as masiva')
          ->selectRaw('sum(rtefte) as rtefte')
          ->selectRaw('sum(rteica) as rteica')
          ->selectRaw('cliente_id as mus')
          ->groupBy('cliente_id')
          ->get();

          $empresa = DB::table('empresas')->where('id', 1)->get();

            $conteo = DB::table('clientes')
        ->join('facturas', 'clientes.id', '=', 'facturas.cliente_id')
        ->whereBetween('f_emision', array($min_price, $max_price))
         ->where('cliente_id', 'like', '%' . $clientes . '%')
         ->where('estadof', 'like', '%' . $estados . '%')
          ->selectRaw('count(cliente_id) as sum')
          ->selectRaw('cliente_id as mus')
          ->groupBy('cliente_id')
          ->get();

          $facturas = DB::table('facturas')->count();
          $cuentas = DB::table('productos')
          ->get();

          $prefijo = DigitalsiteSaaS\Facturacion\Empresa::find(1);

        $clientes = DB::table('clientes')->get();

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        
      $pdf = PDF::loadView('facturacion::informefac', compact('users', 'clientes', 'total', 'empresa', 'iva', 'fuente', 'ica', 'productos', 'facturas', 'conteo', 'prefijo', 'min_price', 'max_price', 'unitarios'));
        $pdf->setPaper('A4', 'landscape');
      return  $pdf->stream();
});


Route::get('informe/generar-informe', function(){
      $clientes = DB::table('clientes')->get();
      return View::make('facturacion::filtro')->with('clientes', $clientes);
});



Route::get('informe/generar-informacion', function(){
  
      return View::make('facturacion::filtroinfo');
});



  Route::post('/productos/create', function(App\Http\Requests\AlmacenCreateRequest $Request){

$category = DigitalsiteSaaS\Facturacion\Category::create([
	'producto' => Input::get('producto'),
  'identificador' => Input::get('identificador')

	]);


$subcategory = new DigitalsiteSaaS\Facturacion\Subcategory([
	'iva' => Input::get('iva'),
	'identificador' => Input::get('identificador'),
	'precio' => Input::get('precio'),
	'producto' => Input::get('producto'),



	]);
$category->subcategories()->save($subcategory);

return Redirect('gestion/factura/crear-producto')->with('status', 'ok_create');

	});





  Route::post('/productos/update/{id}', function($id, App\Http\Requests\AlmacenUpdateRequest $request){


DB::table('categories')
            ->where('id', $id)
            ->update(array('producto' => Input::get('producto'),'identificador' => Input::get('identificador')));

DB::table('subcategories')
            ->where('category_id', $id)
            ->update(array('iva' => Input::get('iva'),'identificador' => Input::get('identificador'),'precio' => Input::get('precio'),'producto' => Input::get('producto')));





return Redirect('gestion/factura/crear-producto')->with('status', 'ok_create');

	});


Route::get('darioma/pdf', function() {
	$pdf = PDF::loadView('vista');
	return $pdf->stream();;
}

	);


 Route::get('Facturacione/{id}/ajax-subcat', function($id){

	$cat_id = Input::get('cat_id');

	$subcategories = DigitalsiteSaaS\Facturacion\Subcategory::where('category_id', '=', $cat_id)->get();

	return Response::json($subcategories);
});

Route::get('indexa', function(){

return View::make('indexa');
});



 Route::get('Facturacione/{id}',function($id)
{
$facturacion = DigitalsiteSaaS\Facturacion\Factura::find($id)->Productos;
		$contenido = DigitalsiteSaaS\Facturacion\Factura::find($id);
		$categories = DigitalsiteSaaS\Facturacion\Category::all();
		$product = DigitalsiteSaaS\Facturacion\Almacen::Orderby('id', 'desc')->take(10)->pluck('producto','id');
		$retefuente = DB::table('facturas')->join('clientes','clientes.id','=','facturas.cliente_id')->where('facturas.id', '=', $id)->get();
	    return View::make('facturacion::crear_producto')->with('retefuente', $retefuente)->with('facturacion', $facturacion)->with('contenido', $contenido)->with('product', $product)->with('categories', $categories);
});



 Route::post('informe/generalgasto', function(){
       
        $min_price = Input::has('min_price') ? Input::get('min_price') : 0;
       $max_price = Input::has('max_price') ? Input::get('max_price') : 10000;

       $unitarios  = DB::table('gastos')
          ->whereBetween('fecha', array($min_price, $max_price))
          ->selectRaw('sum(valor) as valor')
          ->selectRaw('sum(valornogra) as valornogra')
          ->selectRaw('sum(iva) as iva')
          ->selectRaw('sum(impuesto) as impuesto')
          ->selectRaw('sum(valorfac) as valorfac')
          ->selectRaw('sum(retefuente) as retefuente')
          ->selectRaw('sum(reteica) as reteica')
          ->selectRaw('sum(descuento) as descuento')
          ->selectRaw('sum(totaldes) as totaldes')
          ->selectRaw('sum(neto) as neto')
          ->get();

         $gastos = DB::table('gastos')
          ->whereBetween('fecha', array($min_price, $max_price))
          ->orderBy('mes')
          ->get();

         $prefijo = DigitalsiteSaaS\Facturacion\Empresa::find(1);

           $resultados =  DB::table('gastos')
          ->whereBetween('fecha', array($min_price, $max_price))
          ->selectRaw('mes')
          ->selectRaw('sum(neto) as valor')
          ->groupBy('mes')
          ->get();

      
        
      return View::make('facturacion::informegastosweb', compact('clientes','unitarios','gastos','prefijo','resultados'));
});


 Route::get('informe/prueba', function(){


        $min_price = Input::has('min_price') ? Input::get('min_price') : 0;
       $max_price = Input::has('max_price') ? Input::get('max_price') : 10000;

       $unitarios  = DB::table('gastos')
          ->whereBetween('fecha', array($min_price, $max_price))
          ->selectRaw('sum(valor) as valor')
          ->selectRaw('sum(valornogra) as valornogra')
          ->selectRaw('sum(iva) as iva')
          ->selectRaw('sum(impuesto) as impuesto')
          ->selectRaw('sum(valorfac) as valorfac')
          ->selectRaw('sum(retefuente) as retefuente')
          ->selectRaw('sum(reteica) as reteica')
          ->selectRaw('sum(descuento) as descuento')
          ->selectRaw('sum(totaldes) as totaldes')
          ->selectRaw('sum(neto) as neto')
          ->get();

         $gastos = DB::table('gastos')
          ->whereBetween('fecha', array($min_price, $max_price))
          ->orderBy('mes')
          ->get();

         $prefijo = DigitalsiteSaaS\Facturacion\Empresa::find(1);

           $resultados =  DB::table('gastos')
          ->whereBetween('fecha', array($min_price, $max_price))
          ->selectRaw('mes')
          ->selectRaw('sum(neto) as valor')
          ->groupBy('mes')
          ->get();


      return View::make('facturacion::informeprueba', compact('clientes','unitarios','gastos','prefijo','resultados'));
});

    Route::get('camarada/pdfview',array('as'=>'pdfview','uses'=>'DigitalsiteSaaS\Facturacion\Http\FacturacionController@pdfview'));
});


Route::get('excel-oficina/web', function () {
    return view('facturacion::importExport');
});



Route::get('importExport', 'DigitalsiteSaaS\Facturacion\Http\ImportExportController@importExport');
Route::get('exportador/{type}', 'DigitalsiteSaaS\Facturacion\Http\ImportExportController@exportador');
Route::post('importador', 'DigitalsiteSaaS\Facturacion\Http\ImportExportController@importador');
Route::get('exportadores/excel/{type}', 'DigitalsiteSaaS\Facturacion\Http\ImportExportController@downloadExcel');
Route::get('informe/exportpdf', 'DigitalsiteSaaS\Facturacion\Http\ImportExportController@exportPDF');


Route::get('gestor/validacionesado', function () {
          $user = DB::table('clientes')->where('documento', Input::get('documento'))->count();
    if($user > 0) {
        $isAvailable = FALSE;
    } else {
        $isAvailable = TRUE;
    }
    echo json_encode(
            array(
                'valid' => $isAvailable
            )); 

});