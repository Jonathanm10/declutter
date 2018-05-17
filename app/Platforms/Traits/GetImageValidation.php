<?php

namespace App\Platforms\Traits;


use finfo;
use Illuminate\Support\Facades\Storage;

trait GetImageValidation
{
    /**
     * Since Twitter & Petitesannonces share the same supported mime types, we can leave it here
     *
     * @var array
     */
    protected $supportedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    /**
     * @param $imageName
     * @throws \Exception
     */
    protected function imageSizeValidation($imageName)
    {
        if (Storage::size($imageName) > self::MAX_IMAGE_UPLOAD_SIZE) {
            Storage::delete($imageName);
            throw new \Exception(
                sprintf(
                    "La taille de l'image ne doit pas excéder %d %s",
                    self::MAX_IMAGE_UPLOAD_SIZE / pow(1024, 2),
                    'Mo'
                )
            );
        }
    }

    /**
     * @param string $imageUrl
     * @throws \Exception
     */
    protected function imageUrlValidation($imageUrl)
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fileInfo->buffer(file_get_contents($imageUrl));

        if (!in_array($mimeType, $this->supportedMimeTypes)) {
            throw new \Exception(
                sprintf(
                    'Type de fichier non supporté. Types supportés : [%s]',
                    str_replace('image/', '', implode(', ', $this->supportedMimeTypes))
                )
            );
        }
    }
}
