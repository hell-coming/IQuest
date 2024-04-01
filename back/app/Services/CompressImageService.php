<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class CompressImageService
 *
 * @property UploadedFile $file Загруженный файл
 * @property string $directory Название директории
 * @property int $quality Качество сжатия
 */
readonly class CompressImageService
{

    public function __construct(private UploadedFile $file, private string $directory, private int $quality = 50)
    {
    }

    public function compress(): string|false
    {
        $filename = $this->file->store($this->directory, ['disk' => 'public']);

        $path = Storage::disk('public')->path($filename);

        $image = Image::make($path);

        $image->orientate();

        $image->resize($image->width(), $image->height(), function ($constraint) {
            $constraint->aspectRatio();
        });

        $image->save($path, $this->quality);

        return $filename;
    }
}
