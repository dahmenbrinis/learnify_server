<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    public function view($image)
    {
        $image = Image::find($image);
        if (!isset($image) || !Storage::disk('images')->has($image->src)) {
            $alt = str_replace(" ", "+", $image->alt ?? 'J D');
            $path = "https://ui-avatars.com/api?name=$alt&background=random&bold=true&format=svg";
            return $this->svg2Image($path);
        }
        $path = Storage::disk('images')->path($image->src);
        return Response()->download($path);
    }

    public function Store(StoreImageRequest $request)
    {
        if ($request->file('image')->isFile())
            $path = $request->file('image')->store('/', 'images');
        return Image::create(
            $request->safe()->except('image') +
            ['src' => $path ?? null, 'user_id' => auth()->id()]
        );
    }

    private function svg2Image(string $path)
    {
        $svg = file_get_contents($path);
        file_put_contents('test.svg', $svg);
        return response()->download('test.svg');
    }
}
