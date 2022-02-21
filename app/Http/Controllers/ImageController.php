<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    public function getImage(String $file) {
//        dd(array_rand([0=>'biology.png', 1=>'math.png', 2=>'computer_science.png']));
        $path =Storage::disk('images')->path("default.png");
        if (Storage::disk('images')->has($file))
        $path = Storage::disk('images')->path($file);
        return Response()->download($path);

    }

    public function getImage2() {
        return phpinfo();
    }
}
