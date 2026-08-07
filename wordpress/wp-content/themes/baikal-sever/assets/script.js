const header = document.getElementById('header');
const nav = document.getElementById('nav') || document.querySelector('.nav');
const menuButton = document.getElementById('menuButton');
const track = document.getElementById('tourTrack');

window.addEventListener('scroll', () => {
  if (header) header.classList.toggle('scrolled', window.scrollY > 40);
});

menuButton?.addEventListener('click', () => {
  const open = nav.classList.toggle('open');
  menuButton.setAttribute('aria-expanded', open);
});

nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
  nav.classList.remove('open');
  menuButton?.setAttribute('aria-expanded', 'false');
}));

document.getElementById('nextTour')?.addEventListener('click', () => {
  track.scrollBy({ left: track.clientWidth * .62, behavior: 'smooth' });
});
document.getElementById('prevTour')?.addEventListener('click', () => {
  track.scrollBy({ left: -track.clientWidth * .62, behavior: 'smooth' });
});

if (track) {
  let gestureMoved = false;
  let pointerStart = null;

  track.addEventListener('pointerdown', event => {
    pointerStart = { x: event.clientX, y: event.clientY };
    gestureMoved = false;
  }, { passive: true });

  track.addEventListener('pointermove', event => {
    if (!pointerStart) return;
    gestureMoved = Math.abs(event.clientX - pointerStart.x) > 8 || Math.abs(event.clientY - pointerStart.y) > 8;
  }, { passive: true });

  track.addEventListener('pointercancel', () => { pointerStart = null; gestureMoved = false; });

  track.querySelectorAll('.tour-card').forEach(card => {
    const routeLink = card.querySelector('.tour-info > a');
    if (!routeLink) return;
    card.tabIndex = 0;
    card.setAttribute('role', 'link');
    card.setAttribute('aria-label', routeLink.getAttribute('aria-label') || 'Открыть маршрут');
    card.addEventListener('click', event => {
      if (gestureMoved || event.target.closest('a')) return;
      window.location.href = routeLink.href;
    });
    card.addEventListener('keydown', event => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        window.location.href = routeLink.href;
      }
    });
  });
}

document.querySelectorAll('.chips button').forEach(button => {
  button.addEventListener('click', () => button.classList.toggle('active'));
});

document.querySelectorAll('.exp-hero-content, .exp-summary, .exp-section-title, .route-stop, .exp-details > div, .included-list, .exp-facts, .people-gallery figure, .exp-booking > div, .exp-booking .form')
  .forEach(el => el.classList.add('reveal'));

const revealElements = document.querySelectorAll('.reveal');
const revealAll = () => revealElements.forEach(el => el.classList.add('visible'));

if ('IntersectionObserver' in window) {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: .08, rootMargin: '0px 0px 80px' });

  revealElements.forEach((el, index) => {
    el.style.setProperty('--reveal-delay', `${Math.min(index % 5, 4) * 70}ms`);
    observer.observe(el);
  });
  window.setTimeout(revealAll, 2500);
} else {
  revealAll();
}

revealElements.forEach((el, index) => {
  el.style.setProperty('--reveal-delay', `${Math.min(index % 5, 4) * 70}ms`);
});

const expeditionHero = document.querySelector('.exp-hero');
if (expeditionHero && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  const updateHero = () => expeditionHero.style.setProperty('--hero-shift', `${Math.min(window.scrollY * .14, 90)}px`);
  window.addEventListener('scroll', updateHero, { passive: true });
  updateHero();
}

document.querySelectorAll('input[type="date"]').forEach(input => {
  const localToday = new Date();
  localToday.setMinutes(localToday.getMinutes() - localToday.getTimezoneOffset());
  input.min = localToday.toISOString().slice(0, 10);
});

document.getElementById('requestForm')?.addEventListener('submit', async event => {
  event.preventDefault();
  const form = event.currentTarget;
  const toast = document.getElementById('toast');
  const submit = form.querySelector('[type="submit"]');
  const data = new FormData(form);
  const selectedRoutes = [...document.querySelectorAll('.chips button.active')].map(button => button.textContent.trim());
  if (selectedRoutes.length) data.set('routes', selectedRoutes.join(', '));
  submit.disabled = true;
  toast.textContent = 'Отправляем заявку…';
  toast.classList.add('show');

  try {
    const response = await fetch(form.action, { method: 'POST', body: data, credentials: 'same-origin' });
    const result = await response.json();
    if (!response.ok || !result.success) throw new Error(result?.data?.message || 'Ошибка отправки заявки.');
    toast.textContent = result.data.message;
    form.reset();
    document.querySelectorAll('.chips button').forEach(button => button.classList.remove('active'));
  } catch (error) {
    toast.textContent = error.message || 'Не удалось отправить заявку. Позвоните нам напрямую.';
  } finally {
    submit.disabled = false;
  }
  setTimeout(() => toast.classList.remove('show'), 4000);
});
