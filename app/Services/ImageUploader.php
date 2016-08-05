<?php namespace Teachat\Services;

/**
 * A service class to upload images.
 *
 * @author gab
 * @package Teachat\Services
 * @return string
 */
class ImageUploader
{
    /**
     * Call Curl Request.
     *
     * @param string $fields
     * @param School $school
     * @return void
     */
    public function upload($file, $school_id)
    {
        $file_name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        //dd($orig_file);
        if (\Storage::disk('uploads')->put('images/school_badges/' . $school_id . '.' . $extension, \File::get($file))) {
            return true;
        }

        return false;
    }
}
