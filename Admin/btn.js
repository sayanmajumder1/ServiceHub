
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebarCollapse = document.getElementById('sidebarCollapse');

sidebarToggle?.addEventListener('click', () => {
    sidebar.classList.toggle('d-none');
});

sidebarCollapse?.addEventListener('click', () => {
    sidebar.classList.add('d-none');
});


// Close sidebar on nav item click (on mobile only)

// Hide sidebar when dashboard (or any nav link) is clicked on small screens
const dashboardLink1 = document.querySelector('[onclick="dashboard_click()"]');
dashboardLink1?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});


const dashboardLink2 = document.querySelector('[onclick="user_click()"]');
dashboardLink2?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink3 = document.querySelector('[onclick="booking_click()"]');
dashboardLink3?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink4 = document.querySelector('[onclick="service1_click()"]');
dashboardLink4?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink5 = document.querySelector('[onclick="service2_click()"]');
dashboardLink5?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink6 = document.querySelector('[onclick="service3_click()"]');
dashboardLink6?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink7 = document.querySelector('[onclick="service4_click()"]');
dashboardLink7?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink8 = document.querySelector('[onclick="sp1_click()"]');
dashboardLink8?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink9 = document.querySelector('[onclick="sp2_click()"]');
dashboardLink9?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink10 = document.querySelector('[onclick="sp3_click()"]');
dashboardLink10?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink11 = document.querySelector('[onclick="payment_click()"]');
dashboardLink11?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink12 = document.querySelector('[onclick="feedback_click()"]');
dashboardLink12?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});


const dashboardLink13= document.querySelector('[onclick="se1_click()"]');
dashboardLink13?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink14 = document.querySelector('[onclick="se2_click()"]');
dashboardLink14?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});



