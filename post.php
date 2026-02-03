<?php $this->need('header.php'); ?>

<div class="page-container">
    <?php $this->need('components/header.php'); ?>
    <main class="page-main">
        <?php $this->need('components/sidebar.php'); ?>
        <div class="page-content">
            <div class="post__header">
                <div class="header__back">
                    <?php echo getSvg('left', 'back__icon'); ?>
                    <a class="back__link" href="<?php $this->options->siteUrl(); ?>">返回</a>
                </div>
                <span class="header__title"><?php $this->title(); ?></span>
            </div>
            <?php $this->need('components/article.php'); ?>
            <?php $this->need('comments.php'); ?>
        </div>
    </main>
</div>

<?php $this->need('footer.php'); ?>

<script>
    window.sagittarius.formatDate();
</script>