(function () {
  // 格式化时间
  const formatTime = (timestamp) => {
    const now = Math.floor(Date.now() / 1000);

    const diff = now - timestamp;
    if (diff < 60) return "刚刚";
    const intervals = [
      { label: "分钟前", value: 60 },
      { label: "小时前", value: 3600 },
      { label: "天前", value: 86400 },
    ];

    if (diff < 2592000) {
      const unit = intervals.reverse().find((i) => diff >= i.value);
      return Math.floor(diff / unit.value) + unit.label;
    }

    return new Intl.DateTimeFormat("zh-CN", {
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
      hour: "2-digit",
      minute: "2-digit",
      hour12: false,
    })
      .format(new Date(timestamp * 1000))
      .replace(/\//g, "-");
  };
  // 格式化文章发布时间
  const formatPostDate = (timestamp) => {
    document.querySelectorAll(".meta__date").forEach((el) => {
      const time = parseInt(el.getAttribute("time"));
      if (!isNaN(time)) {
        el.innerText = formatTime(time);
      }
    });
  };
  // 输入框自适应高度
  const initTextareaHeight = () => {
    document.querySelectorAll(".comment__textarea").forEach((textarea) => {
      textarea.addEventListener("input", function () {
        this.style.height = "auto";
        this.style.height = this.scrollHeight + "px";
      });
    });
  };
  // 瀑布流加载文章
  const initWaterfall = () => {
    const listContainer = document.querySelector(".post__list");
    const indicator = document.querySelector("#load-indicator");
    if (!listContainer || !indicator) return;
    let isLoading = false;

    const loadPosts = () => {
      const nextLink = indicator.querySelector("a.next");
      if (!nextLink || isLoading) return;

      isLoading = true;
      const textNode = indicator.querySelector(".load-indicator__text");
      if (textNode) textNode.textContent = "加载中...";

      fetch(nextLink.href)
        .then((response) => {
          if (!response.ok) throw new Error("网络请求失败");
          return response.text();
        })
        .then((html) => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, "text/html");
          const newPosts = doc.querySelectorAll(".post__list .post__item");

          if (newPosts.length > 0) {
            const fragment = document.createDocumentFragment();
            newPosts.forEach((post) =>
              fragment.appendChild(post.cloneNode(true)),
            );
            listContainer.appendChild(fragment);
            formatPostDate(listContainer);
          }

          const newIndicator = doc.querySelector("#load-indicator");
          if (newIndicator && newIndicator.querySelector("a.next")) {
            indicator.innerHTML = newIndicator.innerHTML;
          } else {
            indicator.innerHTML = '<span class="load-indicator__text"></span>';
            observer.disconnect();
          }
        })
        .catch((err) => {
          if (textNode) textNode.textContent = "加载失败，请重试";
        })
        .finally(() => {
          isLoading = false;
        });
    };

    const observer = new IntersectionObserver(
      (entries) => {
        if (entries[0].isIntersecting) loadPosts();
      },
      { rootMargin: "200px" },
    ); // 提前 200px 加载，体验更流畅

    observer.observe(indicator);
  };

  const init = () => {
    formatPostDate();
    initTextareaHeight();
    initWaterfall();
  }

  document.addEventListener("DOMContentLoaded", init);
})();
