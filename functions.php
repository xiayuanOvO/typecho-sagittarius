<?php

/**
 * 主题配置
 * 
 * @param Typecho_Widget_Helper_Form $form
 * @return void
 */
function themeConfig($form)
{
    // setConfigLayoutHeader();

    // ================================ 全局设置 ================================
    addTitle($form, '全局设置');

    // 头像源
    addSelect($form, 'avatarUrl', array(
        'v2ex' => _t('v2ex'),
        'loli' => _t('loli'),
        'gravatar' => _t('gravatar')
    ), 'v2ex', '头像源', '');

    // 背景模式
    addSelect($form, 'bgMode', array(
        'image' => _t('图片模式'),
        'color' => _t('纯色模式')
    ), 'color', '背景模式', '切换后，下方会自动显示对应的输入框');

    // 背景图片地址
    addText($form, 'bgImage', '/assets/images/bg.jpg', '背景图片 URL', '/assets/images/bg.jpg');

    // 背景颜色代码
    addText($form, 'bgColor', '#f0f0f0', '背景颜色代码', '请输入 Hex 颜色值，例如 #f0f0f0');

    // ================================ 主页设置 ================================
    addTitle($form, '主页设置');

    // 性别
    addSelect($form, 'headerGender', array(
        'male' => _t('男'),
        'female' => _t('女'),
        'none' => _t('不显示'),
    ), 'male', '性别', '');

    // 卡片头像链接
    addText($form, 'headerAvatarUrl', 'example@example.com', '卡片头像链接', '输入图片链接或者邮箱地址，如果是邮箱地址，会使用头像源获取。');

    // 头部图片
    addText($form, 'headerImage', '/assets/images/card-bg.jpg', '卡片背景图片链接', '默认：/assets/images/card-bg.jpg');

    // 侧边栏统计
    addCheckbox($form, 'sidebarStat', array(
        'posts' => _t('文章总数'),
        'comments' => _t('评论总数'),
        'tags' => _t('标签总数'),
        'categories' => _t('分类总数'),
    ), array('posts', 'comments', 'tags'), '侧边栏统计', '勾选后，会在侧边栏显示统计数据（推荐勾选3个）');

    // 侧边栏资料
    addCheckbox($form, 'sidebarInfo', array(
        'hometown' => _t('家乡'),
        'email' => _t('邮箱'),
        'birthday' => _t('生日'),
        'intro' => _t('简介'),
        'links' => _t('链接'),
    ), array('hometown', 'email', 'birthday', 'intro', 'links'), '侧边栏资料', '勾选后，会在侧边栏显示资料');

    // 邮箱
    addText($form, 'email', NULL, '邮箱', '');
    // 家乡
    addText($form, 'hometown', NULL, '家乡', '');
    // 生日
    addText($form, 'birthday', NULL, '生日', '');
    // 简介
    addText($form, 'intro', NULL, '简介', '');
    // 链接
    addText($form, 'links', NULL, '链接', '');

    // 侧边栏最近评论
    addCheckbox($form, 'sidebarRecentComments', array(
        'comments' => _t('最近评论'),
    ), array('comments'), '侧边栏最近评论', '勾选后，会在侧边栏显示最近评论');

    // 侧边栏最近评论数量
    addText($form, 'sidebarRecentCommentsNum', 5, '侧边栏最近评论数量', '侧边栏最近评论数量，默认为5');

    // setConfigLayoutFooter();
    setStyle();
    setScript();
}

/**
 * 按邮箱获取头像 URL，同邮箱只计算一次
 *
 * @param string $mail 作者邮箱
 * @param mixed $options 主题选项（含 avatarUrl）
 * @return string 头像 URL
 */
function getAuthorAvatar($mail, $options)
{
    static $cache = [];
    if (isset($cache[$mail])) {
        return $cache[$mail];
    }
    $avatarUrl = $options->avatarUrl;
    if ($avatarUrl == 'loli') {
        $url = 'https://gravatar.loli.net/avatar/' . md5($mail) . '?s=128&r=X';
    } else if ($avatarUrl == 'gravatar') {
        $url = 'https://gravatar.com/avatar/' . md5($mail) . '?s=128&r=X';
    } else {
        $url = 'https://cdn.v2ex.com/gravatar/' . md5($mail) . '?s=128&r=X';
    }
    $cache[$mail] = $url;
    return $url;
}

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
            position: sticky;
            top: 200px;
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
                    // 提交
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        // submitBtn.innerText = "正在保存...";
                        // submitBtn.style.opacity = "0.7";
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
 * @param \Typecho\Widget\Helper\Form $form 表单对象
 * @param string $title 标题文字
 */
