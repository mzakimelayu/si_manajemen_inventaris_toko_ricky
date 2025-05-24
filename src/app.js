let sidebarState = localStorage.getItem('sidebarState') || 'expanded';
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const adminTitle = document.getElementById('adminTitle');
const mainContainer = document.getElementById('mainContainer');

function updateMainContentMargin() {
    if (window.innerWidth >= 1024) {
        mainContainer.style.marginLeft = sidebar.classList.contains('sidebar-expanded') ? '240px' : '140px';
    } else {
        mainContainer.style.marginLeft = '0';
    }
}

function initSidebar() {
    if (sidebarState === 'collapsed') {
        sidebar.classList.remove('sidebar-expanded');
        sidebar.classList.add('sidebar-collapsed');
        adminTitle.textContent = 'AP';
    }
    if (window.innerWidth < 1024) {
        sidebar.classList.add('-translate-x-full');
    }
    updateMainContentMargin();
}

function toggleSidebar() {
    if (sidebar.classList.contains('sidebar-expanded')) {
        sidebar.classList.remove('sidebar-expanded');
        sidebar.classList.add('sidebar-collapsed');
        adminTitle.textContent = 'AP';
        sidebarState = 'collapsed';
    } else {
        sidebar.classList.remove('sidebar-collapsed');
        sidebar.classList.add('sidebar-expanded');
        adminTitle.textContent = 'Admin Inventaris';
        sidebarState = 'expanded';
    }
    localStorage.setItem('sidebarState', sidebarState);
    updateMainContentMargin();
}

function toggleSidebarMobile() {
    sidebar.classList.toggle('-translate-x-full');
    sidebarOverlay.classList.toggle('hidden');
    document.body.classList.toggle('overflow-hidden');
}

function closeSidebarMobile() {
    sidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function handleLinkClick(event) {
    if (window.innerWidth < 1024) {
        closeSidebarMobile();
    }
}

function toggleSubmenu(submenuId) {
    const submenu = document.getElementById(submenuId);
    const arrow = document.getElementById(submenuId + 'Arrow');
    
    if (submenu.classList.contains('hidden')) {
        submenu.classList.remove('hidden');
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        arrow.style.transform = 'rotate(180deg)';
    } else {
        submenu.classList.add('hidden');
        submenu.style.maxHeight = '0';
        arrow.style.transform = 'rotate(0)';
    }
}

document.getElementById('menuBtn').addEventListener('click', toggleSidebarMobile);
document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);

window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    } else {
        if (!sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.add('-translate-x-full');
        }
    }
    updateMainContentMargin();
});

document.addEventListener('DOMContentLoaded', initSidebar);

function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    menu.classList.toggle('hidden');
    
    const closeMenu = (e) => {
        if (!menu.contains(e.target) && !e.target.closest('button')) {
            menu.classList.add('hidden');
            document.removeEventListener('click', closeMenu);
        }
    };
    
    if (!menu.classList.contains('hidden')) {
        setTimeout(() => {
            document.addEventListener('click', closeMenu);
        }, 0);
    }
}