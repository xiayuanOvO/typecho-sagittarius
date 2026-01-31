<?php

// 设置配置布局头部结构（预留）
function setConfigLayoutHeader()
{
    ?>

    <div class="config-content">
        <?php
}

// 设置配置布局尾部结构（预留）
function setConfigLayoutFooter()
{
    ?>

    </div>
    <?php
}

/**
 * 主题配置
 * 
 * @param Typecho_Widget_Helper_Form $form
 * @return void
 */
function themeConfig($form)
{
    // setConfigLayoutHeader();
    addTitle('全局设置');

    // 头像源
    addSelect($form, 'avatarUrl', array(
        'v2ex' => _t('v2ex'),
        'loli' => _t('loli'),
        'gravatar' => _t('gravatar')
    ), 'v2ex', _t('头像源'), NULL);

    // 背景模式
    addSelect($form, 'bgMode', array(
        'image' => _t('图片模式'),
        'color' => _t('纯色模式')
    ), 'image', _t('背景模式'), _t('切换后，下方会自动显示对应的输入框'));

    // 背景图片地址
    addText($form, 'bgImage', NULL, _t('背景图片 URL'), _t('完整路径，包括 http:// 或 https://'));

    // 背景颜色代码
    addText($form, 'bgColor', '#FFFFFF', _t('背景颜色代码'), _t('请输入 Hex 颜色值，例如 #f0f0f0'));

    // setConfigLayoutFooter();
    setStyle();
    setScript();
}


/**
 * 设置样式
 */
function setStyle()
{
    ?>
    <style>
        .typecho-page-main {
            flex-wrap: nowrap;
            justify-content: space-between;
        }

        .typecho-page-main h2 {
            border-bottom: 2px solid #467b96;
            padding-bottom: 10px;
            margin-top: 40px;
            color: #467b96;
        }

        /* 侧边栏容器 */
        .config-sidebar {
            min-width: 120px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            min-height: 120px;
            height: min-content;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .config-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .config-sidebar li {
            margin-bottom: 8px;
        }

        .config-sidebar a {
            text-decoration: none;
            color: #666;
            font-size: 14px;
            display: block;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .config-sidebar a:hover {
            background-color: #f3f3f3;
            color: #467b96;
        }

        .config-sidebar a.active {
            background-color: #467b96;
            color: #fff;
            font-weight: bold;
        }
    </style>
    <?php
}

/**
 * 设置脚本
 */
function setScript()
{
    ?>
    <script>
        window.onload = function () {
            var main = document.querySelector('.typecho-page-main');
            console.log(main);

            if (main) {
                var sidebar = document.createElement('div');
                sidebar.className = 'config-sidebar';
                sidebar.innerHTML = '<ul id="config-nav"></ul>';
                main.appendChild(sidebar);
            }


            // 背景模式切换
            var selector = document.getElementsByName('bgMode')[0];
            var imgContainer = document.getElementsByName('bgImage')[0]?.closest('li');
            var colorContainer = document.getElementsByName('bgColor')[0]?.closest('li');
            function updateVisibility() {
                if (!selector) return;
                if (selector.value === 'image') {
                    if (imgContainer) imgContainer.style.display = '';
                    if (colorContainer) colorContainer.style.display = 'none';
                } else {
                    if (imgContainer) imgContainer.style.display = 'none';
                    if (colorContainer) colorContainer.style.display = '';
                }
            }
            if (selector) selector.onchange = updateVisibility;
            updateVisibility();

            // 侧边栏
            const nav = document.getElementById('config-nav');
            const headers = document.querySelectorAll('.typecho-page-main h2');

            headers.forEach((header, index) => {
                const id = 'section-' + index;
                header.setAttribute('id', id);

                const li = document.createElement('li');
                li.innerHTML = `<a href="#${id}">${header.innerText}</a>`;
                li.onclick = (e) => {
                    e.preventDefault();
                    header.scrollIntoView({ behavior: 'smooth' });
                };
                nav.appendChild(li);
            });

            // 快捷键保存
            document.addEventListener('keydown', function (e) {
                if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
                    e.preventDefault();

                    // 1. 找到 Typecho 的提交按钮
                    // Typecho 默认的提交按钮通常是 type="submit"
                    const submitBtn = document.querySelector('button[type="submit"]');

                    if (submitBtn) {
                        // 2. 视觉反馈：改变按钮文字或状态，让用户知道正在保存
                        // submitBtn.innerText = "正在保存...";
                        // submitBtn.style.opacity = "0.7";

                        // 3. 触发点击保存
                        submitBtn.click();
                    }
                }
            });
        };
    </script>
    <?php
}

/**
 * 添加标题
 * 
 * @param string $title 标题
 */
function addTitle($title = '')
{
    ?>
    <h2><?php echo $title; ?></h2>
    <?php
}

/**
 * 添加选择框
 * 
 * @param Typecho_Widget_Helper_Form $form 表单对象
 * @param string $name 字段名
 * @param array $options 选项数组
 * @param string $default 默认值
 * @param string $title 标题
 * @param string $description 描述
 */
function addSelect($form, $name = '', $options = [], $default = '', $title = '', $description = '')
{
    $form->addInput(new Typecho_Widget_Helper_Form_Element_Select(
        $name,
        $options,
        $default,
        $title,
        $description
    ));
}

/**
 * 添加文本框
 * 
 * @param Typecho_Widget_Helper_Form $form 表单对象
 * @param string $name 字段名
 * @param string $default 默认值
 * @param string $title 标题
 * @param string $description 描述
 */
function addText($form, $name = '', $default = '', $title = '', $description = '') {
    $form->addInput(new Typecho_Widget_Helper_Form_Element_Text(
        $name,
        null,   // options，Text 输入框不需要，需与 Element 构造函数第 2 参数 ?array 一致
        $default,
        $title,
        $description
    ));
}