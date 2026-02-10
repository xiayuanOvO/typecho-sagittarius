<?php
/**
 * 友情链接模板
 *
 * @package custom
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
$friendLinks = getFriendLinks();
?>

<div class="site__wrapper">
    <?php $this->need('components/header.php'); ?>
    <main class="site__content">
        <?php $this->need('components/sidebar.php'); ?>
        <div class="site__main">
            <div class="post__header">
                <div class="post__back">
                    <?php echo getSvg('left', 'back__icon'); ?>
                    <a class="back__link" href="<?php $this->options->siteUrl(); ?>">返回</a>
                </div>
                <h1 class="post__title"><?php $this->title(); ?></h1>
            </div>

            <div class="links-page">
                <?php if (trim($this->content) !== ''): ?>
                <div class="links-page__intro post__item">
                    <div class="post__main" style="width:100%;">
                        <div class="post__content">
                            <?php $this->content(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="links-list">
                    <?php foreach ($friendLinks as $link): ?>
                    <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank" rel="noopener noreferrer" class="links-item">
                        <span class="links-item__icon"><?php echo getSvg('link'); ?></span>
                        <div class="links-item__main">
                            <span class="links-item__name"><?php echo htmlspecialchars($link['name']); ?></span>
                            <?php if ($link['desc'] !== ''): ?>
                            <span class="links-item__desc"><?php echo htmlspecialchars($link['desc']); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>

                <?php if (empty($friendLinks)): ?>
                <div class="links-empty post__item">
                    <div class="post__main" style="width:100%;">
                        <div class="post__content" style="color:var(--color-gray-1);">
                            暂无友链，请在主题设置中填写「友链列表」。
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php $this->need('components/comments.php'); ?>
        </div>
    </main>
</div>

<?php $this->need('footer.php'); ?>
