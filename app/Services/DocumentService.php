<?php

namespace App\Services;

use App\Models\CitizenDocument;
use App\Models\CitizenProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Servicio para guardar y descargar documentos privados de ciudadanos.
 */
class DocumentService
{
    /**
     * Almacena documentos en disco privado, nunca en carpeta pública.
     */
    public function storeCitizenDocument(CitizenProfile $profile, UploadedFile $file, string $type): CitizenDocument
    {
        $path = $file->store("citizens/{$profile->id}/documents", 'local');

        return $profile->documents()->create([
            'type' => $type,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
            'size' => $file->getSize() ?: 0,
            'is_current' => true,
            'uploaded_at' => now(),
        ]);
    }

    /**
     * Descarga un documento privado desde el disco local autorizado.
     */
    public function download(CitizenDocument $document)
    {
        return Storage::disk('local')->download($document->path, $document->original_name);
    }
}
