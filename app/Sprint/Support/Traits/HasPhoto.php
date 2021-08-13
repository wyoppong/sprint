<?php

namespace App\Sprint\Support\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Mediable Trait.
 *
 * Provides functionality for attaching media to an eloquent model.
 *
 * @author WY OPPONG <wyoppong@gmail.com>
 *
 * Whether the model should automatically reload its media relationship after modification.
 */
trait HasPhoto
{
    /**
     * Update the model's photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updatePhoto(UploadedFile $photo, $storage)
    {
        tap($this -> photoColumn(), function ($previous) use ($photo, $storage) {
            $this -> forceFill([
                $this -> photoColumn() => $photo -> storePublicly(
                    $storage, ['disk' => $this -> photoDisk()]
                ),
            ]) -> save();

            if ($previous) {
                Storage::disk($this -> photoDisk()) -> delete($previous);
            }
        });
    }

    /**
     * Delete the model's photo.
     *
     * @return void
     */
    public function deletePhoto()
    {
        Storage::disk($this -> photoDisk()) -> delete($this -> photoColumn());

        $this -> forceFill([
            $this -> photoColumn() => null,
        ]) -> save();
    }

    /**
     * Get the URL to the model's photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this -> photoColumnObject()
                        ? Storage::disk($this -> photoDisk()) -> url($this -> photoColumnObject())
                        : null;
    }

    /**
     * Get the default photo URL if no photo has been uploaded.
     *
     * @return string
     */
    protected function defaultPhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that photos should be stored on.
     *
     * @return string
     */
    protected function photoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }

}
