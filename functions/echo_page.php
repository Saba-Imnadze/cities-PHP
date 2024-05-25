<?php
function echo_page($options)
{
    header('Content-Type: text/html');
    echo
    '<!DOCTYPE html>' .
    '<html lang="en">' .
    '<head>' .
    '<meta charset="UTF-8">' .
    '<meta name="viewport" content="width=device-width, initial-scale=1.0">' .
    '<title>' . $options['title'] . '</title>' .
    css_files() .
        '</head>' .
        '<body>' .
        $options['body'] .
        '</body>' .
        '</html>';
    exit;
}
