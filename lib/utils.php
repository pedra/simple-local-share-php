<?php

//Download de arquivo em modo PHAR (interno)
function download($reqst = '')
{
    //checando a existencia do arquivo solicitado
    if(!file_exists($reqst)) return false;

    //gerando header apropriado
    include ROOT . 'lib/mimetypes.php';
    $ext = end((explode('.', $reqst)));
    if (!isset($_mimes[$ext])) $mime = 'text/plain';
    else $mime = (is_array($_mimes[$ext])) ? $_mimes[$ext][0] : $_mimes[$ext];

    //get file
    $dt = file_get_contents($reqst);

    //download
    ob_end_clean();
    ob_start('ob_gzhandler');

    header('Vary: Accept-Language, Accept-Encoding');
    header('Content-Type: ' . $mime);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($reqst)) . ' GMT');
    header('Cache-Control: must_revalidate, public, max-age=31536000');
    header('Content-Length: ' . strlen($dt));
    header('Content-Disposition: attachment; filename='.basename($reqst));
    header('ETAG: '.md5($reqst));
    exit($dt);
}

//Loader for view
function view($name = 'body', $vars = [])
{
    if(file_exists(HTML.'/'.$name.'.html'))
        include HTML.'/'.$name.'.html';
}

// Directory scanner
function shareScan()
{
    $files = [];
    $sdir = scandir(SHAREDIR);

    foreach($sdir as $k=>$fn){
        if(substr($fn, 0, 1) == '.') continue;
        $files[$k]['name'] = $fn;
        $files[$k]['size'] = filesize(SHAREDIR.'/'.$fn);
    }
    return $files;
}