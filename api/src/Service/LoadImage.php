<?php

namespace App\Service;


use App\Repository\ProductRepository;

class LoadImage
{
    private string $dirImage;

    public function __construct($dirImage)
    {
        $this->dirImage = $dirImage;
    }

    public function setImages($imageFiles): array
    {
        $arrayImage = [];
        if (empty($imageFiles)) {
            return [];
        }
        if (!file_exists($this->dirImage)) { // существует ли директория
            mkdir($this->dirImage, 0777, true);
        }

        $uniqProduct = uniqid('/'); // уникальное имя папки продукта
        $arrayImage[$uniqProduct] = []; // сохраняем уникальное имя пакпки в массиве

        mkdir($this->dirImage . $uniqProduct); // создаем папку продукта

        foreach ($imageFiles as $img) {
            $uniqImage = uniqid('/'); // уникальное имя папки изображение
            $arrayImage[$uniqProduct][$uniqImage] = []; // сохраняем его в массиве

            $text = strstr($img, ',', false); // обрезаем не нужное
            $base64 = substr($text, 1); // еще немного обрезаем
            $bin = base64_decode($base64); // декодируем иизображение
            if (strlen($bin) > 7400000) { // проверям на размер изображения
                continue;
            }

            $result = imagecreatefromstring($bin); // создаем изображение для GD

            $uniqOrigin = uniqid('/origin-') . '.webp';
            mkdir($this->dirImage . $uniqProduct . $uniqImage); // создаем папку для изображения
            $fullPath = $this->dirImage . $uniqProduct . $uniqImage . $uniqOrigin;
            imagewebp($result, $fullPath);
            $arrayImage[$uniqProduct][$uniqImage][] = $uniqOrigin;

            $gd = imagecreatefromwebp($fullPath);

            $uniq600 = uniqid('/600x600-') . '.webp';
            $result = imagescale($gd, 600, 600);
            $fullPath = $this->dirImage . $uniqProduct . $uniqImage . $uniq600;
            imagewebp($result, $fullPath);
            $arrayImage[$uniqProduct][$uniqImage][] = $uniq600;

            $uniq300 = uniqid('/300x300-') . '.webp';
            $result = imagescale($gd, 300, 300);
            $fullPath = $this->dirImage . $uniqProduct . $uniqImage . $uniq300;
            imagewebp($result, $fullPath);
            $arrayImage[$uniqProduct][$uniqImage][] = $uniq300;

            $uniq150 = uniqid('/150x150-') . '.webp';
            $result = imagescale($gd, 150, 150);
            $fullPath = $this->dirImage . $uniqProduct . $uniqImage . $uniq150;
            imagewebp($result, $fullPath);
            $arrayImage[$uniqProduct][$uniqImage][] = $uniq150;

        }

        return $arrayImage;
    }

    public function deleteImages(array $images = []): bool
    {
        if (empty($images)) {
            return false;
        }
        $productPath = '';
        $imagePath = [];
        $fullPath = [];
        foreach ($images as $product => $img) {
            $productPath = $this->dirImage . $product;
            foreach ($img as $key => $items) {
                $imagePath[] = $this->dirImage . $product . $key;
                foreach ($items as $item) {
                    $text = $this->dirImage . $product . $key;
                    $text .= $item;
                    $fullPath[] = $text;
                }
            }
        }
        foreach ($fullPath as $path) {
            unlink($path);
        }
        foreach ($imagePath as $item) {
            rmdir($item);
        }
        rmdir($productPath);
        return true;
    }
}
