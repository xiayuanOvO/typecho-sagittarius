<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$comments = $this->comments();
?>
<div class="comment__wrapper">
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <?php $formClass = $this->user->hasLogin() ? 'login' : 'guest'; ?>
            <form class="comment__form <?php echo $formClass; ?>" method="post" action="<?php $this->commentUrl() ?>"
                role="form" data-action="<?php echo $this->commentUrl(); ?>">
                <div class="comment__form__content">
                    <?php if ($this->user->hasLogin()): ?>
                        <a href="<?php $this->options->profileUrl(); ?>">
                            <img class="comment__avatar"
                                src="<?php echo htmlspecialchars(getAuthorAvatar($this->user->mail, $this->options)); ?>"
                                alt="<?php echo htmlspecialchars($this->user->screenName()); ?>">
                        </a>
                    <?php else: ?>
                        <div class="comment__input__list">
                            <div class="comment__input__item">
                                <?php echo getSvg('user'); ?>
                                <input type="text" name="author" class="text" placeholder="称呼"
                                    value="<?php $this->remember('author'); ?>" required />
                            </div>
                            <div class="comment__input__item">
                                <?php echo getSvg('mail'); ?>
                                <input type="email" name="mail" class="text" placeholder="Email"
                                    value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?>required
                                <?php endif; ?> />
                            </div>
                            <div class="comment__input__item">
                                <?php echo getSvg('link'); ?>
                                <input type="url" name="url" class="text" placeholder="http://"
                                    value="<?php $this->remember('url'); ?>" />
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="comment__textarea__wrapper">
                        <textarea class="comment__textarea" name="text" placeholder="在这里输入您的评论" required
                            rows="1"><?php $this->remember('text'); ?></textarea>    
                        <div class="comment__textarea__tip"></div>
                    </div>
                </div>
                <div class="comment__login__footer">
                    <button class="comment__cancel" type="button">取消回复</button>
                    <button class="comment__submit" type="submit">提交评论</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <p><?php _t('评论已关闭'); ?></p>
    <?php endif; ?>

    <h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('%d 条评论')); ?></h3>
    <?php if ($comments->have()): ?>
        <?php $this->comments()->listComments(array(
            'before' => '<ol class="comment__list">',
            'after' => '</ol>',
            'replyWord' => '回复',
            'customTemplate' => 'threadedComments' // 这里必须对应 functions.php 里的函数名
        )); ?>

        <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    <?php endif; ?>
</div>