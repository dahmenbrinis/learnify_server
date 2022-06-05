<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;


class ImageController extends Controller
{

    public function view($image, $alt)
    {
        $image = Image::find($image);
        if (!(isset($image) && Storage::disk('images')->has($image->src)))
            return $this->svg2Image($alt ?? "J D");
        $path = Storage::disk('images')->path($image->src);
        return Response()->file($path);
    }

    public function Store(StoreImageRequest $request)
    {
        $path = $request->file('image')->store('/', 'images');
        ray($request->safe());
        $image =  Image::query()->updateOrcreate(
            $request->safe()->except(['image','alt']),
            ['src' => $path, 'user_id' => auth()->id()]
            );
        return $image ;
    }

    private function svg2Image(string $name)
    {

        $avatar = new InitialAvatar();
        return $avatar->name($name)
            ->background('#EAF2FA')
            ->color('#0096FF')
            ->size(200)
            ->generate()->response();
    }
}
