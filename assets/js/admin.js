/**
 * 初始化后台管理功能
 */
function initAdmin() {
    // 创建侧边栏导航
    createSidebar();
    
    // 初始化背景模式切换
    initBgModeToggle();
    
    // 初始化快捷键保存
    initShortcutSave();
}

/**
 * 创建配置侧边栏
 */
function createSidebar() {
    const main = document.querySelector('.typecho-page-main');
    
    if (main) {
        const sidebar = document.createElement('div');
        sidebar.className = 'config-sidebar';
        sidebar.innerHTML = '<ul id="config-nav"></ul>';
        main.appendChild(sidebar);
        
        // 添加导航项
        const nav = document.getElementById('config-nav');
        const headers = document.querySelectorAll('.typecho-page-main h2');
        
        headers.forEach((header, index) => {
            const id = 'section-' + index;
            header.setAttribute('id', id);
            
            const li = document.createElement('li');
            li.innerHTML = `<a href="#${id}">${header.innerText}</a>`;
            
            // 添加点击事件
            li.addEventListener('click', (e) => {
                e.preventDefault();
                
                // 移除所有选中状态
                document.querySelectorAll('.config-sidebar li').forEach(item => {
                    item.classList.remove('active');
                });
                
                // 添加当前选中状态
                li.classList.add('active');
                
                // 平滑滚动到对应区域
                header.scrollIntoView({
                    behavior: 'smooth'
                });
            });
            
            nav.appendChild(li);
        });
        
        // 初始化第一个选项为选中状态
        if (nav.firstChild) {
            nav.firstChild.classList.add('active');
        }
        
        // 添加滚动监听
        initScrollSpy(headers, nav);
    }
}

/**
 * 初始化背景模式切换功能
 */
function initBgModeToggle() {
    const selector = document.getElementsByName('bgMode')[0];
    const imgContainer = document.getElementsByName('bgImage')[0]?.closest('li');
    const colorContainer = document.getElementsByName('bgColor')[0]?.closest('li');
    
    function updateVisibility() {
        if (!selector) return;
        
        if (selector.value === 'image') {
            if (imgContainer) imgContainer.style.display = '';
            if (colorContainer) colorContainer.style.display = 'none';
        } else {
            if (imgContainer) imgContainer.style.display = 'none';
            if (colorContainer) colorContainer.style.display = '';
        }
    }
    
    if (selector) {
        selector.onchange = updateVisibility;
        updateVisibility();
    }
}

/**
 * 初始化滚动监听功能
 * 根据滚动位置自动更新侧边栏选中状态
 */
function initScrollSpy(headers, nav) {
    // 获取所有导航项
    const navItems = nav.querySelectorAll('li');
    
    // 滚动监听函数
    function updateActiveNav() {
        const scrollPosition = window.scrollY + 100; // 添加偏移量
        
        // 找到当前可见的标题
        let currentActiveIndex = -1;
        
        headers.forEach((header, index) => {
            const rect = header.getBoundingClientRect();
            const elementTop = rect.top + window.scrollY;
            
            if (scrollPosition >= elementTop) {
                currentActiveIndex = index;
            }
        });
        
        // 更新选中状态
        navItems.forEach((item, index) => {
            if (index === currentActiveIndex) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
        
        // 如果没有找到任何可见标题，选中第一个
        if (currentActiveIndex === -1 && navItems.length > 0) {
            navItems[0].classList.add('active');
        }
    }
    
    // 添加滚动监听
    window.addEventListener('scroll', updateActiveNav);
    
    // 初始调用
    updateActiveNav();
}

/**
 * 初始化快捷键保存功能
 */
function initShortcutSave() {
    document.addEventListener('keydown', function(e) {
        // Ctrl+S 或 Cmd+S 快捷键保存
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
            e.preventDefault();
            
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.click();
            }
        }
    });
}

// 页面加载完成后初始化
document.addEventListener('DOMContentLoaded', initAdmin);