# 子比主题·演示插件

![License](https://img.shields.io/badge/license-GPL--3.0-orange) ![WordPress](https://img.shields.io/badge/WordPress-5.2+-blue) ![PHP](https://img.shields.io/badge/PHP-7.0+-purple)

这是一个为子比主题设计的WordPress功能扩展插件，提供自定义设置选项和扩展功能。适合开发者学习WordPress插件开发的基础结构。

## 功能特性

- 🎨 全站变灰模式（纪念日模式）
- 🔧 网站维护模式（自定义维护页面）
- 💳 支付类型限制功能
- 📝 文章底部版权信息
- 🖌️ 后台自定义CSS
- ⚙️ 基于CSF框架的友好设置界面

## 安装要求

- WordPress 5.2+
- PHP 7.0+
- 子比主题（推荐最新版）

## 安装方法

1. 下载插件zip包
2. 在WordPress后台 → 插件 → 安装插件 → 上传插件
3. 激活插件
4. 在"设置"菜单中找到"子比主题·演示插件"

## 使用教程

### 1. 获取菜单设置值

```php
// 获取单个选项值
$value = zibll_plugin_demo('option_name', 'default_value');

// 示例：获取禁止的支付类型
$prohibited = zibll_plugin_demo('prohibited_balance_pay_types', array());
```

### 2. 创建新菜单项

在插件主文件中添加：

```php
CSF::createSection($prefix, array(
    'id'     => 'your_section_id',
    'title'  => '你的菜单标题',
    'icon'   => 'fa fa-star',
    'fields' => array(
        // 在这里添加你的字段
    )
));
```

### 3. 添加新字段类型

支持的基础字段类型：

```php
array(
    'id'    => 'text_field',
    'type'  => 'text',
    'title' => '文本字段'
),

array(
    'id'    => 'switcher_field',
    'type'  => 'switcher',
    'title' => '开关字段'
),

array(
    'id'    => 'textarea_field',
    'type'  => 'textarea',
    'title' => '多行文本'
),

array(
    'id'    => 'code_field',
    'type'  => 'code',
    'title' => '代码编辑器'
)
```

## 开发指南

### 1. 文件结构

```
zibll-plugin-demo/
├── includes/
│   ├── functions.php       # 核心功能实现
│   └── admin-options.php   # 管理菜单设置
├── index.php               # 主插件文件
└── README.md               # 说明文档
```

### 2. 添加新功能

1. 在`admin-options.php`中添加新的设置字段
2. 在`functions.php`中实现功能逻辑
3. 使用`zibll_plugin_demo()`函数获取设置值

### 3. 常用钩子

```php
// 在文章内容后添加内容
add_filter('the_content', 'your_function');

// 在网站头部添加代码
add_action('wp_head', 'your_function');

// 在后台头部添加代码
add_action('admin_head', 'your_function');
```

## 示例代码

### 1. 全站变灰功能实现

```php
function zibll_site_greyscale() {
    if (zibll_plugin_demo('site_greyscale')) {
        echo '<style>html{filter:grayscale(100%);}</style>';
    }
}
add_action('wp_head', 'zibll_site_greyscale');
```

### 2. 维护模式实现

```php
function zibll_maintenance_mode() {
    if (zibll_plugin_demo('maintenance_mode') && !current_user_can('administrator')) {
        $title = zibll_plugin_demo('maintenance_title', '网站维护中');
        $content = zibll_plugin_demo('maintenance_content', '请稍后再访问');
        
        wp_die($content, $title, array('response' => 503));
    }
}
add_action('wp', 'zibll_maintenance_mode');
```

## 常见问题

**Q: 插件设置不生效怎么办？**
A: 请检查：
1. 插件是否已激活
2. 是否清除了缓存
3. 主题是否兼容

**Q: 如何修改菜单图标？**
A: 使用FontAwesome图标名称，如：
```php
'icon' => 'fa fa-cog'
```

**Q: 如何添加新的设置选项卡？**
A: 复制现有的`createSection`代码块，修改ID和标题即可。

## 贡献指南

欢迎提交Pull Request或Issue报告问题。

## 版权信息

子比主题·演示插件 © 2023 李初一，基于GPL-3.0协议发布。

---

📧 联系作者: [82719519@qq.com](mailto:82719519@qq.com)  
🌐 官方网站: [https://www.vxras.com](https://www.vxras.com)
