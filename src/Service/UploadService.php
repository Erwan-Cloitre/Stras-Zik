<?php

namespace App\Service;

class UploadService
{
    private const ALLOWED = ['.jpg', '.png', '.gif'];
    private const SIZE_MAX = 1000000;

    private function sizeImage($image)
    {
         $size = filesize($image['tmp_name']);
         return $size < self::SIZE_MAX;
    }

    private function typeImage($image)
    {
        $extension = strrchr($image['name'], '.');
        return in_array($extension, self::ALLOWED);
    }

    private function getErrors($image)
    {
        $errors = [];
        if (!$this->sizeImage($image)) {
            $errors['size'] = "Le fichier est trop grand";
        }
        if (!$this->typeImage($image)) {
            $errors['type'] = "Le format du fichier n'est pas autorisé";
        }
        return $errors;
    }

    public function upload($image)
    {
        $errors = $this->getErrors($image);
        if (!empty($errors)) {
            return $errors;
        }
        $directory = 'assets/images';
        $file = basename($image['name']);
        move_uploaded_file($image['tmp_name'], $directory . '/' . $file) ;
        return $file;
    }
}
