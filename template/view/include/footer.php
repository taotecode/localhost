<?php
/**
 * ${NAME}
 * @project localhost
 * @copyright 院主网络科技
 * @author yuanzhumc
 * @version 1.0
 * @date: 2021/6/9
 * @createTime 17:12
 * @filename footer.php
 * @product_name PhpStorm
 * @link https://github.com/yuanzhumc/localhost
 * @example
 */

use lib\Env;
Env::loadFile();

?>
</div>

<div class="layui-footer">
    <!-- 底部固定区域 -->
    2021-<?php echo date('Y')?> <?php echo Env::get('config.footer','yuanzhumc');?>
</div>
</div>
<script type="text/javascript">
    layui.use(['element'], function() {
        var element = layui.element;
        element.init();
    });
</script>
</body>
</html>
