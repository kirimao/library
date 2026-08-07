<?php

namespace App\Actions\Book;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class ProcessBookCoverAction
{
    public function execute(UploadedFile $file, ?string $oldCoverImage = null, ?string $oldCoverThumbnail = null): array
    {
        $manager = new ImageManager(new Driver());

        // Pastikan direktori penyimpanan ada
        Storage::disk('public')->makeDirectory('covers');
        Storage::disk('public')->makeDirectory('covers/thumbnails');

        // Hapus file lama jika ada
        if ($oldCoverImage && Storage::disk('public')->exists($oldCoverImage)) {
            Storage::disk('public')->delete($oldCoverImage);
        }
        if ($oldCoverThumbnail && Storage::disk('public')->exists($oldCoverThumbnail)) {
            Storage::disk('public')->delete($oldCoverThumbnail);
        }

        $filename = uniqid('cover_') . '_' . time();
        $coverPath = 'covers/' . $filename . '.jpg';
        $thumbPath = 'covers/thumbnails/thumb_' . $filename . '.jpg';

        // 1. Cover Utama (max width 800px, kompresi kualitas 80%)
        $image = $manager->decodePath($file->getRealPath());
        if ($image->width() > 800) {
            $image->scale(width: 800);
        }
        $encodedCover = (string) $image->encode(new JpegEncoder(quality: 80));
        Storage::disk('public')->put($coverPath, $encodedCover);

        // 2. Thumbnail Cover (max width 300px, kompresi kualitas 75%)
        $thumb = $manager->decodePath($file->getRealPath());
        if ($thumb->width() > 300) {
            $thumb->scale(width: 300);
        }
        $encodedThumb = (string) $thumb->encode(new JpegEncoder(quality: 75));
        Storage::disk('public')->put($thumbPath, $encodedThumb);

        return [
            'cover_image' => $coverPath,
            'cover_thumbnail' => $thumbPath,
        ];
    }
}
