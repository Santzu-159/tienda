<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categorias=['Bazar','Hogar','Electrónica'];
        $precios=['Menos de 10€',
        'De 10€ a 50€',
        'De 50€ a 100€',
        'Más de 100€'];
 
        $categoria=$request->get('categoria');
        $precio=$request->get('precio');
 
        $articulos=Articulo::orderBy('id')
        ->categoria($categoria)
        ->precio($precio)
        ->paginate(5);
 
        return view('articulos.index',compact('articulos','categorias','precios','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articulos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>['required'],
            'categoria'=>['required'],
            'precio'=>['required']
        ]);
        
        if($request->has('imagen')){
            $request->validate([
                'imagen'=>['image']
            ]);

            $file=$request->file('imagen');
            $nombre=time().'_'.$file->getClientOriginalName();
            Storage::disk('public')->put($nombre, \File::get($file));
            $articulo=Articulo::create($request->all());
            $articulo->update(['imagen'=>"/img/$nombre"]);
        }
        else{
            Articulo::create($request->all());
        }
        return redirect()->route('articulos.index')->with('mensaje','Artículo guardado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        return view('articulos.show',compact('articulo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        $categorias=['Bazar','Hogar','Electrónica'];
        return view('articulos.edit',compact('articulo','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {
        $request->validate([
            'nombre'=>['required'],
            'categoria'=>['required'],
            'precio'=>['required']
        ]);
        
        if($request->has('imagen')){
            $request->validate([
                'imagen'=>['image']
            ]);
            
            $file=$request->file('imagen');
            $nombre=time().'_'.$file->getClientOriginalName();
            Storage::disk('public')->put($nombre, \File::get($file));
            if(basename($articulo->imagen)!='default.png'){
                unlink(public_path().$articulo->imagen);
            }
            //ahora actualizo el articulo
            $articulo->update($request->all());
            $articulo->update(['imagen'=>"/img/$nombre"]);
        }
        else{
            $articulo->update($request->all());
        }
        return redirect()->route('articulos.index')->with('mensaje','Artículo Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        $imagen=$articulo->imagen;

        if(basename($imagen)!='default.png'){
            unlink(public_path().$imagen);
        }
        $articulo->delete();
        return redirect()->route('articulos.index')->with('mensaje','Artículo Eliminado');
    }
}
