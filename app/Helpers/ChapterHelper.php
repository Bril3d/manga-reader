<?php

namespace App\Helpers;

use ZipArchive;
use App\Models\Chapter;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class ChapterHelper
{
    /**
     * Extract images from a ZIP file and store them.
     *
     * @param string $zipFile
     * @param string $mangaSlug
     * @param int $chapterNumber
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public static function extractImagesFromZip($zipFile, $mangaSlug, $chapterNumber)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipFile) === true) {
            $extractedImages = [];
            $fileList = self::getZipFileList($zip);

            // Custom sorting function to treat filenames as numeric values
            usort($fileList, function ($a, $b) {
                return strnatcasecmp($a, $b);
            });

            foreach ($fileList as $filename) {
                if (self::isImageFile($filename)) {
                    $imageContent = $zip->getFromName($filename);

                    if (settings()->get('extension') == 'same') {
                        $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    } else {
                        $extension = settings()->get('extension');
                    }
                    $imageName = self::storeImage($imageContent, $mangaSlug, $chapterNumber, $extension);
                    $extractedImages[] = $imageName;
                } else {
                    return back()->with('error', 'ZIP File is not valid.');
                }
            }

            $zip->close();

            return $extractedImages;
        } else {
            return back()->with('error', 'Failed to open ZIP file.');
        }
    }

    public static function extractImagesList($images, $mangaSlug, $chapterNumber)
    {
        $imageData = [];
        foreach ($images as $index => $image) {
            if (settings()->get('extension') == 'same') {
                $extension = $image->extension();
            } else {
                $extension = settings()->get('extension');
            }
            $imageName = self::storeImage($image, $mangaSlug, $chapterNumber, $extension);
            $imageData[] = [
                'name' => $imageName,
                'order' => $index,
            ];
        }

        // Sort the image data based on the order value
        usort($imageData, function ($a, $b) {
            return $a['order'] - $b['order'];
        });

        return array_column($imageData, 'name');
    }

    /**
     * Get the list of files in a ZIP archive.
     *
     * @param ZipArchive $zip
     * @return array
     */
    public static function getZipFileList(ZipArchive $zip)
    {
        $fileList = [];

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $fileList[] = $filename;
        }

        sort($fileList);

        return $fileList;
    }

    /**
     * Check if a filename represents an image file.
     *
     * @param string $filename
     * @return bool
     */
    public static function isImageFile($filename)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array(strtolower($fileExtension), $imageExtensions);
    }

    /**
     * Generate a unique image name.
     *
     * @param string $mangaSlug
     * @param int $chapterNumber
     * @return string
     */
    public static function generateUniqueImageName($mangaSlug, $chapterNumber, $extension)
    {
        $randomName = uniqid();
        return "{$randomName}.{$extension}";
    }

    /**
     * Store an image.
     *
     * @param string $imageContent
     * @param string $mangaSlug
     * @param int $chapterNumber
     * @param string $extension
     * @return string
     */
    public static function storeImage($imageContent, $mangaSlug, $chapterNumber, $extension)
    {
        $imgData = Image::read($imageContent)->encodeByExtension($extension, quality: settings()->get('quality'));
        $destinationPath = self::getChapterImagePath($mangaSlug, $chapterNumber, $extension);
        Storage::put($destinationPath, $imgData, 'public');
        return basename($destinationPath);
    }

    /**
     * Get the storage path for a chapter image.
     *
     * @param string $mangaSlug
     * @param int $chapterNumber
     * @return string
     */
    public static function getChapterImagePath($mangaSlug, $chapterNumber, $extension)
    {
        $imageName = self::generateUniqueImageName($mangaSlug, $chapterNumber, $extension);
        return "public/content/{$mangaSlug}/{$chapterNumber}/{$imageName}";
    }

    /**
     * Delete the images of a chapter.
     *
     * @param Chapter $chapter
     * @return void
     */
    public static function deleteChapterImages(Chapter $chapter, $slug = null)
    {
        if ($slug) { // for deleted chapters
            $mangaSlug = $slug;
        } else {
            $mangaSlug = $chapter->manga->slug;
        }
        $chapterNumber = $chapter->chapter_number;
        $directoryPath = "public/content/{$mangaSlug}/{$chapterNumber}";
        Storage::deleteDirectory($directoryPath);
    }

    /**
     * Rename the folder of a chapter.
     *
     * @param string $mangaSlug
     * @param int $currentChapterNumber
     * @param int $newChapterNumber
     * @return void
     */
    public static function renameChapterFolder($oldSlug = null, $mangaSlug, $currentChapterNumber, $newChapterNumber)
    {
        if ($oldSlug) {
            $currentPath = "public/content/{$oldSlug}/{$currentChapterNumber}";
        } else {
            $currentPath = "public/content/{$mangaSlug}/{$currentChapterNumber}";
        }
        $newPath = "public/content/{$mangaSlug}/{$newChapterNumber}";

        if (Storage::exists($currentPath)) {
            Storage::move($currentPath, $newPath);
        }
    }

    /**
     * Extract images from a folder and store them.
     *
     * @param string $folderPath The path to the folder containing the images.
     * @param string $mangaSlug The slug of the manga.
     * @param int $chapterNumber The number of the chapter.
     * @return array The array of stored image names.
     */
    public static function extractImagesFromFolder($folderPath, $mangaSlug, $chapterNumber)
    {
        $images = [];

        $files = glob($folderPath . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
        foreach ($files as $file) {
            if (settings()->get('extension') == 'same') {
                $extension = $file->extension();
            } else {
                $extension = settings()->get('extension');
            }

            $imageContent = file_get_contents($file);
            $imageName = self::storeImage($imageContent, $mangaSlug, $chapterNumber, $extension);
            $images[] = $imageName;
        }

        return $images;
    }
}
