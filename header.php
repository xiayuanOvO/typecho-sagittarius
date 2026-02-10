<!DOCTYPE html>
<html lang="<?php echo $this->options->language; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php $this->archiveTitle([
                'category' => _t('分类 %s 下的文章'),
                'search' => _t('包含关键字 %s 的文章'),
                'tag' => _t('标签 %s 下的文章'),
                'author' => _t('%s 发布的文章')
            ], '', ' - '); ?><?php $this->options->title(); ?></title>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('main.min.css'); ?>">
    <script src="<?php $this->options->themeUrl('app.min.js'); ?>"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper@4.5.1/dist/css/swiper.min.css">
</head>
<?php if ($this->options->bgMode == 'image'): ?>
<body style="background-image: url(<?php echo getImageUrl($this->options->bgImage ?? ''); ?>);">
<?php else: ?>
<body style="background-color: <?php echo $this->options->bgColor ?? '#FFFFFF'; ?>;">
<?php endif; ?>
<?php $this->need('components/nav.php'); ?>