<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PhotoEditorController extends Controller
{
    public function index()
    {
        return view('photo-editor.index');
    }

    public function process(Request $request)
    {
        set_time_limit(1800);

        // Validasi input
        $request->validate([
            'photos' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:10000', // Validasi untuk setiap file
            'border' => 'required|string',
        ]);

        // Ambil semua file yang diupload
        $photos = $request->file('photos');
        $borderPath = public_path('borders/' . $request->input('border'));
        $editedFiles = []; // Array untuk menyimpan path file yang sudah diedit

        foreach ($photos as $photo) {
            // Muat gambar menggunakan Intervention Image
            $img = Image::make($photo->getRealPath());

            // Membaca metadata EXIF untuk orientasi
            $exifData = @exif_read_data($photo->getRealPath());
            if (isset($exifData['Orientation'])) {
                switch ($exifData['Orientation']) {
                    case 3:
                        $img->rotate(180);
                        break;
                    case 6:
                        $img->rotate(-90);
                        break;
                    case 8:
                        $img->rotate(90);
                        break;
                }
            }

            // Hitung rasio gambar dan sesuaikan ukuran
            $maxSize = 1080;
            $imgRatio = $img->width() / $img->height();
            if ($img->width() < $img->height()) {
                $newWidth = $maxSize;
                $newHeight = intval($maxSize / $imgRatio);
            } else {
                $newHeight = $maxSize;
                $newWidth = intval($maxSize * $imgRatio);
            }
            $img->resize($newWidth, $newHeight);

            // Resize canvas ke 1080x1080
            $img->resizeCanvas($maxSize, $maxSize, 'center');

            // Tambahkan border ke gambar
            $border = Image::make($borderPath)->resize($maxSize, $maxSize);
            $img->insert($border, 'center');

            // Simpan gambar yang sudah diedit
            $filename = 'edited_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $img->save(public_path('edited/' . $filename));

            // Tambahkan URL ke array file yang sudah diedit
            $editedFiles[] = asset('edited/' . $filename);
        }

        // Arahkan kembali ke halaman utama dengan link download untuk semua file yang diedit
        return redirect()->route('photo-editor.index')
            ->with('success', 'Photos have been successfully edited and saved.')
            ->with('editedFiles', $editedFiles); // Kirim array link hasil edit
    }
}
