<div class="tab-list">
    <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>

    <div class="tab-item active">
        <a href="<?php $this->options->siteUrl(); ?>">全部</a>
    </div>
    <?php while ($category->next()): ?>
        <div class="tab-item">
            <a href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a>
        </div>
    <?php endwhile; ?>
</div>