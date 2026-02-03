<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php'); ?>

<div class="site__wrapper">
    <?php $this->need('components/header.php'); ?>
    <main class="site__content">
        <?php $this->need('components/sidebar.php'); ?>
        <div class="site__main">
            <div class="post-header">
                <div class="post-header__back">
                    <?php echo getSvg('left', 'back__icon'); ?>
                    <a class="back__link" href="<?php $this->options->siteUrl(); ?>">返回</a>
                </div>
                <h1 class="post-header__title"><?php $this->title(); ?></h1>
            </div>
            <?php $this->need('components/article.php'); ?>
            <?php $this->need('comments.php'); ?>
        </div>
    </main>
</div>

<?php $this->need('footer.php'); ?>

<script>
    window.sagittarius.initPost();
</script>