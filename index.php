<?php

/**
 * 这是一款 Typecho 主题，模仿微博风格。
 * 
 * @package Sagittarius Theme 
 * @author 夏源
 * @version 0.1.0
 * @link https://gitee.com/xiayuanOvO/typecho-sagittarius
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="site__wrapper">
    <?php $this->need('components/header.php'); ?>
    <main class="site__content">
        <?php $this->need('components/sidebar.php'); ?>
        <div class="site__main">
            <?php $this->need('components/tabs.php'); ?>
            <div class="post__list">
                <?php while ($this->next()): ?>
                    <div class="post__item">
                        <!-- 文章侧边栏 -->
                        <div class="post__sidebar">
                            <a class="post__avatar" href="<?php $this->author->permalink(); ?>"
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
document.addEventListener('DOMContentLoaded', function () {
    window.sagittarius.initIndex();
});
</script>