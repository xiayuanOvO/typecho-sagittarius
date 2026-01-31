<?php
$isCategory = $this->is('category');
$this->widget('Widget_Metas_Category_List')->to($category); 
?>

<div class="tab-list">
    <div class="tab-item<?php if (!$isCategory): ?> active<?php endif; ?>">
        <a href="<?php $this->options->siteUrl(); ?>">全部</a>  
    </div>
    <?php while ($category->next()): ?>
        <div class="tab-item<?php if ($isCategory && $this->getArchiveSlug() == $category->slug): ?> active<?php endif; ?>">
            <a href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a>
        </div>
    <?php endwhile; ?>
</div>