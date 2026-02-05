<?php
if ($this->is('index') || $this->is('category')) {
    $avatar = $this->options->headerAvatarUrl;
    // 判断是否有@符号
    if (strpos($avatar, '@') !== false) {
        $avatar = getAuthorAvatar($avatar, $this->options);
    } else {
        $avatar = getImageUrl($avatar);
    }
} else if ($this->is('post')) {
    $avatar = getAuthorAvatar($this->author->mail, $this->options);
}

$gender = $this->options->headerGender;
?>
<header class="site__header" style="background-image: url(<?php echo getImageUrl($this->options->headerImage); ?>);">
    <div class="header__content">
        <div class="header__logo">
            <img src="<?php echo htmlspecialchars($avatar); ?>"
                alt="<?php echo htmlspecialchars($this->author->name); ?>">
        </div>
        <div class="header__title">
            <span><?php $this->options->title(); ?></span>
            <?php if ($gender != 'none'): ?>
                <?php echo getSvg('gender-' . $gender, 'header__gender'); ?>
            <?php endif; ?>
        </div>
        <div class="header__description"><?php $this->options->description(); ?></div>
    </div>
</header>