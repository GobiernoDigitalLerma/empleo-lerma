<?php

namespace App\Enums;

/**
 * Tipos de documentos privados que puede cargar un ciudadano.
 */
enum DocumentType: string
{
    case Cv = 'cv';
    case Photo = 'photo';
    case Other = 'other';
}
