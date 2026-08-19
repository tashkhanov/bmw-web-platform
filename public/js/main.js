document.addEventListener('DOMContentLoaded', () => {

  // Car menu hover
  document.querySelectorAll('.car').forEach(car => {
    const menu = car.querySelector('.car-menu');
    if (!menu) return;
    let leaveTimer, enterTimer;
    const show = () => menu.classList.add('show');
    const hide = () => menu.classList.remove('show');
    const leaveCheck = () => {
      clearTimeout(leaveTimer);
      leaveTimer = setTimeout(() => {
        if (!car.matches(':hover') && !menu.matches(':hover')) hide();
      }, 100);
    };
    car.addEventListener('mouseenter', () => {
      clearTimeout(enterTimer);
      enterTimer = setTimeout(show, 500);
    });
    car.addEventListener('mouseleave', () => { clearTimeout(enterTimer); leaveCheck(); });
    menu.addEventListener('mouseenter', show);
    menu.addEventListener('mouseleave', leaveCheck);
  });

  // Swiper
  const configs = [
    { selector: '.mySwiper4', options: { effect: 'coverflow', grabCursor: true, centeredSlides: true, slidesPerView: 'auto', coverflowEffect: { rotate: 50, stretch: 0, depth: 100, modifier: 1, slideShadows: true }, pagination: { el: '.swiper-pagination', type: 'bullets' }, autoplay: { delay: 1500, disableOnInteraction: false }, loop: true } },
    { selector: '.mySwiper3', options: { autoplay: { delay: 3000, disableOnInteraction: false }, loop: true } },
    { selector: '.mySwiper2', options: { autoplay: { delay: 3000, disableOnInteraction: false }, loop: true } }
  ];
  configs.forEach(cfg => {
    const el = document.querySelector(cfg.selector);
    if (el) new Swiper(cfg.selector, cfg.options);
  });

  // Navbar and account menu
  const navbar = document.querySelector('.navbar');
  const accountBtn = document.querySelector('[data-account-btn]') || document.querySelector('.account a');
  const signChoose = document.querySelector('.sign-choose');
  const overlay = document.querySelector('.overlay');
  if (navbar) {
    let lastY = window.pageYOffset;
    let menuOpen = false;
    const closeMenu = () => {
      if (signChoose && overlay && accountBtn) {
        signChoose.classList.remove('open');
        overlay.style.display = 'none';
        accountBtn.classList.remove('active');
        menuOpen = false;
      }
    };
    window.addEventListener('scroll', () => {
      const y = window.pageYOffset;
      if (!document.querySelector('.menu.open')) {
        navbar.style.top = y > lastY ? `-${navbar.offsetHeight + 30}px` : '30px';
      }
      if (y > lastY) closeMenu();
      lastY = y > 0 ? y : 0;
    });
    if (accountBtn && signChoose && overlay) {
      accountBtn.addEventListener('click', e => {
        e.preventDefault();
        if (window.innerWidth > 992) {
            menuOpen = !signChoose.classList.contains('open');
            signChoose.classList.toggle('open', menuOpen);
            overlay.style.display = menuOpen ? 'block' : 'none';
            accountBtn.classList.toggle('active', menuOpen);
        }
      });
      overlay.addEventListener('click', closeMenu);
      document.addEventListener('click', e => {
        if (menuOpen && !signChoose.contains(e.target) && !accountBtn.contains(e.target)) closeMenu();
      });
    }
  }

  // burger
  const burgerMenu = document.querySelector('.burger-menu');
  const menu = document.querySelector('.menu');

  if (burgerMenu && menu) {
    burgerMenu.addEventListener('click', () => {
      burgerMenu.classList.toggle('active');
      menu.classList.toggle('open');
      document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
    });
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (menu.classList.contains('open')) {
                burgerMenu.classList.remove('active');
                menu.classList.remove('open');
                document.body.style.overflow = '';
            }
        });
    });
  }
});
