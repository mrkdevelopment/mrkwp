/**
 * MRK WP — Dynamic Table of Contents (TOC) with ScrollSpy
 *
 * Automatically generates a structured Table of Contents from h2 and h3
 * headings within the article content container. Handles active section
 * highlighting, smooth scrolling, and mobile accordion toggle.
 *
 * @package MRK_WP
 */

(function () {
  'use strict';

  function initTableOfContents() {
    const tocWidget = document.getElementById('post-toc');
    const tocList = document.getElementById('post-toc-list');
    const tocToggle = document.querySelector('.post-toc-toggle');
    const tocBadge = document.querySelector('.post-toc-badge');

    if (!tocWidget || !tocList) {
      return;
    }

    // Locate the article content container
    const contentArea =
      document.querySelector('.post-content-card .wp-block-post-content') ||
      document.querySelector('.post-content-card') ||
      document.querySelector('.entry-content');

    if (!contentArea) {
      tocWidget.style.display = 'none';
      return;
    }

    // Determine heading selector: custom widget attribute, product single body class, or default to 'h2, h3'
    const headingSelector =
      tocWidget.dataset.headings ||
      (document.body.classList.contains('single-wp-product') ? 'h2' : 'h2, h3');

    // Extract matching headings within post content
    const headings = Array.from(contentArea.querySelectorAll(headingSelector)).filter(
      (heading) => {
        // Exclude headings marked to be ignored or inside hidden elements
        return (
          !heading.closest('.no-toc') &&
          !heading.classList.contains('no-toc') &&
          heading.textContent.trim().length > 0
        );
      }
    );

    // If fewer than 2 headings exist, hide the TOC widget gracefully
    if (headings.length < 2) {
      tocWidget.style.display = 'none';
      return;
    }

    // Update section count badge
    if (tocBadge) {
      tocBadge.textContent = `${headings.length} ${headings.length === 1 ? 'part' : 'parts'}`;
    }

    // Generate unique slug IDs and build TOC list items
    const usedIds = new Set();
    const tocFragment = document.createDocumentFragment();
    const tocLinks = [];

    headings.forEach((heading, index) => {
      let slug = heading.id;

      if (!slug) {
        // Build URL-friendly kebab-case ID from heading text
        const baseSlug =
          heading.textContent
            .toLowerCase()
            .trim()
            .replace(/[\s\W-]+/g, '-')
            .replace(/^-+|-+$/g, '') || `section-${index + 1}`;

        slug = baseSlug;
        let counter = 2;
        while (usedIds.has(slug) || document.getElementById(slug)) {
          slug = `${baseSlug}-${counter}`;
          counter++;
        }
        heading.id = slug;
      }

      usedIds.add(slug);

      const level = heading.tagName.toLowerCase(); // 'h2' or 'h3'
      const listItem = document.createElement('li');
      listItem.className = `post-toc-item post-toc-item--${level}`;

      const link = document.createElement('a');
      link.href = `#${slug}`;
      link.className = `post-toc-link post-toc-link--${level}`;
      link.textContent = heading.textContent.trim();

      // Smooth scroll click handler
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetElement = document.getElementById(slug);
        if (targetElement) {
          const headerOffset = 110;
          const elementPosition = targetElement.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth',
          });

          // Update URL hash without jumping
          if (history.pushState) {
            history.pushState(null, '', `#${slug}`);
          }

          // Close mobile accordion after clicking a link
          if (window.innerWidth <= 960 && tocWidget.classList.contains('is-open')) {
            tocWidget.classList.remove('is-open');
            if (tocToggle) {
              tocToggle.setAttribute('aria-expanded', 'false');
            }
          }
        }
      });

      listItem.appendChild(link);
      tocFragment.appendChild(listItem);
      tocLinks.push({ heading, link });
    });

    tocList.innerHTML = '';
    tocList.appendChild(tocFragment);

    // ------------------------------------------------------------------------
    // Mobile Accordion Toggle
    // ------------------------------------------------------------------------
    if (tocToggle) {
      tocToggle.addEventListener('click', (e) => {
        e.preventDefault();
        const isOpen = tocWidget.classList.toggle('is-open');
        tocToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
    }

    // ------------------------------------------------------------------------
    // ScrollSpy: Real-time Active Heading Highlighting
    // ------------------------------------------------------------------------
    let ticking = false;

    function updateActiveHeading() {
      const scrollY = window.pageYOffset || document.documentElement.scrollTop;
      const headerOffset = 140; // Trigger line slightly below sticky nav
      let currentActive = null;

      for (let i = 0; i < tocLinks.length; i++) {
        const item = tocLinks[i];
        const top = item.heading.getBoundingClientRect().top + scrollY;

        if (scrollY >= top - headerOffset) {
          currentActive = item.link;
        } else {
          break;
        }
      }

      // Default to first item if at the top of article
      if (!currentActive && tocLinks.length > 0 && scrollY > 200) {
        currentActive = tocLinks[0].link;
      }

      tocLinks.forEach((item) => {
        if (item.link === currentActive) {
          item.link.classList.add('is-active');
          item.link.setAttribute('aria-current', 'true');
        } else {
          item.link.classList.remove('is-active');
          item.link.removeAttribute('aria-current');
        }
      });

      ticking = false;
    }

    window.addEventListener(
      'scroll',
      () => {
        if (!ticking) {
          window.requestAnimationFrame(updateActiveHeading);
          ticking = true;
        }
      },
      { passive: true }
    );

    // Initial check on load
    updateActiveHeading();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTableOfContents);
  } else {
    initTableOfContents();
  }
})();
