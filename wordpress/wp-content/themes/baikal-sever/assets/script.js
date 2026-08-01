const header = document.getElementById('header');
const nav = document.getElementById('nav');
const menuButton = document.getElementById('menuButton');
const track = document.getElementById('tourTrack');

window.addEventListener('scroll', () => {
  header.classList.toggle('scrolled', window.scrollY > 40);
});

menuButton.addEventListener('click', () => {
  const open = nav.classList.toggle('open');
  menuButton.setAttribute('aria-expanded', open);
});

nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
  nav.classList.remove('open');
  menuButton.setAttribute('aria-expanded', 'false');
}));

document.getElementById('nextTour').addEventListener('click', () => {
  track.scrollBy({ left: track.clientWidth * .62, behavior: 'smooth' });
});
document.getElementById('prevTour').addEventListener('click', () => {
  track.scrollBy({ left: -track.clientWidth * .62, behavior: 'smooth' });
});

document.querySelectorAll('.chips button').forEach(button => {
  button.addEventListener('click', () => button.classList.toggle('active'));
});

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: .12 });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

document.getElementById('requestForm').addEventListener('submit', event => {
  event.preventDefault();
  const toast = document.getElementById('toast');
  toast.classList.add('show');
  event.target.reset();
  document.querySelectorAll('.chips button').forEach(button => button.classList.remove('active'));
  setTimeout(() => toast.classList.remove('show'), 4000);
});
