const WA_NUMBER = "6281234567890";

const nav = document.getElementById("navMenu");
const navLinks = Array.from(document.querySelectorAll(".nav-link"));
const hamburger = document.getElementById("hamburger");
const navbar = document.getElementById("navbar");
const lightbox = document.getElementById("lightbox");
const lightboxImage = document.getElementById("lightboxImage");
const lightboxPrev = document.getElementById("lightboxPrev");
const lightboxNext = document.getElementById("lightboxNext");
const lightboxClose = document.getElementById("lightboxClose");
const galleryItems = Array.from(document.querySelectorAll(".gallery-item img"));
const accordionHeaders = Array.from(document.querySelectorAll(".accordion-header"));
const revealSections = Array.from(document.querySelectorAll(".reveal"));

let currentIndex = 0;
let lastFocusedElement = null;

const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

const makeWhatsAppUrl = (message) => {
  const encoded = encodeURIComponent(message);
  return `https://wa.me/${WA_NUMBER}?text=${encoded}`;
};

const openWhatsApp = (message) => {
  window.open(makeWhatsAppUrl(message), "_blank", "noopener");
};

const closeMobileNav = () => {
  nav.classList.remove("open");
  hamburger.setAttribute("aria-expanded", "false");
};

hamburger.addEventListener("click", () => {
  const isOpen = nav.classList.toggle("open");
  hamburger.setAttribute("aria-expanded", String(isOpen));
});

navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    closeMobileNav();
  });
});

const scrollToSection = (event) => {
  const target = event.target.closest("a[href^='#']");
  if (!target) return;
  if (target.closest("[data-wa]")) return;

  const id = target.getAttribute("href");
  if (!id || id === "#") return;
  const section = document.querySelector(id);
  if (!section) return;

  event.preventDefault();
  section.scrollIntoView({ behavior: prefersReducedMotion ? "auto" : "smooth" });
};

document.addEventListener("click", scrollToSection);

document.addEventListener("scroll", () => {
  navbar.classList.toggle("shadow", window.scrollY > 10);
});

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const id = entry.target.getAttribute("id");
        navLinks.forEach((link) => {
          link.classList.toggle("active", link.getAttribute("href") === `#${id}`);
        });
      }
    });
  },
  { threshold: 0.4 }
);

document.querySelectorAll("main section[id]").forEach((section) => observer.observe(section));

if (prefersReducedMotion) {
  revealSections.forEach((section) => section.classList.add("in-view"));
} else {
  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in-view");
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 }
  );

  revealSections.forEach((section) => revealObserver.observe(section));
}

const openLightbox = (index) => {
  currentIndex = index;
  lightboxImage.src = galleryItems[currentIndex].src;
  lightboxImage.alt = galleryItems[currentIndex].alt;
  lightbox.classList.add("open");
  lightbox.setAttribute("aria-hidden", "false");
  lastFocusedElement = document.activeElement;
  lightboxClose.focus();
};

const closeLightbox = () => {
  lightbox.classList.remove("open");
  lightbox.setAttribute("aria-hidden", "true");
  if (lastFocusedElement) {
    lastFocusedElement.focus();
  }
};

const showImage = (direction) => {
  currentIndex = (currentIndex + direction + galleryItems.length) % galleryItems.length;
  lightboxImage.src = galleryItems[currentIndex].src;
  lightboxImage.alt = galleryItems[currentIndex].alt;
};

galleryItems.forEach((img, index) => {
  img.parentElement.addEventListener("click", () => openLightbox(index));
});

lightboxClose.addEventListener("click", closeLightbox);
lightboxPrev.addEventListener("click", () => showImage(-1));
lightboxNext.addEventListener("click", () => showImage(1));

lightbox.addEventListener("click", (event) => {
  if (event.target === lightbox) closeLightbox();
});

document.addEventListener("keydown", (event) => {
  if (!lightbox.classList.contains("open")) return;
  if (event.key === "Escape") closeLightbox();
  if (event.key === "ArrowRight") showImage(1);
  if (event.key === "ArrowLeft") showImage(-1);
});

accordionHeaders.forEach((header) => {
  header.addEventListener("click", () => {
    const item = header.closest(".accordion-item");
    const isOpen = item.classList.contains("open");
    document.querySelectorAll(".accordion-item").forEach((el) => el.classList.remove("open"));
    item.classList.toggle("open", !isOpen);
    header.setAttribute("aria-expanded", String(!isOpen));
  });
});

const waButtons = Array.from(document.querySelectorAll("[data-wa]"));
waButtons.forEach((btn) => {
  btn.addEventListener("click", (event) => {
    event.preventDefault();
    const message = btn.getAttribute("data-wa");
    openWhatsApp(`Halo Pemancingan AURI, ${message}.`);
  });
});

const contactForm = document.getElementById("contactForm");
contactForm.addEventListener("submit", (event) => {
  event.preventDefault();
  const formData = new FormData(contactForm);
  const nama = formData.get("nama");
  const pesan = formData.get("pesan");
  const message = `Halo Pemancingan AURI, saya ${nama}. ${pesan}`;
  openWhatsApp(message);
  contactForm.reset();
});
