<article class="post__item">
    <!-- 文章侧边栏 -->
    <div class="post__sidebar">
        <a class="post__avatar" href="<?php $this->author->permalink(); ?>" title="<?php $this->author(); ?>">
            <img loading="lazy"
                src="<?php echo htmlspecialchars(getAuthorAvatar($this->author->mail, $this->options)); ?>"
                alt="<?php echo htmlspecialchars($this->author->name); ?>">
        </a>
    </div>
    <div class="post__main">
        <div class="post__meta">
            <div class="meta__name">
                <?php $this->author(); ?>
            </div>
            <a class="meta__date" href="<?php $this->permalink(); ?>" time="<?php echo $this->created; ?>">
                <?php echo $this->date('Y-m-d H:i'); ?>
            </a>
        </div>
        <div class="post__content">
            <?php $this->content(); ?>
        </div>
    </div>
</article>