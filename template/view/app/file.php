<?php
/**
 * ${NAME}
 * @project localhost
 * @copyright 院主网络科技
 * @author yuanzhumc
 * @version 1.0
 * @date: 2021/6/10
 * @createTime 13:14
 * @filename file.php
 * @product_name PhpStorm
 * @link https://github.com/yuanzhumc/localhost
 * @example
 */

function tree($directory)
{
    $mydir = dir($directory);
    echo "<ul>";
    while ($file = $mydir->read()) {
        if ((is_dir("$directory/$file")) and ($file != ".") and ($file != "..")) {
            echo '<li style="color="#ff00cc""><a href="index.php?app=app/file&file=/'.$file.'/">'.$file.'</a></font></li>';
            tree("$directory/$file");
        } else
            echo "<li>$file</li>";
    }
    echo "</ul>";
    $mydir->close();
}

//start the program

echo "目录为粉红色";
tree($_GET['file']?:"/");
?>

