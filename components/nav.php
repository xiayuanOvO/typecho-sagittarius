<nav class="site__nav">
    <!-- 左侧：Logo + Title -->
    <div class="site__nav__left">
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
    </div>
    
    <!-- 右侧：分类、友链、关于 -->
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

        <!-- 友链 -->
        <div class="site__nav__item">
            <a href="#links">
                <span class="site__nav__item__text">友链</span>
            </a>
        </div>

        <!-- 关于 -->
        <div class="site__nav__item">
            <a href="#about">
                <span class="site__nav__item__text">关于</span>
            </a>
        </div>
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
        
        <div class="site__nav__mobile-item">
            <a href="#links">友链</a>
        </div>
        
        <div class="site__nav__mobile-item">
            <a href="#about">关于</a>
        </div>
    </div>
</nav>