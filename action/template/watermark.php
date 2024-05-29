<?php

    $filename= '../' . $_GET['image']; // берем файл
    $src_im = imagecreatefromjpeg($filename); // создаем новый файл (без измены исходной)

    $thumb_width = 300;
    $thumb_height = 300;

    $width = imagesx($src_im);
    $height = imagesy($src_im);

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if ( $original_aspect >= $thumb_aspect )
    {
        // If image is wider than thumbnail (in aspect ratio sense)
        $new_height = $thumb_height;
        $new_width = $width / ($height / $thumb_height);
    }
    else
    {
        // If the thumbnail is wider than the image
        $new_width = $thumb_width;
        $new_height = $height / ($width / $thumb_width);
    }
    $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
    imagecopyresampled($thumb,
                   $src_im,
                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                   0, 0,
                   $new_width, $new_height,
                   $width, $height);

    // создаём водяной знак
    $stamp = imagecreatefrompng('images/watermark.png');

    // получаем значения высоты и ширины водяного знака
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // создаём jpg из оригинального изображения
    imagecopy($thumb, $stamp, imagesx($thumb) - $sx - $marge_right, imagesy($thumb) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

    // Output and free memory
    header('Content-type: image/png');
    imagepng($thumb);
    imagedestroy($thumb);
?>
