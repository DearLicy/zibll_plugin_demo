<?php
/**
 * Plugin Name: 子比主题·演示插件
 * Plugin URI: https://www.vxras.com/
 * Description: 这是一个为子比主题设计的WordPress功能扩展插件，提供自定义设置选项和扩展功能。适合新手学习WordPress插件开发的基础结构。
 * Version: 1.0.0
 * Author: 李初一
 * Author URI: https://www.vxras.com/
 */

//
// 插件基本信息头注释 - WordPress通过这部分识别插件
// 
// Plugin Name: 子比主题·演示插件      // 插件名称，显示在WordPress后台插件列表
// Plugin URI: https://www.vxras.com/  // 插件官方网址
// Description: 子比主题定制插件       // 简短描述，说明插件功能
// Version: 1.0.0                      // 插件版本号，遵循语义化版本规范
// Author: 李初一                      // 插件作者名字
// Author URI: https://www.vxras.com/  // 作者个人网站
//

// 安全检测 - 防止直接访问此文件
if (!defined('ABSPATH')) {
    exit; // 如果未通过WordPress环境访问，则退出
}

/**
 * 定义插件常量 - 方便在插件其他文件中使用
 * 
 * zibll_plugin_demo_url  - 插件URL地址，用于加载CSS/JS等资源
 * zibll_plugin_demo_path - 插件服务器路径，用于包含其他PHP文件
 */
define('zibll_plugin_demo_url', plugins_url('', __FILE__));
define('zibll_plugin_demo_path', plugin_dir_path(__FILE__));

/**
 * 获取插件选项的辅助函数
 * 
 * @param string $option  需要获取的选项名称
 * @param mixed $default  默认值(当选项不存在时返回)
 * @return mixed          返回选项值或默认值
 * 
 * 使用示例: 
 * $value = zibll_plugin_demo('option_name', 'default_value');
 */
if (!function_exists('zibll_plugin_demo')) {
    function zibll_plugin_demo($option = '', $default = null) {
        // 从WordPress选项表中获取本插件的所有设置
        $options = get_option('zibll_plugin_demo');
        
        // 检查请求的选项是否存在，不存在则返回默认值
        return (isset($options[$option])) ? $options[$option] : $default;
    }
}

/**
 * 插件初始化函数 - 在主题加载完成后执行
 * 
 * 主要职责:
 * 1. 检查CSF框架(子比主题的设置框架)是否可用
 * 2. 如果不可用，则加载插件自带的必要文件
 */
function zibll_plugin_demo_init() {
    // 需要加载的文件列表
    $require_once = array(
        'includes/functions.php',     // 插件核心功能文件
        'includes/admin-options.php', // 后台管理界面和设置选项
    );

    // 循环加载所有必要文件
    foreach ($require_once as $require) {
        // 使用plugin_dir_path构建完整文件路径并引入
        require_once plugin_dir_path(__FILE__) . $require;
    }
}
// 将初始化函数挂载到'after_setup_theme'钩子
// 这个钩子在主题加载完成后触发，确保主题功能可用
add_action('after_setup_theme', 'zibll_plugin_demo_init');