</body>

</html>

<script src="<?php $this->options->themeUrl('assets/js/prism.js'); ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // 找到所有代码块的 pre 标签
        document.querySelectorAll('pre').forEach((block) => {
            // 添加 line-numbers 类以启用行号
            block.classList.add('line-numbers');
        });
    });
    
    window.sagittarius = window.sagittarius || {};
    // 格式化时间
    window.sagittarius.formatDate = () => {
        document.querySelectorAll('.meta__date').forEach(el => {
            const time = parseInt(el.getAttribute('time'));

            const now = Math.floor(Date.now() / 1000);
            const diff = now - time;

            let text;
            if (diff < 60) {
                text = '刚刚';
            } else if (diff < 3600) {
                // 小于1小时
                text = Math.floor(diff / 60) + '分钟前';
            } else if (diff < 86400) {
                // 小于24小时
                text = Math.floor(diff / 3600) + '小时前';
            } else if (diff < 2592000) {
                // 大于1天，小于30天
                text = Math.floor(diff / 86400) + '天前';
            } else {
                const date = new Date(time * 1000);
                text = new Intl.DateTimeFormat('zh-CN', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false // 强制使用24小时制，避免出现上午/下午
                }).format(date).replace(/\//g, '-').replace(/\s+/, ' ');
            }

            el.innerText = text;
        });
    }
</script>