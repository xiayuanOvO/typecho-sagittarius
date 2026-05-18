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
    // logo
    addText($form, 'logo', '/assets/images/logo.png', 'logo 图片 URL', '/assets/images/logo.png');

    // 导航栏显示设置
    addCheckbox($form, 'navDisplay', array(
        'showLogo' => _t('显示 Logo'),
        'showTitle' => _t('显示标题'),
    ), array('showLogo', 'showTitle'), '导航栏显示', '选择在导航栏中显示的元素');

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

    // ================================ 友链页设置 ================================
    addTitle($form, '友链页设置');
    addSubTitle($form, '仅在使用「友链」自定义模板的独立页中生效');
    addText($form, 'friendLinks', '', '友链列表', '每行一条，格式：名称|链接 或 名称|链接|描述。例如：<br>博客A|https://example.com|一个博客<br>博客B|https://b.com');

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
 * 引入后台管理样式文件
 */
function setStyle()
{
?>
    <link rel="stylesheet" href="<?php echo Helper::options()->themeUrl; ?>/assets/css/admin.css">
<?php
}

/**
 * 设置脚本
 * 引入后台管理脚本文件
 */
function setScript()
{
?>
    <script src="<?php echo Helper::options()->themeUrl; ?>/assets/js/admin.js"></script>
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
 * 解析主题配置中的友链列表，供友链独立页使用
 * 格式：每行一条，名称|链接 或 名称|链接|描述
 *
 * @return array 元素为 ['name' => string, 'url' => string, 'desc' => string]
 */
function getFriendLinks()
{
    $options = Helper::options();
    $raw = $options->friendLinks;
    if (empty($raw) || !is_string($raw)) {
        return array();
    }
    $lines = array_filter(array_map('trim', explode("\n", $raw)));
    $list = array();
    foreach ($lines as $line) {
        $parts = array_map('trim', explode('|', $line, 3));
        if (count($parts) >= 2 && $parts[0] !== '' && $parts[1] !== '') {
            $list[] = array(
                'name'  => $parts[0],
                'url'   => $parts[1],
                'desc'  => isset($parts[2]) ? $parts[2] : '',
            );
        }
    }
    return $list;
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
        <div class="comment__view">
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
                <div class="comment__actions" data-author="<?php echo $author; ?>" data-coid="<?php echo $coid; ?>"
                    data-html-id="">
                    <button class="comment__reply" type="button" data-coid="<?php echo $coid; ?>" data-author="<?php echo $author; ?>"><?php _e('回复'); ?></button>
                </div>
                <?php if ($comments->children) { ?>
                    <div class="comment__children">
                        <?php $comments->threadedComments($options); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </li>
<?php }


/**
 * 获取点赞数
 */
function getAgreeNum($archive)
{
    $db = Typecho_Db::get();
    $field = $db->fetchRow($db->select('str_value')->from('table.fields')->where('cid = ?', $archive->cid)->where('name = ?', 'agree'));
    return $field ? $field['str_value'] : 0;
}

/**
 * 输出浏览量（单篇文章页面自动计数，Cookie 防重复）
 */
function viewsNum($widget)
{
    $db = Typecho_Db::get();
    $cid = intval($widget->cid);

    $field = $db->fetchRow(
        $db->select('str_value')->from('table.fields')
            ->where('cid = ?', $cid)->where('name = ?', 'views')
    );
    $views = $field ? intval($field['str_value']) : 0;

    if ($widget->is('single')) {
        $vieweds = \Typecho\Cookie::get('contents_viewed');
        $vieweds = empty($vieweds) ? [] : explode(',', $vieweds);

        if (!in_array(strval($cid), $vieweds)) {
            $views++;
            if (!$field) {
                $db->query($db->insert('table.fields')->rows([
                    'cid' => $cid, 'name' => 'views', 'type' => 'str',
                    'str_value' => strval($views),
                    'int_value' => 0, 'float_value' => 0,
                ]));
            } else {
                $db->query(
                    $db->update('table.fields')
                        ->rows(['str_value' => strval($views)])
                        ->where('cid = ?', $cid)->where('name = ?', 'views')
                );
            }
            $vieweds[] = strval($cid);
            \Typecho\Cookie::set('contents_viewed', implode(',', $vieweds));
        }
    }

    echo $views;
}

/**
 * 获取评论接口 URL（根相对路径，避免跨域）
 *
 * @return string
 */
function getCommentsUrl()
{
    $root = rtrim(str_replace('\\', '/', realpath(__TYPECHO_ROOT_DIR__)), '/');
    $path = $root . '/usr/themes/' . Helper::options()->theme . '/action/comments.php';
    $docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
    return substr($path, strlen($docRoot));
}

/**
 * 获取点赞接口 URL（根相对路径，避免跨域）
 *
 * @return string
 */
function getLikeUrl()
{
    $root = rtrim(str_replace('\\', '/', realpath(__TYPECHO_ROOT_DIR__)), '/');
    $themeDir = $root . '/usr/themes/' . Helper::options()->theme . '/action/like.php';
    $docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
    return substr($themeDir, strlen($docRoot));
}