function addTitle($form, $title = '')
{
    $layout = new \Typecho\Widget\Helper\Layout('h2');
    $layout->html(_t($title));
    $form->addItem($layout);
}

/**
 * 添加子标题
 * 
 * @param \Typecho\Widget\Helper\Form $form 表单对象
 * @param string $title 标题文字
 */
function addSubTitle($form, $title = '')
{
    $layout = new \Typecho\Widget\Helper\Layout('h3');
    $layout->html(_t($title));
    $form->addItem($layout);
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
        _t($title),
        _t($description)
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
function addText($form, $name = '', $default = '', $title = '', $description = '')
{
    $form->addInput(new Typecho_Widget_Helper_Form_Element_Text(
        $name,
        null,
        $default,
        _t($title),
        _t($description)
    ));
}

/**
 * 添加复选框
 * 
 * @param Typecho_Widget_Helper_Form $form 表单对象
 * @param string $name 字段名
 * @param array $options 选项数组 [value => label]
 * @param array $default 默认值(注意是数组)
 * @param string $title 标题
 * @param string $description 描述
 */
function addCheckbox($form, $name = '', $options = [], $default = '', $title = '', $description = '')
{
    $form->addInput(new Typecho_Widget_Helper_Form_Element_Checkbox(
        $name,
        $options,
        $default,
        _t($title),
        _t($description)
    ));
}

/**
 * 获取 SVG 文件内容
 * 
 * @param string $name SVG 文件名
 * @param string $class SVG 类名
 * @return string SVG 文件内容
 */
function getSvg($name, $class = '')
{
    $file = dirname(__FILE__) . '/assets/icons/' . $name . '.svg';
    if (file_exists($file)) {
        $content = file_get_contents($file);
        // 如果传入了 class，则注入到 svg 标签中
        if ($class) {
            $content = str_replace('<svg', '<svg class="' . $class . '"', $content);
        }
        return $content;
    }
    return '';
}

/**
 * 获取图片 URL
 * @param string $path 原始路径字符串
 * @return string 图片 URL
 */
function getImageUrl($path)
{
    $path = (string) $path; // 防止空值
    if (preg_match('/^https?:\/\/|^\/\//i', $path)) {
        return $path;
    }
    $options = Helper::options();
    if (strpos($path, 'usr/uploads/') === 0) {
        return $options->siteUrl($path);
    }
    return $options->themeUrl($path);
}

/**
 * 获取文章内容中的所有图片
 * 
 * @param string $content 文章内容
 * @return array 图片列表
 */
function getAllImages($content)
{
    $imgList = array();

    preg_match_all("/<img.*?src=\"(.*?)\".*?>/i", $content, $matches);
    if (isset($matches[1])) {
        $imgList = $matches[1];
    }
    return $imgList;
}
/**
 * 嵌套评论
 * @param mixed $comments
 * @param mixed $options
 * @return void
 */
function threadedComments($comments, $options)
{
    $coid = $comments->coid;
    $htmlId = $comments->theId();
    $author = htmlspecialchars($comments->author);
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';  // 博主评论样式
        } else {
            $commentClass .= ' comment-by-user';    // 注册用户样式
        }
    }

    ?>
    <li id="li-<?php $comments->theId(); ?>" class="comment__item<?php
      if ($comments->levels > 0) {
          echo ' child';
          $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
      } else {
          echo ' parent';
      }
      $comments->alt(' comment-odd', ' comment-even');
      echo $commentClass;
      ?>">
        <div id="<?php $comments->theId(); ?>" class="comment__view">
            <img class="comment__avatar" src="<?php echo htmlspecialchars(getAuthorAvatar($comments->mail, $options)); ?>"
                alt="<?php echo $author; ?>">
            <div class="comment__content">
                <div class="comment__meta">
                    <div class="comment__author"><?php echo $author; ?></div>
                    <div class="meta__date" time="<?php echo $comments->created; ?>"><?php $comments->date('Y-m-d H:i'); ?>
                    </div>
                </div>
                <div class="comment__text">
                    <?php $comments->text(); ?>
                </div>
                <div class="comment__actions" data-author="<?php echo $author; ?>" data-coid="<?php echo $coid; ?>" data-html-id="<?php echo $htmlId; ?>">
                    <button class="comment__reply" type="button" onclick="replyComment(<?php echo $coid; ?>, '<?php echo $author; ?>');"><?php _e('回复'); ?></button>
                </div>
            </div>
        </div>

        <?php if ($comments->children) { ?>
            <div class="comment__children">
                <?php $comments->threadedComments($options); ?>
            </div>
        <?php } ?>
    </li>
<?php } ?>