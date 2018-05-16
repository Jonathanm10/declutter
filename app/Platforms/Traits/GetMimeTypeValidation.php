<?php

namespace App\Platforms\Traits;


use finfo;

trait GetMimeTypeValidation
{
    protected $supportedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
    ];

    /**
     * @param string $imageUrl
     * @throws \Exception
     */
    protected function imageUrlValidation($imageUrl)
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $fileInfo->buffer(file_get_contents($imageUrl));

        if (! in_array($mimeType, $this->supportedMimeTypes)) {
            throw new \Exception(
                sprintf(
                    'Type de fichier non supporté. Types supportés : [%s]',
                    str_replace('image/', '', implode(', ', $this->supportedMimeTypes))
                )
            );
        }
    }
}