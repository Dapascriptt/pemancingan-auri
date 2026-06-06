const nav = document.getElementById('navMenu');
const hamburger = document.getElementById('hamburger');
const navbar = document.getElementById('navbar');
const navLinks = Array.from(document.querySelectorAll('.nav-link'));
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (hamburger && nav) {
  hamburger.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('open');
    hamburger.setAttribute('aria-expanded', String(isOpen));
  });

  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      nav.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
    });
  });
}

document.addEventListener('click', (event) => {
  const target = event.target.closest("a[href^='#']");
  if (!target) return;

  const id = target.getAttribute('href');
  const section = id && id !== '#' ? document.querySelector(id) : null;
  if (!section) return;

  event.preventDefault();
  section.scrollIntoView({ behavior: prefersReducedMotion ? 'auto' : 'smooth' });
});

if (navbar) {
  document.addEventListener('scroll', () => {
    navbar.classList.toggle('shadow', window.scrollY > 10);
  });
}

if (navLinks.length) {
  const sectionObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        navLinks.forEach((link) => {
          link.classList.toggle('active', link.getAttribute('href') === `#${entry.target.id}`);
        });
      });
    },
    { threshold: 0.35 }
  );

  document.querySelectorAll('main section[id]').forEach((section) => sectionObserver.observe(section));
}

const revealItems = Array.from(document.querySelectorAll('.reveal'));
if (prefersReducedMotion) {
  revealItems.forEach((item) => item.classList.add('in-view'));
} else if (revealItems.length) {
  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('in-view');
        revealObserver.unobserve(entry.target);
      });
    },
    { threshold: 0.16 }
  );

  revealItems.forEach((item) => revealObserver.observe(item));
}

document.querySelectorAll('[data-slider]').forEach((slider) => {
  const slides = Array.from(slider.querySelectorAll('[data-slide]'));
  const dots = Array.from(slider.querySelectorAll('[data-slider-dot]'));
  const prev = slider.querySelector('[data-slider-prev]');
  const next = slider.querySelector('[data-slider-next]');
  let activeIndex = Math.max(0, slides.findIndex((slide) => slide.classList.contains('active')));
  let intervalId = null;

  if (slides.length < 2) return;

  const setActiveSlide = (index) => {
    activeIndex = (index + slides.length) % slides.length;

    slides.forEach((slide, slideIndex) => {
      slide.classList.toggle('active', slideIndex === activeIndex);
    });

    dots.forEach((dot, dotIndex) => {
      dot.classList.toggle('active', dotIndex === activeIndex);
    });
  };

  const moveSlide = (direction) => setActiveSlide(activeIndex + direction);
  const stopAutoplay = () => {
    if (intervalId) window.clearInterval(intervalId);
    intervalId = null;
  };
  const startAutoplay = () => {
    if (prefersReducedMotion || intervalId) return;
    intervalId = window.setInterval(() => moveSlide(1), 4500);
  };

  prev?.addEventListener('click', () => {
    stopAutoplay();
    moveSlide(-1);
    startAutoplay();
  });

  next?.addEventListener('click', () => {
    stopAutoplay();
    moveSlide(1);
    startAutoplay();
  });

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      stopAutoplay();
      setActiveSlide(index);
      startAutoplay();
    });
  });

  slider.addEventListener('mouseenter', stopAutoplay);
  slider.addEventListener('mouseleave', startAutoplay);
  slider.addEventListener('focusin', stopAutoplay);
  slider.addEventListener('focusout', startAutoplay);

  setActiveSlide(activeIndex);
  startAutoplay();
});

const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightboxImage');
const lightboxClose = document.getElementById('lightboxClose');
const lightboxPrev = document.getElementById('lightboxPrev');
const lightboxNext = document.getElementById('lightboxNext');
const galleryImages = Array.from(document.querySelectorAll('.gallery-item img'));
let currentIndex = 0;
let lastFocus = null;

const showLightboxImage = () => {
  if (!lightboxImage || !galleryImages[currentIndex]) return;
  lightboxImage.src = galleryImages[currentIndex].src;
  lightboxImage.alt = galleryImages[currentIndex].alt;
};

const openLightbox = (index) => {
  if (!lightbox || !lightboxClose) return;
  currentIndex = index;
  lastFocus = document.activeElement;
  showLightboxImage();
  lightbox.classList.add('open');
  lightbox.setAttribute('aria-hidden', 'false');
  lightboxClose.focus();
};

const closeLightbox = () => {
  if (!lightbox) return;
  lightbox.classList.remove('open');
  lightbox.setAttribute('aria-hidden', 'true');
  if (lastFocus) lastFocus.focus();
};

const moveLightbox = (direction) => {
  if (!galleryImages.length) return;
  currentIndex = (currentIndex + direction + galleryImages.length) % galleryImages.length;
  showLightboxImage();
};

galleryImages.forEach((image, index) => {
  image.closest('.gallery-item')?.addEventListener('click', () => openLightbox(index));
});

lightboxClose?.addEventListener('click', closeLightbox);
lightboxPrev?.addEventListener('click', () => moveLightbox(-1));
lightboxNext?.addEventListener('click', () => moveLightbox(1));
lightbox?.addEventListener('click', (event) => {
  if (event.target === lightbox) closeLightbox();
});

document.addEventListener('keydown', (event) => {
  if (!lightbox?.classList.contains('open')) return;
  if (event.key === 'Escape') closeLightbox();
  if (event.key === 'ArrowRight') moveLightbox(1);
  if (event.key === 'ArrowLeft') moveLightbox(-1);
});

document.querySelectorAll('input[type="file"][accept*="image"]').forEach((input) => {
  input.addEventListener('change', () => {
    const file = input.files?.[0];
    if (!file) return;

    let preview = input.parentElement.querySelector('.preview-img');
    if (!preview) {
      preview = document.createElement('img');
      preview.className = 'preview-img';
      preview.width = 220;
      preview.height = 140;
      preview.alt = 'Preview gambar';
      input.insertAdjacentElement('afterend', preview);
    }

    preview.src = URL.createObjectURL(file);
  });
});
