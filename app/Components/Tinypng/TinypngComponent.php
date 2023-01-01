<?php

namespace App\Components\Tinypng;

use Tinify\Tinify;


class TinypngComponent extends Tinify
{
    public $tinify;
    public $source;
    public $fileName;

    /**
     * @param  string  $key
     */
    public function __construct($image)
    {
        $this->tinify = new Tinify();
        $this->tinify->setKey(env('TINY_KEY'));
        $this->source = \Tinify\fromFile($image); //compressing image
    }

    public function optimizeImage()
    {
        $this->source = $this->source->resize([
            "method" => "cover",
            "width" => 70,
            "height" => 70,
        ])->convert([
            "type" => "image/jpeg",
        ]);

        return $this->source;
    }

    public function fileName()
    {
        $this->fileName = time() . '.' . $this->source->result()->extension();

        return $this->fileName;
    }

}
