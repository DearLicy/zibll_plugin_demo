<?php
/**
 * 子比主题·演示插件 - 后台菜单设置
 * 
 * 本文件使用CSF框架创建插件后台管理菜单
 * 每个设置项都包含详细注释，适合新手学习
 */

// 安全检测 - 防止直接访问文件
if (!defined('ABSPATH')) {
    die('禁止直接访问'); // 如果未通过WordPress环境访问，终止执行并显示提示
}

// 检查CSF框架是否可用（子比主题的设置框架）
if (class_exists('CSF')) {

    /**
     * ============================================
     * 1. 设置选项前缀
     * ============================================
     * 
     * 这个前缀用于：
     * - 区分不同插件的设置项
     * - 存储在数据库中的选项名称前缀
     * - 所有字段ID的前缀
     */
    $prefix = 'zibll_plugin_demo';

    /**
     * ============================================
     * 2. 创建主设置面板
     * ============================================
     * 
     * 这会在WordPress后台左侧菜单添加一个新项目
     * 参数说明：
     * 
     * @param string $prefix 选项前缀
     * @param array $settings 面板设置数组
     */
    CSF::createOptions($prefix, array(
        'menu_title' => '子比主题·演示插件', // 显示在后台菜单中的名称
        'menu_slug' => 'zibll_plugin_demo',  // 菜单唯一标识符（用于URL）
        'framework_title' => '子比主题·演示插件 <small>v1.0</small>', // 面板顶部显示的大标题
        'show_in_customizer' => true, // 是否在WordPress自定义器中显示（true/false）
        'footer_text' => '由李初一开发的子比主题·演示插件', // 面板底部显示的文字
        'footer_credit' => '<i class="fa fa-heart" style="color:#ff4757"></i> 感谢使用', // 底部版权信息（支持HTML）
        'theme' => 'light', // 界面主题颜色（light/dark）
    ));

    /**
     * ============================================
     * 3. 创建"核心功能"设置部分
     * ============================================
     * 
     * 这是第一个设置选项卡，包含插件主要功能设置
     */
    CSF::createSection($prefix, array(
        'id' => 'core_settings', // 部分唯一ID（不能重复）
        'title' => '核心功能', // 选项卡标题
        'icon' => 'fa fa-cube', // 选项卡图标（FontAwesome）
        
        // 字段设置数组
        'fields' => array(
            
            /**
             * 3.1 支付限制设置（复选框）
             * 
             * 允许用户选择哪些支付场景禁止使用余额
             */
            array(
                'id' => 'prohibited_balance_pay_types', // 字段ID（必须唯一）
                'type' => 'checkbox', // 字段类型（多选框）
                'title' => '禁止使用余额支付的类型', // 字段标题
                'subtitle' => '勾选不允许使用余额支付的场景', // 字段说明
                
                // 可选项配置（值 => 显示文本）
                'options' => array(
                    '1' => '付费阅读',
                    '2' => '付费资源',
                    '3' => '产品购买',
                    '4' => '购买会员',
                    '5' => '付费图片',
                    '6' => '付费视频',
                    '7' => '自动售卡',
                    '8' => '余额充值',
                    '9' => '购买积分',
                ),
                
                'default' => array('8'), // 默认选中的选项（数组格式）
                'help' => '防止用户用余额购买余额的套娃行为', // 鼠标悬停提示
            ),
            
            /**
             * 3.2 幽默提示信息（条件显示）
             * 
             * 当用户选择"余额充值"选项时显示
             */
            array(
                'type' => 'submessage', // 特殊字段类型：提示信息
                'style' => 'danger', // 样式风格（danger/warning/success等）
                'content' => '<div style="padding:10px;background:#fff8f8;border-left:3px solid #ff4757">
                    <b>⚠️ 注意</b>
                    <p>你已禁止使用余额进行余额充值，这是明智的选择！</p>
                    <p>否则用户可以用余额购买余额，形成无限套娃...</p>
                </div>', // 显示内容（支持HTML）
                
                // 显示条件：当"余额充值"被选中时显示
                'dependency' => array('prohibited_balance_pay_types', '==', '8'),
            ),
            
            /**
             * 3.3 文章版权设置（开关+文本）
             * 
             * 控制是否在文章底部显示版权信息
             */
            array(
                'id' => 'show_copyright', // 字段ID
                'type' => 'switcher', // 字段类型（开关）
                'title' => '文章版权信息', // 字段标题
                'label' => '在文章底部显示版权信息', // 开关标签
                'default' => false, // 默认状态（false=关闭）
            ),
            
            // 版权文字设置（依赖上面的开关）
            array(
                'id' => 'copyright_text', // 字段ID
                'type' => 'text', // 字段类型（单行文本）
                'title' => '版权文字内容', // 字段标题
                'dependency' => array('show_copyright', '==', '1'), // 依赖关系
                'default' => '本文来自子比主题演示插件', // 默认值
                'placeholder' => '输入要显示的版权信息', // 占位文本
                'validate' => 'wp_kses_post', // 内容过滤（允许基本的HTML标签）
            ),
        )
    ));

    /**
     * ============================================
     * 4. 创建"外观设置"部分
     * ============================================
     * 
     * 第二个设置选项卡，控制网站外观相关设置
     */
    CSF::createSection($prefix, array(
        'id' => 'appearance', // 部分唯一ID
        'title' => '外观设置', // 选项卡标题
        'icon' => 'fa fa-paint-brush', // 选项卡图标
        
        'fields' => array(
            /**
             * 4.1 全站变灰模式（开关）
             * 
             * 控制是否启用全站灰度效果
             */
            array(
                'id' => 'site_greyscale', // 字段ID
                'type' => 'switcher', // 字段类型
                'title' => '全站变灰模式', // 字段标题
                'label' => '特殊日期开启全站灰色效果', // 开关标签
                'default' => false, // 默认状态
                'help' => '适用于纪念日等特殊场景', // 帮助提示
            ),
            
            /**
             * 4.2 后台自定义CSS（代码编辑器）
             * 
             * 允许用户自定义WordPress后台样式
             */
            array(
                'id' => 'admin_css', // 字段ID
                'type' => 'code_editor', // 字段类型（代码编辑器）
                'title' => '后台自定义CSS', // 字段标题
                'subtitle' => '修改WordPress后台样式', // 副标题
                
                // 编辑器设置
                'settings' => array(
                    'theme' => 'dracula', // 编辑器主题
                    'mode' => 'css', // 语法模式（css/javascript/html等）
                    'tabSize' => 4, // 缩进大小
                ),
                
                'default' => '/* 在这里添加CSS代码 */', // 默认内容
                'sanitize' => 'wp_strip_all_tags', // 内容过滤（去除所有HTML标签）
            ),
            
            /**
             * 4.3 警告提示（条件显示）
             * 
             * 当用户输入CSS代码时显示警告
             */
            array(
                'type' => 'submessage', // 提示信息类型
                'style' => 'warning', // 警告样式
                'content' => '<div style="padding:10px;background:#fff8e1;border-left:3px solid #ffc107">
                    <b><i class="fa fa-exclamation-triangle"></i> 重要提示</b>
                    <p>1. 修改前建议备份当前CSS</p>
                    <p>2. 错误的CSS可能导致后台显示异常</p>
                </div>', // 提示内容
                
                // 当CSS字段有内容时显示
                'dependency' => array('admin_css', '!=', ''),
            ),
        )
    ));
}