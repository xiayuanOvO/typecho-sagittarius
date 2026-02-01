<header class="page-header" style="background-image: url(<?php echo $this->options->headerImage; ?>);">
    <div class="page-header__content">
        <div class="page-header__avatar">
            <img src="<?php echo htmlspecialchars(getAuthorAvatar($this->author->mail, $this->options)); ?>"
                alt="<?php echo htmlspecialchars($this->author->name); ?>">
        </div>
        <div class="page-header__title"><?php $this->options->title(); ?></div>
        <div class="page-header__description"><?php $this->options->description(); ?></div>
    </div>
</header>