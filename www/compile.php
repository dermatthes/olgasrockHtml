<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 22.07.14
 * Time: 16:31
 *
 *
 * Search for <!-- PHP-COMP-INCLUDE: ./fileName --><!-- /PHP-COMP-INCLUDE --> and includes
 * the file
 *
 */


foreach (glob("*.html") as $fileName) {
    echo "\nProcessing file: $fileName... ";
    $input = file_get_contents($fileName);
    $replaced = 0;
    $input = preg_replace_callback('/\<\!\-\- PHP\-COMP\-INCLUDE\:(.*?)\-\-\>(.*?)\<\!\-\- \/PHP\-COMP\-INCLUDE \-\-\>/ims', function ($matches) use ($fileName, &$replaced) {
        if ( ! file_exists(trim ($matches[1])))
            throw new Exception("Cannot replace fileName: {$matches[1]} in file $fileName");
        $replaced++;
        return ("<!-- PHP-COMP-INCLUDE:{$matches[1]}-->" . file_get_contents(trim ($matches[1])) . "<!-- /PHP-COMP-INCLUDE -->");
    }, $input);

    if ($replaced == 0) {
        echo "No tags replaced!";
        continue;
    }
    echo " {$replaced} Ersetzungen. [OK]";
    file_put_contents($fileName, $input);
}
echo "\nFinish!\n";