document.addEventListener('DOMContentLoaded', function() {
  const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
  const nav = document.querySelector('nav');
  
  if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      nav.classList.toggle('active');
      this.classList.toggle('active');
      if (this.classList.contains('active')) {
        this.classList.remove('bx-menu');
        this.classList.add('bx-x');
      } else {
        this.classList.remove('bx-x');
        this.classList.add('bx-menu');
      }
    });
    
    document.querySelectorAll('nav ul li a').forEach(link => {
      link.addEventListener('click', function() {
        nav.classList.remove('active');
        mobileMenuBtn.classList.remove('active');
        mobileMenuBtn.classList.remove('bx-x');
        mobileMenuBtn.classList.add('bx-menu');
      });
    });
  }
  
  const navLinks = document.querySelectorAll('nav ul li a');
  navLinks.forEach(link => {
    if (link.href === window.location.href) {
      link.classList.add('active');
    }
  });
  
  const faqQuestions = document.querySelectorAll('.faq-question');
  faqQuestions.forEach(question => {
    question.addEventListener('click', function() {
      const faqItem = this.parentElement;
      const isActive = faqItem.classList.contains('active');
      document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
      });
      if (!isActive) {
        faqItem.classList.add('active');
      }
    });
  });
  
  const counters = document.querySelectorAll('.stat-number');
  const animateCounter = (counter) => {
    const target = parseInt(counter.getAttribute('data-target'));
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    const updateCounter = () => {
      current += step;
      if (current < target) {
        counter.textContent = Math.floor(current);
        requestAnimationFrame(updateCounter);
      } else {
        counter.textContent = target;
      }
    };
    updateCounter();
  };
  
  const observerOptions = { threshold: 0.5 };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const counter = entry.target;
        if (!counter.classList.contains('counted')) {
          counter.classList.add('counted');
          animateCounter(counter);
        }
      }
    });
  }, observerOptions);
  
  counters.forEach(counter => observer.observe(counter));
  
  window.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (window.scrollY > 100) {
      header.style.background = 'rgba(255, 255, 255, 0.98)';
    } else {
      header.style.background = 'var(--white)';
    }
  });
  
  document.querySelectorAll('img').forEach(img => {
    if (img.complete) {
      img.classList.add('loaded');
    } else {
      img.addEventListener('load', function() {
        this.classList.add('loaded');
      });
      img.addEventListener('error', function() {
        this.classList.add('loaded');
      });
    }
  });
  
  const fadeElements = document.querySelectorAll('.fade-in, .model-card, .card, .formation-card, .stat-item');
  const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
  
  fadeElements.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    fadeObserver.observe(el);
  });

  // Typewriter Animation for About Section
  const typewriterElements = document.querySelectorAll('.typewriter-text');
  
  typewriterElements.forEach(element => {
    const originalHTML = element.innerHTML;
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = originalHTML;
    
    let chars = [];
    
    function processNode(node) {
      if (node.nodeType === Node.TEXT_NODE) {
        const text = node.textContent;
        for (let i = 0; i < text.length; i++) {
          chars.push({ char: text[i], isTag: false });
        }
      } else if (node.nodeType === Node.ELEMENT_NODE) {
        chars.push({ char: `<${node.tagName.toLowerCase()}>`, isTag: true, isOpen: true });
        node.childNodes.forEach(child => processNode(child));
        chars.push({ char: `</${node.tagName.toLowerCase()}>`, isTag: true, isOpen: false });
      }
    }
    
    tempDiv.childNodes.forEach(node => processNode(node));
    
    let newHTML = '';
    let tagStack = [];
    
    chars.forEach((item, index) => {
      if (item.isTag) {
        newHTML += item.char;
        if (item.isOpen) {
          tagStack.push(item.char.replace('<', '').replace('>', ''));
        } else {
          tagStack.pop();
        }
      } else {
        if (item.char === ' ') {
          newHTML += ' ';
        } else {
          newHTML += `<span class="char" data-index="${index}">${item.char}</span>`;
        }
      }
    });
    
    element.innerHTML = newHTML;
    
    const charSpans = element.querySelectorAll('.char');
    
    const typewriterObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !element.classList.contains('animated')) {
          element.classList.add('animated');
          
          charSpans.forEach((span, index) => {
            setTimeout(() => {
              span.classList.add('visible');
            }, index * 15);
          });
          
          typewriterObserver.unobserve(element);
        }
      });
    }, { threshold: 0.3 });
    
    typewriterObserver.observe(element);
  });

  window.openPartyGallery = function() {
    const modal = document.getElementById('partyGalleryModal');
    if (modal) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  };

  window.closePartyGallery = function() {
    const modal = document.getElementById('partyGalleryModal');
    if (modal) {
      modal.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  };

  const partyModal = document.getElementById('partyGalleryModal');
  if (partyModal) {
    partyModal.addEventListener('click', function(e) {
      if (e.target === this) {
        closePartyGallery();
      }
    });
  }

  // Video Playlist Auto-Play
  let currentVideoIndex = 1;
  const maxVideos = 2;
  
  const playNextVideo = () => {
    const videoId = `playlist-video-${currentVideoIndex}`;
    const videoIframe = document.getElementById(videoId);
    
    if (videoIframe) {
      const src = videoIframe.src;
      const baseUrl = src.split('?')[0];
      videoIframe.src = baseUrl + '?autoplay=1&mute=1';
      
      currentVideoIndex = currentVideoIndex === maxVideos ? 1 : currentVideoIndex + 1;
      
      setTimeout(() => {
        playNextVideo();
      }, 30000);
    }
  };

  setTimeout(() => {
    playNextVideo();
  }, 100);
});
