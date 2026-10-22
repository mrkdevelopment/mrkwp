/* Optional, locally hosted motion. The page is fully visible before this loads. */
(() => {
  'use strict';
  const assetBase = new URL('.', document.currentScript.src);
  const preference = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (preference.matches || navigator.connection?.saveData) return;

  function initialize() {
    if (!window.gsap || preference.matches || navigator.connection?.saveData) return;
    const gsap = window.gsap;
    const scroll = window.ScrollTrigger;
    if (scroll) gsap.registerPlugin(scroll);
    const media = gsap.matchMedia();
    media.add('(prefers-reduced-motion: no-preference)', context => {
      const observers = [];
      const reveal = context.add('reveal', (elements, options = {}) => {
        gsap.from(elements, { opacity: 0, y: 20, duration: .75, stagger: .08, ease: 'power2.out', clearProps: 'opacity,transform', ...options });
      });
      // Animate only content in view, so a failed optional library never hides it.
      if (window.scrollY < 60) {
        if(document.querySelector('.hero-copy')) reveal('.hero-copy > *', { y: 15, duration: .7, stagger: .07 });
        if (document.querySelector('.portrait-stage')) {
          gsap.from('.portrait-backplate', {rotationY:-18, rotationX:7, scale:.93, opacity:0, duration:1.15, ease:'power3.out', clearProps:'transform,opacity'});
          gsap.from('.hero-portrait', {y:55, rotationY:12, rotationX:-5, opacity:0, duration:1.25, delay:.12, ease:'power3.out', clearProps:'transform,opacity'});
          gsap.from('.portrait-note', {y:24, rotationY:-25, opacity:0, duration:.8, delay:.55, ease:'power3.out', clearProps:'transform,opacity'});
          reveal('.portrait-signature', {y:12,delay:.65});
        }
        if(document.querySelector('.page-intro')) reveal('.page-intro > *', {y:18,stagger:.09});
      }
      if ('IntersectionObserver' in window) {
        const observe = (element, callback, margin = '-65px') => {
          const observer = new IntersectionObserver(entries => {
            if (!entries.some(entry => entry.isIntersecting)) return;
            callback();
            observer.disconnect();
          }, { threshold: 0, rootMargin: `0px 0px ${margin} 0px` });
          observer.observe(element);
          observers.push(observer);
        };
        document.querySelectorAll('.section-heading, .assessment-copy, .assessment-card, .about-editorial, .path-card, .content-card, .community-invite, .about-detail, .price-panel, .community-manifesto').forEach(element => {
          observe(element, () => reveal(element, { y: 24, duration: .8 }));
        });
        const bento = document.querySelector('.belief-strip');
        if (bento) observe(bento, context.add('bentoReveal', () => {
          gsap.from('.belief-card', {opacity:0,y:38,rotationX:8,transformOrigin:'50% 100%',duration:.85,stagger:.13,ease:'power3.out',clearProps:'opacity,transform'});
          gsap.from('.bento-symbol', {rotation:-90,scale:.7,duration:1.2,delay:.2,ease:'power3.out',clearProps:'transform'});
          reveal(bento.querySelectorAll('.belief-card .icon'), {y:12,delay:.45,stagger:.15});
        }));
        document.querySelectorAll('.comparison-row').forEach(element => {
          observe(element, () => reveal(element, { y: 15, duration: .6 }));
        });
        document.querySelectorAll('.process-step').forEach(step => {
          observe(step, context.add(`process_${step.dataset.process}`, () => {
            step.classList.add('is-active');
            reveal(step.querySelector('.process-copy'), { y: 23, duration: .8 });
            reveal(step.querySelector('.process-visual'), { y: 32, duration: .95, delay: .1 });
            if (step.dataset.process === 'capture') {
              const wave = step.querySelector('.voice-wave path');
              const length = wave.getTotalLength();
              gsap.fromTo(wave, { strokeDasharray: length, strokeDashoffset: length }, { strokeDashoffset: 0, duration: 1.4, delay: .25, ease: 'power2.out', clearProps: 'strokeDasharray,strokeDashoffset' });
              reveal(step.querySelector('.voice-document'), { y: 12, delay: .45, duration: .7 });
            } else if (step.dataset.process === 'optimize') {
              reveal(step.querySelectorAll('.architecture-layer'), { y: 15, duration: .75, delay: .2, stagger: .14 });
            } else {
              reveal(step.querySelectorAll('.workflow-source, .workflow-outputs > div'), { y: 12, duration: .65, delay: .2, stagger: .14 });
            }
          }), '-95px');
        });
      }
      if (scroll && document.querySelector('.process-journey')) {
        gsap.fromTo('.journey-line > span', { scaleY: 0 }, {
          scaleY: 1, ease: 'none',
          scrollTrigger: { trigger: '.process-journey', start: 'top 60%', end: 'bottom 65%', scrub: .5 }
        });
      }
      const onFormStep = context.add('formStep', () => {
        const active = document.querySelector('#result:not([hidden]), .form-step:not([hidden])');
        if (active) gsap.fromTo(active, { opacity: 0, y: 7 }, { opacity: 1, y: 0, duration: .3, ease: 'power2.out', clearProps: 'opacity,transform', overwrite: true });
      });
      document.addEventListener('assessment:step', onFormStep);
      return () => {
        observers.forEach(observer => observer.disconnect());
        document.removeEventListener('assessment:step', onFormStep);
        document.querySelectorAll('.process-step').forEach(step => step.classList.remove('is-active'));
      };
    });
  }

  function load() {
    if (preference.matches || navigator.connection?.saveData) return;
    const vendorBase = window.mrkwpTheme?.vendorUrl || (new URL('../vendor/', assetBase)).href;
    const script = document.createElement('script');
    script.src = new URL('gsap.min.js', vendorBase).href;
    script.async = true;
    script.onload = () => {
      if (preference.matches || navigator.connection?.saveData) return;
      const plugin = document.createElement('script');
      plugin.src = new URL('ScrollTrigger.min.js', vendorBase).href;
      plugin.async = true;
      plugin.onload = initialize;
      plugin.onerror = initialize;
      document.head.append(plugin);
    };
    document.head.append(script);
  }
  if ('requestIdleCallback' in window) requestIdleCallback(load, { timeout: 1200 });
  else setTimeout(load, 150);
})();
