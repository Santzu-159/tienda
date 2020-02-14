<?php

use Illuminate\Database\Seeder;
use App\Articulo;
use Illuminate\Support\Facades\DB;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articulos'); 
        
        Articulo::create([
            'nombre'=>'Ventilador',
            'categoria'=>'Hogar',
            'precio'=>'30',
            'stock'=>'30',
            'imagen'=>'/img/ventilador.png'
        ]);
        Articulo::create([
            'nombre'=>'Cachimba',
            'categoria'=>'Bazar',
            'precio'=>'25',
            'stock'=>'5',
            'imagen'=>'/img/cachimba.png'
        ]);
        Articulo::create([
            'nombre'=>'Ordenador',
            'categoria'=>'Electronica',
            'precio'=>'600',
            'stock'=>'10',
            'imagen'=>'/img/ordenador.png'
        ]);
        Articulo::create([
            'nombre'=>'Vajilla',
            'categoria'=>'Hogar',
            'precio'=>'15',
            'stock'=>'90',
            'imagen'=>'/img/vajilla.png'
        ]);
        Articulo::create([
            'nombre'=>'Lavadora',
            'categoria'=>'Hogar',
            'precio'=>'300',
            'stock'=>'50',
            'imagen'=>'/img/lavadora.png'
        ]);

    }
}
