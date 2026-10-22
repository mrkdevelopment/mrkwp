/**
 * MRK WP Video Popover Lightbox
 *
 * Provides a resilient, accessible, high-performance modal lightbox
 * for embedded GreenShift YouTube videos and YouTube Shorts.
 *
 * @package MRKWP_Theme
 */
(() => {
  'use strict';

  function extractYouTubeId(url) {
    if (!url) return '';
    const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?vi?=|(?:embed|v|vi|user)\/|shorts\/|live\/))([^?&"'>]+)/);
    return match ? match[1] : '';
  }

  function initVideoLightbox() {
    const overlays = document.querySelectorAll('.wp-block-greenshift-blocks-video .gs-video-overlay, .gs-video .gs-video-overlay');

    if (!overlays.length) return;

    // Create modal DOM container once
    let modal = document.getElementById('mrkwp-video-modal');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'mrkwp-video-modal';
      modal.className = 'mrkwp-video-lightbox';
      modal.setAttribute('role', 'dialog');
      modal.setAttribute('aria-modal', 'true');
      modal.setAttribute('aria-label', 'Video Player');
      modal.innerHTML = `
        <button type="button" class="mrkwp-lightbox-close" aria-label="Close video player">×</button>
        <div class="mrkwp-lightbox-dialog"></div>
      `;
      document.body.appendChild(modal);

      // Close handlers
      const closeBtn = modal.querySelector('.mrkwp-lightbox-close');
      const closeModal = () => {
        modal.classList.remove('is-active');
        const dialog = modal.querySelector('.mrkwp-lightbox-dialog');
        if (dialog) dialog.innerHTML = '';
        document.body.style.overflow = '';
        if (modal._activeTrigger) {
          modal._activeTrigger.focus();
          modal._activeTrigger = null;
        }
      };

      closeBtn.addEventListener('click', closeModal);
      modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-active')) {
          closeModal();
        }
      });
    }

    overlays.forEach((overlay) => {
      // Ensure overlay is accessible
      if (!overlay.getAttribute('tabindex')) overlay.setAttribute('tabindex', '0');
      if (!overlay.getAttribute('role')) overlay.setAttribute('role', 'button');
      if (!overlay.getAttribute('aria-label')) overlay.setAttribute('aria-label', 'Play video');

      const triggerPlayback = (e) => {
        // Prevent double trigger if SimpleLightbox opened
        if (document.querySelector('.slbElement.slbActive')) return;

        const wrapper = overlay.closest('.gs-video-wrapper');
        const videoBlock = overlay.closest('.wp-block-greenshift-blocks-video, .gs-video');
        if (!wrapper) return;

        const iframe = wrapper.querySelector('iframe.gs-video-element, .gs-video-element');
        let videoUrl = overlay.dataset.videoUrl || iframe?.dataset?.src || iframe?.getAttribute('data-data-src') || iframe?.src || '';
        let videoId = overlay.dataset.videoId || extractYouTubeId(videoUrl);

        if (!videoId) {
          videoId = extractYouTubeId(wrapper.closest('.video-panel')?.innerHTML || '');
        }

        if (!videoId) return;

        e.preventDefault();
        e.stopPropagation();

        const isShort = videoBlock?.classList.contains('is-short-video') || wrapper.style.aspectRatio?.includes('9/16') || videoUrl.includes('/shorts/');
        const dialog = modal.querySelector('.mrkwp-lightbox-dialog');
        
        dialog.className = 'mrkwp-lightbox-dialog' + (isShort ? ' is-short' : '');
        dialog.innerHTML = `
          <iframe 
            src="https://www.youtube-nocookie.com/embed/${encodeURIComponent(videoId)}?autoplay=1&rel=0&modestbranding=1&playsinline=1" 
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            allowfullscreen>
          </iframe>
        `;

        modal._activeTrigger = overlay;
        modal.classList.add('is-active');
        document.body.style.overflow = 'hidden';

        const closeBtn = modal.querySelector('.mrkwp-lightbox-close');
        if (closeBtn) closeBtn.focus();
      };

      // Click & Keyboard support
      overlay.addEventListener('click', triggerPlayback, true);
      overlay.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          triggerPlayback(e);
        }
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVideoLightbox);
  } else {
    initVideoLightbox();
  }
})();
