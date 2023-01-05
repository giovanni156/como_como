<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    /**
     * Save image on storage
     *
     * @param  mixed $file
     * @param  string $fileName
     * @param  int $maxWidth
     * @return void
     */
    public static function saveOnStorage(
        mixed $file,
        string $fileName,
        int $maxWidth = 300
    ): void
    {
        $resizedImage = Image::make($file)->widen(
            $maxWidth,
            function (Constraint $image) {
                $image->upsize();
            }
        )->stream()->__toString();

        Storage::disk('public')->put(
            $fileName,
            $resizedImage,
            'public'
        );
    }

    /**
     * Get extension file
     *
     * @param  string $image
     * @return string
     */
    public static function getFileName(string $image): string
    {
        return Str::of(
            Str::of($image)->explode(';base64')[0]
        )->explode('/')[1];
    }

    /**
     * Destroy model image if exists
     *
     * @param string $fileName
     * @return Boolean|void
     */
    public static function destroyExistingImage($fileName)
    {
        if ($fileName) {
            Storage::disk('public')->delete($fileName);
        }
    }

    /**
     * Save model image
     *
     * @param  Model $model
     * @param  string $column
     * @param  string $image
     * @param  int $maxWidth
     * @return void
     */
    public static function saveImage(
        Model $model,
        string $column,
        string $image,
        int $maxWidth = 300
    ): void
    {
        self::destroyExistingImage($model->$column);

        $fileName = self::getFileName($model, $image);

        self::saveOnStorage($image, $fileName, $maxWidth);

        $model->update([
            $column => '/storage' . $fileName
        ]);
    }

    /**
     * Validate if model image has base64 format
     *
     * @param  string $image
     * @return Boolean
     */
    public static function isValidImage(string|null $image): bool
    {
        return Str::contains($image, 'base64');
    }
}
