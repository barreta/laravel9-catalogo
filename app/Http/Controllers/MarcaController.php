<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = Marca::paginate(3);

        return view('marcas', ['marcas' => $marcas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = Marca::paginate(3);

        return view('marcaCreate', ['marcas' => $marcas]);

    }

    
    private function validarForm( Request $request )
    {
        $request->validate(
            // [ 'campo'=>'reglas' ], [ 'campo.regla'=>'mensaje' ]
            [
                'mkNombre'=>'required|min:2|max:30|unique:marcas,mkNombre'
            ],
            [
                'mkNombre.required'=>'El campo "Nombre de la marca" es obligatorio',
                'mkNombre.min'=>'El campo "Nombre de la marca" debe tener al menos 2 caractéres',
                'mkNombre.max'=>'El campo "Nombre de la marca" debe tener 30 caractéres como máximo',
                'mkNombre.unique'=>'Nombre de la marca ya existe en la base de datos'
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mkNombre = $request->mkNombre;
        //validación
        $this->validarForm($request);
        //almacenamos en tabla
        try {
            //intanciamos
            $Marca = new Marca;
            //asignamos valores a atributos
            $Marca->mkNombre = $mkNombre;
            //guardamos
            $Marca->save();
            //redirección con mensaje de ok
            return redirect('/marcas')
                    ->with(
                        [
                            'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente',
                            'css'=>'success'
                        ]
                    );
        }
        catch ( \Throwable $th ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se pudo agregar la marca: '.$mkNombre,
                        'css'=>'danger'
                    ]
                );
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Marca = Marca::find($id);

        return view('marcaEdit', ['Marca' => $Marca]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // captura de datos envios por el form
        $mkNombre = $request->mkNombre;
        $idMarca = $request->idMarca;

        //validación
        //$this->validarForm() ; // ver de la clase anterior
    }


    public function confirm( $id, $marca )
    {
        //si NO hay productos de esa marca
        //$check = Producto::where('idMarca', $id)->first(); //null|Producto
        //$check = Producto::firstWhere('idMarca', $id); //null|Producto
        $cantidad = Producto::where('idMarca', $id)->count(); // int
        if( $cantidad ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se puede eliminar la marca: '.$marca.' ya que tiene productos relacionados',
                        'css'=>'warning'
                    ]
                );
        }
        return view('marcaDelete',
                        [
                            'idMarca' => $id, 
                            'mkNombre' => $marca
                        ]
        );
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $mkNombre = $request->mkNombre;
        $idMarca = $request->idMarca;
        try {
            //$Marca = Marca::find($idMarca);
            //$Marca->delete();
            Marca::destroy($idMarca);  // Los 2 pasos anteriores en 1 solo paso
            return redirect('/marcas')
                    ->with(
                        [
                            'mensaje'=>'Marca: '.$mkNombre.' eliminada correctamente.',
                            'css'=>'success'
                        ]
                    );
        }
        catch ( \Throwable $th ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se pudo eliminar la marca: '.$mkNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }
}
