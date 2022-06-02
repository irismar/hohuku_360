<? echo "eu sou imob";
///$exif = exif_read_data('foto1.jpg', 'IFD0');

$exif = exif_read_data('foto1.jpg', 0, true);

foreach ($exif as $key => $section) {
    foreach ($section as $name => $val) {
        echo "$key.$name: $val<br />\n";
    }
}
?>