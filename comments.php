<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;
$comments = $this->comments();
?>
<div class="comment__wrapper">
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            <form class="comment__form" method="post" action="<?php $this->commentUrl() ?>" role="form"
                data-action="<?php echo $this->commentUrl(); ?>">
                <?php if ($this->user->hasLogin()): ?>
                    <div class="comment__login__content">
                        <a href="<?php $this->options->profileUrl(); ?>">
                            <img class="comment__avatar"
                                src="<?php echo htmlspecialchars(getAuthorAvatar($this->user->mail, $this->options)); ?>"
                                alt="<?php echo htmlspecialchars($this->user->screenName()); ?>">
                        </a>
                        <div class="comment__textarea__wrapper">
                            <textarea class="comment__textarea" name="text" placeholder="在这里输入您的评论" required
                                rows="1"><?php $this->remember('text'); ?></textarea>
                        </div>
                    </div>
                    <div class="comment__login__footer">
                        <button class="comment__cancel" type="button" onclick="cancelReply();">
                            <?php _t('取消回复'); ?>
                        </button>
                        <button class="comment__submit" type="button" onclick="submitComment();">
                            <?php _t('提交评论'); ?>
                        </button>
                    </div>
                <?php else: ?>
                    <p>
                        <input type="text" name="author" class="text" placeholder="称呼"
                            value="<?php $this->remember('author'); ?>" required />
                        <input type="email" name="mail" class="text" placeholder="Email"
                            value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail): ?>required<?php endif; ?> />
                        <input type="url" name="url" class="text" placeholder="http://"
                            value="<?php $this->remember('url'); ?>" />
                    </p>
                <?php endif; ?>

            </form>
        </div>
    <?php else: ?>
        <p><?php _t('评论已关闭'); ?></p>
    <?php endif; ?>
    <?php if ($comments->have()): ?>
        <h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('%d 条评论')); ?></h3>

        <?php $this->comments()->listComments(array(
            'before' => '<ol class="comment__list">',
            'after' => '</ol>',
            'replyWord' => '回复',
            'customTemplate' => 'threadedComments' // 这里必须对应 functions.php 里的函数名
        )); ?>

        <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    <?php endif; ?>
</div>

<script>
    const commentState = {
        coid: null,
        author: null
    }

    function replyComment(coid, author) {
        console.log(coid, author);
        commentState.coid = coid;
        commentState.author = author;
        document.querySelector('.comment__cancel').style.display = 'block';
    }

    function cancelReply() {
        commentState.coid = null;
        commentState.author = null;
        document.querySelector('.comment__cancel').style.display = 'none';
    }

    function submitComment() {
        const form = document.querySelector('.comment__form')
        const action = form.dataset.action;
        const formData = new FormData(form);
        if (commentState.coid) {
            formData.append('parent', commentState.coid);
        }

        fetch(action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // 告诉 Typecho 这是一个异步请求
            }
        }).then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newWrapper = doc.querySelector('.comment__wrapper');
                if (!newWrapper) return;
                document.querySelector('.comment__wrapper').innerHTML = newWrapper.innerHTML;
                cancelReply();
            })
    }
</script>