<header class="page-header" style="background-image: url(<?php echo getImageUrl($this->options->headerImage); ?>);">
    <div class="page-header__content">
        <div class="page-header__avatar">
            <img src="<?php echo htmlspecialchars(getAuthorAvatar($this->author->mail, $this->options)); ?>"
                alt="<?php echo htmlspecialchars($this->author->name); ?>">
            
        </div>
        <div class="page-header__title">
            <span><?php $this->options->title(); ?></span>
            <?php echo getSvg('gender-male', 'page-header__gender'); ?>
        </div>
        <div class="page-header__description"><?php $this->options->description(); ?></div>
    </div>
</header>