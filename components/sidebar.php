<?php
$stat = Typecho_Widget::widget('Widget\Stat');
?>
<aside class="page-sidebar">
    <!-- 统计 -->
    <?php if (!empty($this->options->sidebarStat)): ?>
        <div class="stat-list">
            <?php if (in_array('posts', $this->options->sidebarStat)): ?>
                <div class="stat-item">
                    <div class="stat-item__value"><?php echo $stat->publishedPostsNum(); ?></div>
                    <div class="stat-item__label">文章</div>
                </div>
            <?php endif; ?>
            <?php if (in_array('comments', $this->options->sidebarStat)): ?>
                <div class="stat-item">
                    <div class="stat-item__value"><?php echo $stat->publishedCommentsNum(); ?></div>
                    <div class="stat-item__label">评论</div>
                </div>
            <?php endif; ?>
            <?php if (in_array('tags', $this->options->sidebarStat)): ?>
                <div class="stat-item">
                    <div class="stat-item__value"><?php echo $stat->tagsNum(); ?></div>
                    <div class="stat-item__label">标签</div>
                </div>
            <?php endif; ?>
            <?php if (in_array('categories', $this->options->sidebarStat)): ?>
                <div class="stat-item">
                    <div class="stat-item__value"><?php echo $stat->categoriesNum(); ?></div>
                    <div class="stat-item__label">分类</div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <!-- 资料 -->
    <?php if (!empty($this->options->sidebarInfo)): ?>
        <div class="info-list">
            <!-- 家乡 -->
            <?php if (in_array('hometown', $this->options->sidebarInfo)): ?>
                <div class="info-item">
                    <div class="info-item__icon">
                        <?php echo getSvg('hometown'); ?>
                    </div>
                    <div class="info-item__label">家乡：</div>
                    <div class="info-item__value"><?php echo $this->options->hometown; ?></div>
                </div>
            <?php endif; ?>

            <!-- 邮箱 -->
            <?php if (in_array('email', $this->options->sidebarInfo)): ?>
                <div class="info-item">
                    <div class="info-item__icon">
                        <?php echo getSvg('mail'); ?>
                    </div>
                    <div class="info-item__label">邮箱：</div>
                    <a href="mailto:<?php echo $this->options->email; ?>"
                        class="info-item__value"><?php echo $this->options->email; ?></a>
                </div>
            <?php endif; ?>

            <!-- 生日 -->
            <?php if (in_array('birthday', $this->options->sidebarInfo)): ?>
                <div class="info-item">
                    <div class="info-item__icon">
                        <?php echo getSvg('cake'); ?>
                    </div>
                    <div class="info-item__label">生日：</div>
                    <div class="info-item__value"><?php echo $this->options->birthday; ?></div>
                </div>
            <?php endif; ?>

            <!-- 简介 -->
            <?php if (in_array('intro', $this->options->sidebarInfo)): ?>
                <div class="info-item">
                    <div class="info-item__icon">
                        <?php echo getSvg('message'); ?>
                    </div>
                    <div class="info-item__label">简介：</div>
                    <div class="info-item__value"><?php echo $this->options->intro; ?></div>
                </div>
            <?php endif; ?>

            <!-- 链接 -->
            <?php if (in_array('links', $this->options->sidebarInfo)): ?>
                <div class="info-item">
                    <div class="info-item__icon">
                        <?php echo getSvg('link'); ?>
                    </div>
                    <a href="<?php echo $this->options->links; ?>" target="_blank" class="info-item__value"><?php echo $this->options->links; ?></a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</aside>