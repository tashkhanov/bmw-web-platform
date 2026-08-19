<?php

$test_file = 'images/images/wallpapers/test.txt';
$result = file_put_contents($test_file, 'test');
if ($result !== false) {
    echo 'Write successful. ';
    if (unlink($test_file)) {
        echo 'File deleted.';
    } else {
        echo 'But could not delete file.';
    }
} else {
    echo 'Write failed. Check permissions for directory: ' . dirname($test_file);
    echo ' Current working directory: ' . getcwd();
    echo ' Directory exists: ' . (file_exists(dirname($test_file)) ? 'yes' : 'no');
    echo ' Is writable: ' . (is_writable(dirname($test_file)) ? 'yes' : 'no');
}