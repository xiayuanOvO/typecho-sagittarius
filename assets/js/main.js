// 格式化时间
function formatTime(timestamp) {
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
}
// 格式化文章发布时间
function formatPostDate(timestamp) {
  document.querySelectorAll(".meta__date").forEach((el) => {
    const time = parseInt(el.getAttribute("time"));
    if (!isNaN(time)) {
      el.innerText = formatTime(time);
    }
  });
}
// 输入框自适应高度
function initTextareaHeight() {
  document.querySelectorAll(".comment__textarea").forEach((textarea) => {
    textarea.addEventListener("input", function () {
      this.style.height = "auto";
      this.style.height = this.scrollHeight + "px";
    });
  });
}
// 瀑布流加载文章
function initWaterfall() {
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
            fragment.appendChild(post.cloneNode(true))
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
    { rootMargin: "200px" }
  ); // 提前 200px 加载，体验更流畅

  observer.observe(indicator);
}

const state = {
  parent: null,
  author: null,
};

const qs = (s) => document.querySelector(s);

// 切换取消按钮可视状态
function showCancel(show) {
  const btn = qs(".comment__cancel");
  if (btn) btn.style.display = show ? "block" : "none";
}

// 设置回复状态
function setReply(e) {
  const coid = e.target.dataset.coid;
  const author = e.target.dataset.author;
  state.parent = coid;
  state.author = author;

  const form = qs(".comment__form");
  if (!form) return;
  form.scrollIntoView({ behavior: "smooth", block: "center" });
  setTimeout(() => {
    const textarea = form.querySelector(".comment__textarea");
    if (textarea) textarea.focus();
  }, 100);

  // 设置提示
  const tip = qs(".comment__textarea__tip");
  if (tip) tip.innerHTML = `正在回复 @${author} 的评论`;
  showCancel(true);
}

// 重置回复状态
function resetReply() {
  state.parent = null;
  state.author = null;
  // 重置提示
  const tip = qs(".comment__textarea__tip");
  if (tip) tip.innerHTML = "";
  showCancel(false);
}

// 提交评论
async function submitComment() {
  const form = qs(".comment__form");
  if (!form) return;
  if (!form.reportValidity()) return;

  const textarea = qs(".comment__textarea");
  const text = textarea.value.trim();
  if (!text) return;

  const action = form.dataset.action;
  const formData = new FormData(form);

  if (state.parent) {
    formData.append("parent", state.parent);
  }

  const res = await fetch(action, {
    method: "POST",
    body: formData,
    headers: { "X-Requested-With": "XMLHttpRequest" },
  });

  const html = await res.text();
  const doc = new DOMParser().parseFromString(html, "text/html");
  const newWrapper = doc.querySelector(".comment__wrapper");
  if (!newWrapper) return;

  const wrapper = qs(".comment__wrapper");
  if (wrapper) wrapper.innerHTML = newWrapper.innerHTML;

  // 重新计算时间
  formatPostDate();

  if (state.parent) {
    // 滚动到父组件
    const parent = qs("#li-comment-" + state.parent);
    if (!parent) return;
    parent.scrollIntoView({ behavior: "smooth", block: "center" });
  } else {
    // 滚动到最新评论
    const list = wrapper.querySelectorAll(".comment__item");
    const latestComment = list.length ? list[list.length - 1] : null;
    if (!latestComment) return;
    latestComment.scrollIntoView({ behavior: "smooth", block: "center" });
  }
  resetReply();
  textarea.value = "";
}

function initCommentEvents() {
  /* 事件委托（局部刷新也有效） */
  document.addEventListener("click", (e) => {
    if (e.target.closest(".comment__reply")) {
      setReply(e);
      return;
    }

    if (e.target.closest(".comment__cancel")) {
      resetReply();
      return;
    }

    if (e.target.closest(".comment__submit")) {
      e.preventDefault();  // 防止表单提交
      submitComment();
      return;
    }
  });
}

function init() {
  formatPostDate();
  initTextareaHeight();
  initWaterfall();
  initCommentEvents();
}

document.addEventListener("DOMContentLoaded", init);
