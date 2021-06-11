<?php
/**
 * ${NAME}
 * @project aix
 * @copyright
 * @author chenjw
 * @version
 * @date: 2021/6/10
 * @createTime 11:37
 * @filename index.php
 * @product_name PhpStorm
 * @link
 * @example
 */
?>
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
                <td>操作系统</td>
                <td><?php echo PHP_OS;?></td>
            </tr>
            </tbody>
        </table>
    </div>
</fieldset>