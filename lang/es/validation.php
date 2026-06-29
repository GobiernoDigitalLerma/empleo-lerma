<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mensajes de validación
    |--------------------------------------------------------------------------
    |
    | Mensajes mínimos en español para formularios propios. Se agregan primero
    | las reglas usadas actualmente por el dashboard y se podrán ampliar por módulo.
    |
    */

    'date' => 'El campo :attribute debe ser una fecha válida.',
    'extensions' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'file' => 'El campo :attribute debe ser un archivo válido.',
    'image' => 'El campo :attribute debe ser una imagen válida.',
    'in' => 'El campo :attribute seleccionado no es válido.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'max' => [
        'file' => 'El archivo :attribute no debe ser mayor a :max kilobytes.',
        'string' => 'El campo :attribute no debe ser mayor a :max caracteres.',
    ],
    'mimes' => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
    ],
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser texto.',
    'url' => 'El campo :attribute debe ser una URL válida.',

    'attributes' => [
        'description' => 'descripción',
        'event_date' => 'fecha del evento',
        'image_file' => 'imagen de publicidad',
        'image_path' => 'ruta de imagen',
        'link' => 'liga externa',
        'location' => 'ubicación',
        'name' => 'nombre',
        'sort_order' => 'orden',
        'status' => 'estado',
        'title' => 'título',
        'type' => 'tipo',
    ],
];
