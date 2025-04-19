
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
const dashboardLink = document.querySelector('[onclick="dashboard_click()"]');
dashboardLink?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink1 = document.querySelector('[onclick="booking_click()"]');
dashboardLink1?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink2 = document.querySelector('[onclick="service1_click()"]');
dashboardLink2?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink3 = document.querySelector('[onclick="service2_click()"]');
dashboardLink3?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink4 = document.querySelector('[onclick="sp1_click()"]');
dashboardLink4?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink5 = document.querySelector('[onclick="sp2_click()"]');
dashboardLink5?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});

const dashboardLink6 = document.querySelector('[onclick="payment_click()"]');
dashboardLink6?.addEventListener('click', () => {
    if (window.innerWidth < 992) {
        sidebar.classList.add('d-none');
    }
});
function dashboard_click(){
    document.getElementById('ui1').style.display="block";
    document.getElementById('ui2').style.display="none";
    document.getElementById('ui3').style.display="none";
    document.getElementById('ui4').style.display="none";
    document.getElementById('ui5').style.display="none";
    document.getElementById('ui6').style.display="none";
    document.getElementById('ui7').style.display="none";
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link, .sidebar .dropdown-item');


}
function booking_click(){
    document.getElementById('ui1').style.display="none";
    document.getElementById('ui2').style.display="block";
    document.getElementById('ui3').style.display="none";
    document.getElementById('ui4').style.display="none";
    document.getElementById('ui5').style.display="none";
    document.getElementById('ui6').style.display="none";
    document.getElementById('ui7').style.display="none";
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link, .sidebar .dropdown-item');


}
function service1_click(){
    document.getElementById('ui1').style.display="none";
    document.getElementById('ui2').style.display="none";
    document.getElementById('ui3').style.display="block";
    document.getElementById('ui4').style.display="none";
    document.getElementById('ui5').style.display="none";
    document.getElementById('ui6').style.display="none";
    document.getElementById('ui7').style.display="none";
}
function service2_click(){
    document.getElementById('ui1').style.display="none";
    document.getElementById('ui2').style.display="none";
    document.getElementById('ui3').style.display="none";
    document.getElementById('ui4').style.display="block";
    document.getElementById('ui5').style.display="none";
    document.getElementById('ui6').style.display="none";
    document.getElementById('ui7').style.display="none";
}
function sp1_click(){
    document.getElementById('ui1').style.display="none";
    document.getElementById('ui2').style.display="none";
    document.getElementById('ui3').style.display="none";
    document.getElementById('ui4').style.display="none";
    document.getElementById('ui5').style.display="block";
    document.getElementById('ui6').style.display="none";
    document.getElementById('ui7').style.display="none";
}
function sp2_click(){
    document.getElementById('ui1').style.display="none";
    document.getElementById('ui2').style.display="none";
    document.getElementById('ui3').style.display="none";
    document.getElementById('ui4').style.display="none";
    document.getElementById('ui5').style.display="none";
    document.getElementById('ui6').style.display="block";
    document.getElementById('ui7').style.display="none";
}
function payment_click(){
    document.getElementById('ui1').style.display="none";
    document.getElementById('ui2').style.display="none";
    document.getElementById('ui3').style.display="none";
    document.getElementById('ui4').style.display="none";
    document.getElementById('ui5').style.display="none";
    document.getElementById('ui6').style.display="none";
    document.getElementById('ui7').style.display="block";
}