<?php
/**
 * ${NAME}
 * @project localhost
 * @copyright 院主网络科技
 * @author yuanzhumc
 * @version 1.0
 * @date: 2021/6/10
 * @createTime 11:37
 * @filename index.php
 * @product_name PhpStorm
 * @link https://github.com/yuanzhumc/localhost
 * @example
 */

/**
 * 获取已安装扩展列表
 */
function printExtensions()
{

    foreach (get_loaded_extensions() as $i => $name) {
        echo '<tr>';
        echo "<td>", $name,"</td>";
        echo "<td>",phpversion($name),"<td>";
        echo '</tr>';
    }
}
/**
 * 获取MongoDB版本
 */
function getMongoVersion()
{
    if (extension_loaded('mongodb')) {
        try {
            $manager = new MongoDB\Driver\Manager('mongodb://root:123456@mongodb:27017');
            $command = new MongoDB\Driver\Command(array('serverStatus'=>true));

            $cursor = $manager->executeCommand('admin', $command);

            return $cursor->toArray()[0]->version;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    } else {
        return 'MongoDB 扩展未安装 ×';
    }
}
/**
 * 获取Redis版本
 */
function getRedisVersion()
{
    if (extension_loaded('redis')) {
        try {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            $info = $redis->info();
            return $info['redis_version'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    } else {
        return 'Redis 扩展未安装 ×';
    }
}
/**
 * 获取MySQL版本
 */
function getMysqlVersion()
{
    if (extension_loaded('PDO_MYSQL')) {
        try {
            $dbh = new PDO('mysql:host=mysql;dbname=mysql', 'root', '123456');
            $sth = $dbh->query('SELECT VERSION() as version');
            $info = $sth->fetch();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $info['version'];
    } else {
        return 'PDO_MYSQL 扩展未安装 ×';
    }

}
?>

<fieldset class="layui-elem-field">
    <legend>服务器Os</legend>
    <div class="layui-field-box">
        <table class="layui-table">
            <tbody>
            <tr>
                <td>IP地址</td>
                <td><?php echo $_SERVER['SERVER_ADDR'];?></td>
            </tr>
            <tr>
                <td>域名</td>
                <td><?php echo $_SERVER['SERVER_NAME'];?></td>
            </tr>
            <tr>
                <td>端口</td>
                <td><?php echo $_SERVER['SERVER_PORT'];?></td>
            </tr>
            <tr>
                <td>版本</td>
                <td><?php echo PHP_OS .php_uname('r');?></td>
            </tr>
            <tr>
                <td>操作系统</td>
                <td><?php echo php_uname();?></td>
            </tr>
            <tr>
                <td>Http请求中Host值</td>
                <td><?php echo $_SERVER['HTTP_HOST'];?></td>
            </tr>
            <tr>
                <td>服务器当前时间</td>
                <td><?php echo date("Y-m-d H:i:s");?></td>
            </tr>
            <tr>
                <td>解译引擎</td>
                <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
            </tr>
            <tr>
                <td>CPU数量</td>
                <td><?php echo $_SERVER['PROCESSOR_IDENTIFIER'];?></td>
            </tr>
            <tr>
                <td>系统目录</td>
                <td><?php echo $_SERVER['SystemRoot'];?></td>
            </tr>
            <tr>
                <td>用户域名</td>
                <td><?php echo $_SERVER['USERDOMAIN'];?></td>
            </tr>
            <tr>
                <td>语言</td>
                <td><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];?></td>
            </tr>
            <tr>
                <td>Web端口</td>
                <td><?php echo $_SERVER['SERVER_PORT'];?></td>
            </tr>
            <tr>
                <td>请求页面时通信协议的名称和版本</td>
                <td><?php echo $_SERVER['SERVER_PROTOCOL'];?></td>
            </tr>
            </tbody>
        </table>
    </div>
</fieldset>
<fieldset class="layui-elem-field">
    <legend>PHP</legend>
    <div class="layui-field-box">
        <table class="layui-table">
            <tbody>
            <tr>
                <td>运行方式</td>
                <td><?php echo PHP_SAPI;?></td>
            </tr>
            <tr>
                <td>版本</td>
                <td><?php echo PHP_VERSION;?></td>
            </tr>
            <tr>
                <td>安装路径</td>
                <td><?php echo DEFAULT_INCLUDE_PATH;?></td>
            </tr>
            <tr>
                <td>当前文件绝对路径</td>
                <td><?php echo __FILE__;?></td>
            </tr>
            <tr>
                <td>版本</td>
                <td><?php echo PHP_VERSION;?></td>
            </tr>
            <tr>
                <td>Zend版本</td>
                <td><?php echo Zend_Version();?></td>
            </tr>
            <tr>
                <td>最大上传限制</td>
                <td><?php echo get_cfg_var("upload_max_filesize") ?: "不允许";?></td>
            </tr>
            <tr>
                <td>最大执行时间</td>
                <td><?php echo get_cfg_var("max_execution_time")."秒 ";?></td>
            </tr>
            <tr>
                <td>脚本运行占用最大内存</td>
                <td><?php echo get_cfg_var("memory_limit") ?: "无";?></td>
            </tr>
            <tr>
                <td>最大上传限制</td>
                <td><?php echo get_cfg_var("upload_max_filesize") ?: "不允许";?></td>
            </tr>
            <tr>
                <td>MySQL服务器版本</td>
                <td><?php echo getMysqlVersion(); ?></td>
            </tr>
            <tr>
                <td>Redis服务器版本</td>
                <td><?php echo getRedisVersion(); ?></td>
            </tr>
            <tr>
                <td>MongoDB服务器版本</td>
                <td><?php echo getMongoVersion(); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</fieldset>
<fieldset class="layui-elem-field">
    <legend>PHP-已安装扩展</legend>
    <div class="layui-field-box">
        <table class="layui-table">
            <thead>
            <tr>
                <th>扩展名称</th>
                <th>扩展版本</th>
            </tr>
            </thead>
            <tbody>
            <?php printExtensions(); ?>
            </tbody>
        </table>
    </div>
</fieldset>
