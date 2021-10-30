<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;


trait FotosTrait
{
    public static function store($request, $ubicacion)
    {
        $name = 'noimage.png';
        if ($request->get('foto')) {
            $carpeta = public_path() . '/img/' . $ubicacion . '/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $image = $request->get('foto');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->get('foto'))->save(public_path('img/' . $ubicacion . '/') . $name);
        }
        return '/img/' . $ubicacion . '/' . $name;
    }

    public static function update($request, $ubicacion, $objeto)
    {
        if ($request->get('foto') && $request->get('newFoto')) {
            $carpeta = public_path() . '/img/' . $ubicacion . '/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $eliminar = $objeto->foto;
            if (file_exists($eliminar)) {
                @unlink($eliminar);
            }
            $image = $request->get('foto');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->get('foto'))->save(public_path('img/' . $ubicacion . '/') . $name);
            return '/img/' . $ubicacion . '/' . $name;
        } else {
            return $objeto->foto;
        }
    }
}
