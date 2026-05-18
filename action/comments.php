<?php

/**
 * 评论 AJAX 接口
 *
 * GET /usr/themes/fuck/action/comments.php?cid=<文章ID>
 * Response: HTML 片段
 */

$config = dirname(dirname(dirname(dirname(__DIR__)))) . '/config.inc.php';
if (!file_exists($config)) {
    http_response_code(500);
    exit('Config not found');
}
require_once $config;

$db = \Typecho\Db::get();
$options = \Typecho\Widget::widget('Widget_Options');

$cid = isset($_REQUEST['cid']) ? (int)$_REQUEST['cid'] : 0;
if ($cid <= 0) {
    exit('Invalid cid');
}

// 获取文章信息用于构建评论提交地址
$content = $db->fetchRow(
    $db->select('slug', 'type')->from('table.contents')->where('cid = ?', $cid)
);
if (!$content) {
    exit('Content not found');
}

// 根据类型计算路径
$path = $content['type'] === 'page' ? '/' . $content['slug'] . '.html' : '/archives/' . $content['slug'] . '.html';

// 获取最新 5 条已审核评论
$comments = $db->fetchAll(
    $db->select()->from('table.comments')
        ->where('cid = ?', $cid)
        ->where('status = ?', 'approved')
        ->order('table.comments.created', \Typecho\Db::SORT_DESC)
        ->limit(5)
);
// 按时间正序
$comments = array_reverse($comments);

// 构建评论提交 URL（路由格式：{permalink}/{type}）
$commentUrl = $options->siteUrl . ltrim($path, '/') . '/comment';

// 头像源
$avatarSource = $options->avatarUrl ?: 'v2ex';

function getInlineAvatar($mail, $source) {
    $md5 = md5($mail ?: '');
    if ($source == 'loli') {
        return 'https://gravatar.loli.net/avatar/' . $md5 . '?s=64&r=X';
    } elseif ($source == 'gravatar') {
        return 'https://gravatar.com/avatar/' . $md5 . '?s=64&r=X';
    }
    return 'https://cdn.v2ex.com/gravatar/' . $md5 . '?s=64&r=X';
}

function getInlineTime($timestamp) {
    $diff = time() - $timestamp;
    if ($diff < 60) return '刚刚';
    if ($diff < 3600) return floor($diff / 60) . '分钟前';
    if ($diff < 86400) return floor($diff / 3600) . '小时前';
    if ($diff < 2592000) return floor($diff / 86400) . '天前';
    return date('Y-m-d H:i', $timestamp);
}

?>
<div class="inline-comments__list">
    <?php if (empty($comments)): ?>
        <div class="inline-comments__empty">暂无评论，来说两句吧</div>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <div class="inline-comment__item">
                <img class="inline-comment__avatar"
                    src="<?php echo htmlspecialchars(getInlineAvatar($comment['mail'], $avatarSource)); ?>"
                    alt="<?php echo htmlspecialchars($comment['author']); ?>">
                <div class="inline-comment__content">
                    <div class="inline-comment__meta">
                        <span class="inline-comment__author"><?php echo htmlspecialchars($comment['author']); ?></span>
                        <span class="inline-comment__time" time="<?php echo $comment['created']; ?>"><?php echo getInlineTime($comment['created']); ?></span>
                    </div>
                    <div class="inline-comment__text"><?php echo $comment['text']; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<form class="inline-comments__form" method="post" action="<?php echo $commentUrl; ?>">
    <div class="inline-comments__input-wrap">
        <textarea class="inline-comments__textarea" name="text" placeholder="写评论..." rows="1" required></textarea>
        <input type="hidden" name="cid" value="<?php echo $cid; ?>">
        <input type="hidden" name="parent" value="">
        <input type="text" name="author" class="inline-comments__hidden" placeholder="称呼" autocomplete="name">
        <input type="email" name="mail" class="inline-comments__hidden" placeholder="Email" autocomplete="email">
    </div>
    <button class="inline-comments__submit" type="submit">发送</button>
</form>
