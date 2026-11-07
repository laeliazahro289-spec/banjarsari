<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Upload
{
    // Simpan langsung ke public/uploads/{folder}; tidak perlu "storage:link".
    public static function save(UploadedFile $file, string $folder): string
    {
        $dir  = 'uploads/' . $folder;
        $name = Str::random(24) . '.' . $file->extension();
        $file->move(public_path($dir), $name);

        return $dir . '/' . $name;
    }

    public static function delete(?string $path): void
    {
        if ($path && str_starts_with($path, 'uploads/')) {
            $full = public_path($path);
            if (is_file($full)) {
                @unlink($full);
            }
        }
    }
}
