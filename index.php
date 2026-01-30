<?php
/**
 * 这是typecho系统的一套默认皮肤。你可以在<a href="http://typecho.org">typecho的官方网站</a>获得更多关于此皮肤的信息
 * 
 * @package Fuck Theme 
 * @author 夏源
 * @version 1.0.0
 * @link https://github.com/xiayuanOvO
 */
$this->need('header.php');
?>

<?php
// 将头像转为MD5
$avatarUrl = $this->options->avatarUrl;

if ($avatarUrl == 'loli') {
    $gravatarUrl = 'https://gravatar.loli.net/avatar/' . md5($this->author->mail) . '?s=128&r=X';
} else if ($avatarUrl == 'gravatar') {
    $gravatarUrl = $this->author->gravatar(128);
} else {
    $gravatarUrl = 'https://cdn.v2ex.com/gravatar/' . md5($this->author->mail) . '?s=128&r=X';
}
?>

<div class="main-container">
    <?php $this->need('components/tabs.php'); ?>
    <div class="post-list">
        <?php while ($this->next()): ?>
            <div class="post-item">
                <div class="post__sidebar">
                    <a class="author__avatar" href="<?php $this->author->permalink(); ?>" title="<?php $this->author(); ?>">
                        <!-- 头像源 -->
                        <?php if ($avatarUrl == 'gravatar'): ?>
                            <?php echo $this->author->gravatar(128); ?>
                        <?php else: ?>
                            <img src="<?php echo $gravatarUrl; ?>" alt="<?php echo $this->author->name; ?>">
                        <?php endif; ?>
                    </a>
                </div>
                <div class="post__main">
                    <div class="post__meta">
                        <div class="meta__name"><?php $this->author(); ?></div>
                        <div class="meta__date" time="<?php echo $this->created; ?>">
                            <?php echo $this->date('Y-m-d H:i'); ?>
                        </div>
                    </div>
                    <div class="post__content">
                        <?php $this->excerpt(50, '...'); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php $this->need('footer.php'); ?>

<script>
    document.querySelectorAll('.meta__date').forEach(el => {
        const time = parseInt(el.getAttribute('time'));
        console.log(time);

        const now = Math.floor(Date.now() / 1000);
        const diff = now - time;

        let text;
        if (diff < 60) {
            text = '刚刚';
        } else if (diff < 3600) {
            // 小于1小时
            text = Math.floor(diff / 60) + '分钟前';
        } else if (diff < 86400) {
            // 小于24小时
            text = Math.floor(diff / 3600) + '小时前';
        } else if (diff < 2592000) {
            // 大于1天，小于30天
            text = Math.floor(diff / 86400) + '天前';
        } else {
            const date = new Date(time * 1000);
            const text = new Intl.DateTimeFormat('zh-CN', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false // 强制使用24小时制，避免出现上午/下午
            }).format(date).replace(/\//g, '-').replace(/\s+/, ' ');
        }

        el.innerText = text;
    });
</script>