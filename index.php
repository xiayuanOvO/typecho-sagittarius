<?php

/**
 * 这是一款 Typecho 主题，模仿微博风格。
 * 
 * @package Sagittarius Theme 
 * @author 夏源
 * @version 0.0.1
 * @link https://gitee.com/xiayuanOvO/typecho-sagittarius
 */
// 引入 dump 
// require_once dirname(__FILE__, 4) . '/vendor/autoload.php';
$this->need('header.php');
?>

<div class="page-container">
    <?php $this->need('components/header.php'); ?>
    <main class="page-main">
        <?php $this->need('components/sidebar.php'); ?>
        <div class="page-content">
            <?php $this->need('components/tabs.php'); ?>
            <div class="post-list">
                <?php while ($this->next()): ?>
                    <div class="post-item">
                        <!-- 文章侧边栏 -->
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
                                <a class="meta__date" href="<?php $this->permalink(); ?>"
                                    time="<?php echo $this->created; ?>">
                                    <?php echo $this->date('Y-m-d H:i'); ?>
                                </a>
                            </div>
                            <div class="post__content">
                                <a href="<?php $this->permalink(); ?>">
                                <?php $this->excerpt(120, '...'); ?>
                                </a>
                                <div class="post__images">
                                    <?php
                                    $images = getAllImages(content: $this->content);
                                    if ($images):
                                        foreach ($images as $image):
                                            if (count($images) > 9) {
                                                break;
                                            }
                                            echo '<img class="post__image" loading="lazy" src="' . $image . '" alt="' . $this->title . '">';
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div id="load-indicator" class="load-indicator">
                <span class="load-indicator__text"></span>
                <?php $this->pageLink('', 'next'); ?>
            </div>
        </div>
    </main>
</div>

<?php $this->need('footer.php'); ?>

<script>
    window.sagittarius.formatDate();
    // 加载下一页内容
    document.addEventListener('DOMContentLoaded', function () {
        const listContainer = document.querySelector('.post-list');
        const indicator = document.querySelector('#load-indicator');

        let isLoading = false;

        const loadPosts = () => {
            // 从 load-indicator 内获取下一页链接
            const nextLink = indicator.querySelector('a.next');
            if (!nextLink || isLoading) return;

            isLoading = true;
            indicator.querySelector('.load-indicator__text').textContent = '加载中...';
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
                })
                .catch(err => {
                    console.error('加载异常:', err);
                }).finally(() => {
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
                indicator.innerHTML = '';
            } else {
                observer.observe(indicator);
            }
        }
    });
</script>