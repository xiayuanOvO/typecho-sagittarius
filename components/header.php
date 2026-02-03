<header class="site__header" style="background-image: url(<?php echo getImageUrl($this->options->headerImage); ?>);">
    <div class="header__content">
        <div class="header__logo">
            <img src="<?php echo htmlspecialchars(getAuthorAvatar($this->author->mail, $this->options)); ?>"
                alt="<?php echo htmlspecialchars($this->author->name); ?>">
            
        </div>
        <div class="header__title">
            <span><?php $this->options->title(); ?></span>
            <?php echo getSvg('gender-male', 'header__gender'); ?>
        </div>
        <div class="header__description"><?php $this->options->description(); ?></div>
    </div>
</header>