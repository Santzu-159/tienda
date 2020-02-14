@extends('plantillas.plantilla')
@section('titulo')
Artículos
@endsection
@section('cabecera')
Artículos
@endsection
@section('contenido')
@if($texto=Session::get('mensaje'))
    <p class="alert alert-success my-3">{{$texto}}</p>
@endif

<div class="container">

    <a href="{{route('articulos.create')}}" class="btn btn-warning mb-3">Nuevo Artículo</a>

    <form name="search" method="get" action="{{route('articulos.index')}}" class="form-inline float-right">
        <i class="fa fa-search fa-2x ml-2 mr-2" aria-hidden="true"></i>
        <select name='categoria' class='form-control mr-2'>
        <option value='%'>Todos</option>

        @foreach($categorias as $categoria)
             @if($categoria==$request->categoria)
                <option selected>{{$categoria}}</option>
             @else
                <option>{{$categoria}}</option>
            @endif
        @endforeach
        </select>

        <select name="precio" class="form-control">
            <option value='0'>Todos</option>
            <?php $cont=1; ?>
            @foreach ($precios as $precio)
                @if($cont==$request->precio)
                    <option selected="" value="<?php echo $cont ?>">{{$precio}}</option>
                @else
                    <option value="<?php echo $cont ?>">{{$precio}}</option>
                @endif
            <?php $cont++; ?>
            @endforeach
        </select>
        <input type="submit" value="Buscar" class="btn btn-info ml-2">
    </form>
</div> 

<table class="table table-striped table-dark mt-3">
    <thead>
      <tr>
       <!-- <th scope="col">Detalles</th>-->
        <th scope="col">Nombre</th>
        <th scope="col">Categoria</th>
        <th scope="col">Precio</th>
        <th scope="col">Stock</th>
        <th scope="col">Imagen</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>

    <tbody>
        @foreach($articulos as $articulo)
        <tr>
            <!--<th scope="row">
                <a href="{{route('articulos.show',$articulo)}}" style="text-decoration:none"><i class="fa fa-address-card fa-3x"></i></a>
            </th>-->
            <td class="align-middle">{{$articulo->nombre}}</td>
            <td class="align-middle">{{$articulo->categoria}}</td>
            <td class="align-middle">{{$articulo->precio}}€</td>
            <td class="align-middle">{{$articulo->stock}}</td>
            <td>
                <img src="{{asset($articulo->imagen)}}" width="100px" height='110px'>
                </td>
            <td class="align-middle">
                <form name="borrar" method='post' action='{{route('articulos.destroy', $articulo)}}'>
                    @csrf
                    @method('DELETE')
                    <a href='{{route('articulos.edit', $articulo)}}' class='btn btn-info'>Editar</a>
                    <button type='submit' class='btn btn-danger' >Borrar</button>
                </form>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>
{{$articulos->appends(Request::except('page'))->links()}}
@endsection
