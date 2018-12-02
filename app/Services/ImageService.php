<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Facades\LocalFile;

class ImageService
{
    const IMAGE_PNG = 'image/png';

    const IMAGE_JPEG = 'image/jpeg';

    const IMAGE_GIF = 'image/gif';

    /**
     * Image Service Image.
     *
     * @var null
     */
    public $image = null;

    private $imageResized;

    /**
     * Upload Image and resize it.
     *
     * @var \Symfony\Component\HttpFoundation\File\File
     * @var string $path
     * @var bool $keepAspectRatio
     * @return \App\Facades\LocalFile
     */
    public function upload($image, $path = null, $makeDiffSizes = true)
    {
        $dbPath = $image->store($path, 'public');
        $name = basename($dbPath);

        if (true === $makeDiffSizes) {
            $sizes = config('site.image.sizes');
            foreach ($sizes as $sizeName => $widthHeight) {
                list($width, $height) = $widthHeight;
                $this->make("storage" . DIRECTORY_SEPARATOR .$dbPath);
                $this->resizeImage($width, $height, 'crop');
                $imagePath = storage_path('app/public/' . $path) . DIRECTORY_SEPARATOR . $sizeName . '-' . $name;
                $this->saveImage($imagePath, 100);
            }
        }

        $localImage = new LocalFile("storage" . DIRECTORY_SEPARATOR . $dbPath);

        return $localImage;
    }

    /**
     * Create Directories if not exists.
     *
     * @var string
     * @return \App\Services\ImageService
     */
    public function directory($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0775, true, true);
        }

        return $this;
    }

    /**
     * @todo destroy the image from path
     *
     *
     * @return \App\Services\ImageService
     */
    public function destroy()
    {
        dd($this);

        $sizes = config('site.image.sizes');
        foreach ($sizes as $sizeName => $widthHeight) {
            // code...
        }
    }

    public function make($image)
    {
        // *** Open up the file
        // print_r($image);exit;
        $this->image = $this->openImage($image);
        // *** Get width and height
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    private function openImage($file)
    {
        // *** Get extension
        $extension = strtolower(strrchr($file, '.'));
        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                $img = @imagecreatefromjpeg($file);

                break;
            case '.gif':
                $img = @imagecreatefromgif($file);
                break;
            case '.png':
                $img = @imagecreatefrompng($file);
                break;
            default:
                $img = false;
                break;
        }

        return $img;
    }

    public function resizeImage($newWidth, $newHeight, $option = 'auto')
    {
        // *** Get optimal width and height - based on $option
        $optionArray = $this->getDimensions($newWidth, $newHeight, strtolower($option));

        $optimalWidth = $optionArray['optimalWidth'];
        $optimalHeight = $optionArray['optimalHeight'];

        // *** Resample - create image canvas of x, y size
        $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
        imagecopyresampled(
            $this->imageResized,
            $this->image,
            0,
            0,
            0,
            0,
            $optimalWidth,
            $optimalHeight,
            $this->width,
            $this->height
        );

        // *** if option is 'crop', then crop too
        if ($option == 'crop') {
            $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
        }
    }

    private function getDimensions($newWidth, $newHeight, $option)
    {
        switch ($option) {
            case 'exact':
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
                break;
            case 'portrait':
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
                break;
            case 'landscape':
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
                break;
            case 'auto':
                $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
        }

        return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
    }

    private function getSizeByFixedHeight($newHeight)
    {
        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;

        return $newWidth;
    }

    private function getSizeByFixedWidth($newWidth)
    {
        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;

        return $newHeight;
    }

    private function getSizeByAuto($newWidth, $newHeight)
    {
        if ($this->height < $this->width) { // *** Image to be resized is wider (landscape)
            $optimalWidth = $newWidth;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth);
        } elseif ($this->height > $this->width) { // *** Image to be resized is taller (portrait)
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight = $newHeight;
        } else { // *** Image to be resizerd is a square
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            } elseif ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
            } else {
                // *** Sqaure being resized to a square
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
            }
        }

        return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
    }

    private function getOptimalCrop($newWidth, $newHeight)
    {
        $heightRatio = $this->height / $newHeight;
        $widthRatio = $this->width / $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->height / $optimalRatio;
        $optimalWidth = $this->width / $optimalRatio;

        return ['optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight];
    }

    private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
    {
        // *** Find center - this will be used for the crop
        $cropStartX = ($optimalWidth / 2) - ($newWidth / 2);
        $cropStartY = ($optimalHeight / 2) - ($newHeight / 2);

        $crop = $this->imageResized;
        //imagedestroy($this->imageResized);

        // *** Now crop from center to exact requested size
        $this->imageResized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled(
            $this->imageResized,
            $crop,
            0,
            0,
            $cropStartX,
            $cropStartY,
            $newWidth,
            $newHeight,
            $newWidth,
            $newHeight
        );
    }

    public function saveImage($savePath, $imageQuality = '100')
    {
        // *** Get extension
        $extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                if (imagetypes() & IMG_JPG) {
                    imagejpeg($this->imageResized, $savePath, $imageQuality);
                }
                break;

            case '.gif':
                if (imagetypes() & IMG_GIF) {
                    imagegif($this->imageResized, $savePath);
                }
                break;

            case '.png':
                // *** Scale quality from 0-100 to 0-9
                $scaleQuality = round(($imageQuality / 100) * 9);

                // *** Invert quality setting as 0 is best, not 9
                $invertScaleQuality = 9 - $scaleQuality;

                if (imagetypes() & IMG_PNG) {
                    imagepng($this->imageResized, $savePath, $invertScaleQuality);
                }
                break;

            default:

                break;
        }

        imagedestroy($this->imageResized);
    }
}
