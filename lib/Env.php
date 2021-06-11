<?php
/**
 * Env
 * @project localhost
 * @copyright 院主网络科技
 * @author yuanzhumc
 * @version 1.0
 * @date: 2021/6/11
 * @createTime: 9:53
 * @filename Env.php
 * @product_name PhpStorm
 * @link https://github.com/yuanzhumc/localhost
 * @example
 *
 * @namespace ${NAMESPACE}
 */
namespace lib;

class Env
{
    const ENV_PREFIX = 'PHP_';

    /**
     * 加载配置文件
     * @param string $filePath 配置文件路径
     * @throws Exception
     */
    public static function loadFile(string $filePath='.env'):void
    {
        if (!file_exists($filePath)) throw new \Exception('配置文件' . $filePath . '不存在');
        //返回二位数组
        $env = parse_ini_file($filePath, true);
        foreach ($env as $key => $val) {
            $prefix = static::ENV_PREFIX . strtoupper($key);
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    $item = $prefix . '_' . strtoupper($k);
                    putenv("$item=$v");
                }
            } else {
                putenv("$prefix=$val");
            }
        }
    }

    /**
     * 获取环境变量值
     * @param string $name 环境变量名（支持二级 . 号分割）
     * @param null $default 默认值
     * @return array|bool|mixed|string|null
     */
    public static function get(string $name, $default = null)
    {
        $result = getenv(static::ENV_PREFIX . strtoupper(str_replace('.', '_', $name)));
        if (false !== $result) {
            if ('false' === $result) {
                $result = false;
            } elseif ('true' === $result) {
                $result = true;
            }
            return $result;
        }
        return $default;
    }
}