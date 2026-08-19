document.addEventListener('DOMContentLoaded', () => {

    const searchInput = document.getElementById('model-search');
        const modelSelect = document.getElementById('model');
        const colorSelect = document.getElementById('color');
        const packageSelect = document.getElementById('package');
        const interiorSelect = document.getElementById('interior');
        const modelPriceInput = document.getElementById('model-price');

        function clearSelect(el){ if(!el) return; el.innerHTML = ''; }
        function renderOptions(el, values){
            if(!el) return;
            clearSelect(el);
            if(!values || !values.length){ el.innerHTML = '<option value="">—</option>'; return; }
            values.forEach(v => {
            const opt = document.createElement('option'); opt.value = v; opt.textContent = v; el.appendChild(opt);
            });
        }

        function applyCarData(car){
            console.log('applyCarData', car);
            if(!car) return;
            if(modelSelect){
            modelSelect.style.display = 'block';
            modelSelect.innerHTML = `<option value="${car.id}">${car.car}</option>`;
            }
            if(searchInput) searchInput.value = car.car ?? '';
            renderOptions(colorSelect, Array.isArray(car.colors) ? car.colors : (car.colors ? car.colors : []));
            renderOptions(packageSelect, Array.isArray(car.complectation) ? car.complectation : (car.complectation ? car.complectation : []));
            renderOptions(interiorSelect, Array.isArray(car.interior) ? car.interior : (car.interior ? car.interior : []));
            if(modelPriceInput) modelPriceInput.value = car.price ?? '';
        }

        // apply server initial model
        if(window.INITIAL_MODEL){
            console.log('INITIAL_MODEL', window.INITIAL_MODEL);
            applyCarData(window.INITIAL_MODEL);
        }

        // search
        if(searchInput && window.ROUTES && window.ROUTES.searchModels){
            let timer = null;
            searchInput.addEventListener('input', () => {
            clearTimeout(timer);
            const q = searchInput.value.trim();
            if(q.length < 2){ if(modelSelect){ modelSelect.style.display='none'; clearSelect(modelSelect);} return; }
            timer = setTimeout(() => {
                const url = window.ROUTES.searchModels + '?query=' + encodeURIComponent(q);
                console.log('fetch search ->', url);
                fetch(url).then(r => r.json()).then(data => {
                console.log('search response', data);
                if(!Array.isArray(data) || data.length === 0){ if(modelSelect){ modelSelect.style.display='none'; clearSelect(modelSelect);} return; }
                modelSelect.style.display = 'block';
                modelSelect.innerHTML = '';
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.car;
                    modelSelect.appendChild(opt);
                });
                }).catch(err => console.error('search fetch error', err));
            }, 250);
            });

            modelSelect.addEventListener('change', () => {
            const id = modelSelect.value;
            if(!id) return;
            const tpl = (window.ROUTES.getModelTemplate || '').replace('__ID__', id);
            console.log('fetch model ->', tpl);
            fetch(tpl).then(r => r.json()).then(car => {
                console.log('model response', car);
                applyCarData(car);
            }).catch(err => console.error('getModel fetch error', err));
            });
        }

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
      // Не прячем навбар, если открыто бургер-меню
      if (!document.querySelector('.menu.open')) {
        navbar.style.top = y > lastY ? `-${navbar.offsetHeight + 30}px` : '30px';
      }
      if (y > lastY) closeMenu();
      lastY = y > 0 ? y : 0;
    });
    if (accountBtn && signChoose && overlay) {
      accountBtn.addEventListener('click', e => {
        e.preventDefault();
        // Не даем сработать этому меню, если активно бургер-меню
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

  // >>> НОВЫЙ КОД ДЛЯ БУРГЕР-МЕНЮ <<<
  const burgerMenu = document.querySelector('.burger-menu');
  const menu = document.querySelector('.menu');
  
  if (burgerMenu && menu) {
    burgerMenu.addEventListener('click', () => {
      burgerMenu.classList.toggle('active');
      menu.classList.toggle('open');
      // Блокируем прокрутку страницы, когда меню открыто
      document.body.style.overflow = menu.classList.contains('open') ? 'hidden' : '';
    });

    // Закрываем меню при клике на ссылку (для перехода на другую страницу)
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