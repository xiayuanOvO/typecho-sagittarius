window.sagittarius = window.sagittarius || {};

window.sagittarius.utils = {
    formatDate: function () {
        document.querySelectorAll(".meta__date").forEach((el) => {
          const time = parseInt(el.getAttribute("time"));
      
          const now = Math.floor(Date.now() / 1000);
          const diff = now - time;
      
          let text;
          if (diff < 60) {
            text = "刚刚";
          } else if (diff < 3600) {
            // 小于1小时
            text = Math.floor(diff / 60) + "分钟前";
          } else if (diff < 86400) {
            // 小于24小时
            text = Math.floor(diff / 3600) + "小时前";
          } else if (diff < 2592000) {
            // 大于1天，小于30天
            text = Math.floor(diff / 86400) + "天前";
          } else {
            const date = new Date(time * 1000);
            text = new Intl.DateTimeFormat("zh-CN", {
              year: "numeric",
              month: "2-digit",
              day: "2-digit",
              hour: "2-digit",
              minute: "2-digit",
              hour12: false, // 强制使用24小时制，避免出现上午/下午
            })
              .format(date)
              .replace(/\//g, "-")
              .replace(/\s+/, " ");
          }
      
          el.innerText = text;
        });
    },
    initCodeBlocks: function () {
        document.querySelectorAll("pre").forEach((block) => {
            block.classList.add("line-numbers");
        });
        
        let pres = document.querySelectorAll('pre[class*="language-"]');
        for (var i = 0; i < pres.length; i++) {
            var pre = pres[i];
            var m = pre.className.match(/\blanguage-(\S+)/);
            if (m) pre.setAttribute('data-label', m[1]);
        }
    },
    // 瀑布流文章
    loadMorePosts: function () {
        const listContainer = document.querySelector('.post__list');
        const indicator = document.querySelector('#load-indicator');
        if (!listContainer || !indicator) return;

        let isLoading = false;

        const loadPosts = () => {
            const nextLink = indicator.querySelector('a.next');
            if (!nextLink || isLoading) return;

            isLoading = true;
            const textNode = indicator.querySelector('.load-indicator__text');
            if (textNode) textNode.textContent = '加载中...';

            fetch(nextLink.href)
                .then(response => {
                    if (!response.ok) throw new Error('网络请求失败');
                    return response.text();
                })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newPosts = doc.querySelectorAll('.post__list .post__item');
                    
                    if (newPosts.length > 0) {
                        const fragment = document.createDocumentFragment();
                        newPosts.forEach(post => fragment.appendChild(post.cloneNode(true)));
                        listContainer.appendChild(fragment);
                        this.formatDate(listContainer);
                    }

                    const newIndicator = doc.querySelector('#load-indicator');
                    if (newIndicator && newIndicator.querySelector('a.next')) {
                        indicator.innerHTML = newIndicator.innerHTML;
                    } else {
                        indicator.innerHTML = '<span class="load-indicator__text"></span>';
                        observer.disconnect();
                    }
                })
                .catch(err => {
                    console.error('加载异常:', err);
                    if (textNode) textNode.textContent = '加载失败，请重试';
                })
                .finally(() => {
                    isLoading = false;
                });
        };

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) loadPosts();
        }, { rootMargin: '200px' }); // 提前 200px 加载，体验更流畅

        observer.observe(indicator);
    },
    // 监听textarea高度
    listenTextareaHeight: function () {
        document.querySelectorAll('.comment__textarea').forEach((textarea) => {
            textarea.addEventListener('input', function () {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });
    }
}

/**
 * 初始化文章页
 */
window.sagittarius.initPost = function () {
    window.sagittarius.utils.formatDate();
    window.sagittarius.utils.initCodeBlocks();
    window.sagittarius.utils.listenTextareaHeight();
}

/**
 * 初始化首页
 */
window.sagittarius.initIndex = function () {
    window.sagittarius.utils.formatDate();
    window.sagittarius.utils.loadMorePosts();
}
