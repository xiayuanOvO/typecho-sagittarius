<?php

/**
 * 这是typecho系统的一套默认皮肤。你可以在<a href="http://typecho.org">typecho的官方网站</a>获得更多关于此皮肤的信息
 * 
 * @package Fuck Theme 
 * @author 夏源
 * @version 1.0.0
 * @link https://github.com/xiayuanOvO
 */
// 引入 dump 
require_once dirname(__FILE__, 4) . '/vendor/autoload.php';
$this->need('header.php');
?>
<div class="page-container">
    <header class="page-header" style="background-image: url(<?php echo $this->options->headerImage; ?>);">

    </header>
    <main class="page-main">
        <?php $this->need('components/sidebar.php'); ?>
        <div class="page-content">
            <?php $this->need('components/tabs.php'); ?>
            <div class="post-list">
                <?php while ($this->next()): ?>
                    <div class="post-item">
                        <div class="post__sidebar">
                            <a class="author__avatar" href="<?php $this->author->permalink(); ?>"
                                title="<?php $this->author(); ?>">
                                <img src="<?php echo htmlspecialchars(getAuthorAvatar($this->author->mail, $this->options)); ?>"
                                    alt="<?php echo htmlspecialchars($this->author->name); ?>">
                            </a>
                        </div>
                        <div class="post__main">
                            <div class="post__meta">
                                <div class="meta__name">
                                    <?php $this->author(); ?>
                                </div>
                                <div class="meta__date" time="<?php echo $this->created; ?>">
                                    <?php echo $this->date('Y-m-d H:i'); ?>
                                </div>
                            </div>
                            <div class="post__content">
                                <?php $this->excerpt(80, '...'); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div id="load-indicator" class="load-indicator">
                <span class="load-indicator__text" next-link="<?php $this->pageLink('', 'next'); ?>">加载中...</span>
                <?php $this->pageLink('', 'next'); ?>
            </div>
        </div>
    </main>
</div>

<?php $this->need('footer.php'); ?>

<script>
    // 格式化时间
    document.querySelectorAll('.meta__date').forEach(el => {
        const time = parseInt(el.getAttribute('time'));

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
            text = new Intl.DateTimeFormat('zh-CN', {
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
    // 加载下一页内容（下一页链接存储在 load-indicator 内）
    document.addEventListener('DOMContentLoaded', function () {        
        const listContainer = document.querySelector('.post-list');
        const indicator = document.querySelector('#load-indicator');

        let isLoading = false;

        const loadPosts = () => {
            // 从 load-indicator 内获取下一页链接
            const nextLink = indicator.querySelector('a.next');
            if (!nextLink || isLoading) return;

            isLoading = true;
            const nextUrl = nextLink.href;

            fetch(nextUrl)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // 提取并追加文章
                    const newPosts = doc.querySelectorAll('.post-list .post-item');
                    newPosts.forEach(post => listContainer.appendChild(post));

                    // 从新页面的 load-indicator 更新下一页链接
                    const newIndicator = doc.querySelector('#load-indicator');
                    const newNextLink = newIndicator ? newIndicator.querySelector('a.next') : null;
                    if (newNextLink) {
                        indicator.innerHTML = newIndicator.innerHTML;
                    } else {
                        indicator.innerHTML = '<span>全部加载完毕</span>';
                        observer.unobserve(indicator);
                    }

                    isLoading = false;
                })
                .catch(err => {
                    console.error('加载异常:', err);
                    isLoading = false;
                });
        };

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                loadPosts();
            }
        }, {
            rootMargin: '10px',
            threshold: 0
        });

        if (indicator) {
            const nextLink = indicator.querySelector('a.next');
            if (!nextLink) {
                indicator.innerHTML = '<span>全部加载完毕</span>';
            } else {
                observer.observe(indicator);
            }
        }
    });
</script>