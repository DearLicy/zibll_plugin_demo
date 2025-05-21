<?php

/**
 * 1. 支付限制功能实现
 * 
 * 通过过滤器修改支付权限
 */
function zibll_filter_balance_pay($allow, $pay_type) {
    $prohibited = zibll_plugin_demo('prohibited_balance_pay_types', array());
    if (in_array($pay_type, $prohibited)) {
        return false;
    }
    return $allow;
}
add_filter('zibpay_is_allow_balance_pay', 'zibll_filter_balance_pay', 10, 2);

/**
 * 2. 文章版权功能实现
 * 
 * 在文章内容底部添加版权信息
 */
function zibll_add_copyright($content) {
    if (is_single() && zibll_plugin_demo('show_copyright')) {
        $text = zibll_plugin_demo('copyright_text', '本文来自子比主题演示插件');
        $content .= '<div class="zibll-copyright" style="margin-top:20px;padding:10px;border-top:1px dashed #ddd;color:#888;">'
                  . esc_html($text) . '</div>';
    }
    return $content;
}
add_filter('the_content', 'zibll_add_copyright', 99);

/**
 * 3. 全站变灰功能实现
 * 
 * 在网站头部插入CSS样式
 */
function zibll_site_greyscale() {
    if (zibll_plugin_demo('site_greyscale')) {
        echo '<style>html{filter:grayscale(100%);transition:all .3s;}</style>';
    }
}
add_action('wp_head', 'zibll_site_greyscale', 99);

/**
 * 4. 后台自定义CSS实现
 * 
 * 在后台头部插入用户自定义的CSS
 */
function zibll_admin_custom_css() {
    $css = zibll_plugin_demo('admin_css');
    if ($css && !empty(trim($css))) {
        echo '<style>' . wp_strip_all_tags($css) . '</style>';
    }
}
add_action('admin_head', 'zibll_admin_custom_css', 99);