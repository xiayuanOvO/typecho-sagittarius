<nav class="site__nav">
    <!-- 左侧：Logo + Title -->
    <a class="site__nav__left" href="<?php $this->options->siteUrl(); ?>">
        <?php if (in_array('showLogo', $this->options->navDisplay)): ?>
            <div class="site__nav__logo">
                <img src="<?php echo getImageUrl($this->options->logo); ?>" alt="logo" />
            </div>
        <?php endif; ?>
        
        <?php if (in_array('showTitle', $this->options->navDisplay)): ?>
            <div class="site__nav__title">
                <?php $this->options->title(); ?>
            </div>
        <?php endif; ?>
    </a>
    
    <!-- 右侧：分类、独立页列表 -->
    <div class="site__nav__right">
        <!-- 分类（带悬浮菜单） -->
        <div class="site__nav__item site__nav__item--dropdown">
            <a href="javascript:void(0)" class="site__nav__dropdown-toggle">
                <span class="site__nav__item__text">分类</span>
            </a>
            <div class="site__nav__dropdown-menu">
                <?php $categories = Typecho_Widget::widget('Widget_Metas_Category_List'); ?>
                <?php while ($categories->next()): ?>
                    <a href="<?php $categories->permalink(); ?>" class="site__nav__dropdown-item<?php if ($this->is('category') && $this->getArchiveSlug() == $categories->slug): ?> active<?php endif; ?>">
                        <?php $categories->name(); ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- 独立页列表 -->
        <?php $pages = Typecho_Widget::widget('Widget_Contents_Page_List'); ?>
        <?php while ($pages->next()): ?>
        <div class="site__nav__item">
            <a href="<?php $pages->permalink(); ?>"<?php if ($this->is('page') && $this->cid == $pages->cid): ?> class="active"<?php endif; ?>>
                <span class="site__nav__item__text"><?php $pages->title(); ?></span>
            </a>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- 移动端菜单按钮 -->
    <div class="site__nav__mobile-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- 移动端菜单 -->
    <div class="site__nav__mobile-menu">
        <div class="site__nav__mobile-item">
            <span class="site__nav__mobile-label">分类</span>
        </div>
        <?php $categories = Typecho_Widget::widget('Widget_Metas_Category_List'); ?>
        <?php while ($categories->next()): ?>
            <div class="site__nav__mobile-item<?php if ($this->is('category') && $this->getArchiveSlug() == $categories->slug): ?> active<?php endif; ?>">
                <a href="<?php $categories->permalink(); ?>"><?php $categories->name(); ?></a>
            </div>
        <?php endwhile; ?>
        
        <?php $pages = Typecho_Widget::widget('Widget_Contents_Page_List'); ?>
        <?php while ($pages->next()): ?>
        <div class="site__nav__mobile-item<?php if ($this->is('page') && $this->cid == $pages->cid): ?> active<?php endif; ?>">
            <a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
        </div>
        <?php endwhile; ?>
    </div>
</nav>