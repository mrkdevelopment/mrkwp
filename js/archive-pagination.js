/**
 * MRK WP Archive Pagination: Load More (Desktop) + Infinite Scroll (Mobile)
 *
 * Progressively enhances standard WordPress Query Pagination into a modern hybrid:
 * - Desktop (>= 761px): 'Load More' button at the bottom of the grid.
 * - Mobile (< 761px): Native IntersectionObserver auto-scroll loading.
 * - URL State: Updates browser address bar (history.replaceState) so bookmarks and back button work.
 * - SEO / GEO: 100% crawlable because the original semantic <nav> pagination remains in the SSR HTML.
 *
 * @package MRKWP_Theme
 */
(() => {
  'use strict';

  function initArchivePagination() {
    // Find all query blocks with query pagination on the page
    const queryBlocks = document.querySelectorAll('.wp-block-query');
    if (!queryBlocks.length) return;

    queryBlocks.forEach((queryBlock) => {
      // Avoid initializing twice
      if (queryBlock.dataset.mrkwpPaginationInit) return;

      const grid = queryBlock.querySelector('.wp-block-post-template');
      const pagination = queryBlock.querySelector('.wp-block-query-pagination');
      if (!grid || !pagination) return;

      // Find the 'Next' link
      const nextLink = pagination.querySelector('.wp-block-query-pagination-next, a.next.page-numbers');
      if (!nextLink || !nextLink.href) return;

      queryBlock.dataset.mrkwpPaginationInit = 'true';

      let nextUrl = nextLink.href;
      let isLoading = false;
      let autoScrollPagesCount = 0;
      const MAX_AUTO_SCROLL_PAGES = 3; // Pause auto-scrolling on mobile after 3 batches so footer remains reachable

      // Determine post type or label for button text
      const isVideoArchive = queryBlock.closest('.video-archive-section') || grid.classList.contains('videos-grid');
      const isShortArchive = queryBlock.closest('.short-archive-section') || grid.classList.contains('shorts-grid');
      const itemLabel = isVideoArchive ? 'Videos' : (isShortArchive ? 'Shorts' : 'Posts');

      // Add enhancement class so CSS cleanly hides standard pagination
      queryBlock.classList.add('is-enhanced-query');

      // Create loader UI container
      const loaderWrap = document.createElement('div');
      loaderWrap.className = 'mrkwp-archive-loader is-infinite-mode';
      loaderWrap.innerHTML = `
        <button type="button" class="mrkwp-load-more-btn" aria-label="Load more ${itemLabel}">
          <span class="mrkwp-load-more-label">Load More ${itemLabel}</span>
          <span class="mrkwp-load-more-spinner" aria-hidden="true"></span>
        </button>
        <div class="mrkwp-infinite-sentinel" aria-hidden="true"></div>
        <p class="mrkwp-archive-end-message" style="display:none;" role="status">You've reached the end of the ${itemLabel.toLowerCase()} library.</p>
      `;

      // Insert loader right after grid and before pagination
      grid.parentNode.insertBefore(loaderWrap, pagination);

      const loadMoreBtn = loaderWrap.querySelector('.mrkwp-load-more-btn');
      const loadMoreLabel = loaderWrap.querySelector('.mrkwp-load-more-label');
      const sentinel = loaderWrap.querySelector('.mrkwp-infinite-sentinel');
      const endMessage = loaderWrap.querySelector('.mrkwp-archive-end-message');

      const isMobile = () => window.innerWidth <= 760;

      // Async fetch next page
      async function fetchNextPage() {
        if (isLoading || !nextUrl) return;

        isLoading = true;
        loadMoreBtn.setAttribute('aria-busy', 'true');
        loadMoreLabel.textContent = `Loading ${itemLabel.toLowerCase()}...`;
        if (isMobile()) {
          loaderWrap.classList.add('is-loading-mobile');
        }

        try {
          const response = await fetch(nextUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          });

          if (!response.ok) {
            throw new Error(`HTTP error ${response.status}`);
          }

          const html = await response.text();
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');

          const newGrid = doc.querySelector('.wp-block-post-template');
          const newPagination = doc.querySelector('.wp-block-query-pagination');

          if (!newGrid) {
            throw new Error('New content grid not found');
          }

          const newItems = Array.from(newGrid.children);
          if (newItems.length > 0) {
            const fragment = document.createDocumentFragment();

            newItems.forEach((item, index) => {
              item.classList.add('mrkwp-card-animating');
              item.style.animationDelay = `${(index % 3) * 60}ms`;
              fragment.appendChild(item);
            });

            grid.appendChild(fragment);

            // Update URL without page reload
            history.replaceState({ pageUrl: nextUrl }, '', nextUrl);
            autoScrollPagesCount++;

            // Dispatch custom event in case anything wants to hook newly appended items
            document.dispatchEvent(new CustomEvent('mrkwp:content-loaded', {
              detail: { count: newItems.length, url: nextUrl }
            }));
          }

          // Check for next pagination URL in the fetched document
          const newNextLink = newPagination ? newPagination.querySelector('.wp-block-query-pagination-next, a.next.page-numbers') : null;
          if (newNextLink && newNextLink.href) {
            nextUrl = newNextLink.href;

            // If on mobile and reached MAX_AUTO_SCROLL_PAGES, switch to manual button to unblock footer
            if (isMobile() && autoScrollPagesCount >= MAX_AUTO_SCROLL_PAGES) {
              loaderWrap.classList.remove('is-infinite-mode');
              if (observer) observer.unobserve(sentinel);
            }
          } else {
            // Reached the end
            nextUrl = null;
            loadMoreBtn.style.display = 'none';
            if (observer) observer.disconnect();
            endMessage.style.display = 'block';
          }

        } catch (err) {
          console.warn('[MRK WP] Error loading next page:', err);
          loadMoreLabel.textContent = 'Retry loading';
          loaderWrap.classList.remove('is-infinite-mode'); // Reveal button so user can tap to retry
        } finally {
          isLoading = false;
          loadMoreBtn.removeAttribute('aria-busy');
          if (nextUrl) {
            loadMoreLabel.textContent = `Load More ${itemLabel}`;
          }
          loaderWrap.classList.remove('is-loading-mobile');
        }
      }

      // Click handler for Desktop Load More
      loadMoreBtn.addEventListener('click', (e) => {
        e.preventDefault();
        fetchNextPage();
      });

      // IntersectionObserver for Mobile Infinite Scroll
      let observer = null;
      if ('IntersectionObserver' in window) {
        observer = new IntersectionObserver((entries) => {
          const entry = entries[0];
          if (entry && entry.isIntersecting) {
            if (isMobile() && loaderWrap.classList.contains('is-infinite-mode')) {
              fetchNextPage();
            }
          }
        }, {
          root: null,
          rootMargin: '400px 0px',
          threshold: 0.01
        });

        observer.observe(sentinel);
      }

      // Responsive listener
      window.addEventListener('resize', () => {
        if (!isMobile()) {
          loaderWrap.classList.remove('is-infinite-mode');
        } else if (autoScrollPagesCount < MAX_AUTO_SCROLL_PAGES && nextUrl) {
          loaderWrap.classList.add('is-infinite-mode');
          if (observer) observer.observe(sentinel);
        }
      }, { passive: true });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initArchivePagination);
  } else {
    initArchivePagination();
  }
})();
