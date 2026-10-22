/* All assessment answers remain in memory. No network submission or storage. */
(() => {
  'use strict';
  const form = document.querySelector('#readiness-form');
  const steps = [...document.querySelectorAll('.form-step')];
  const progress = [...document.querySelectorAll('.assessment-progress li')];
  const next = document.querySelector('#next');
  const back = document.querySelector('#back');
  const result = document.querySelector('#result');
  const website = document.querySelector('#website');
  const industry = document.querySelector('#industry');
  const outcome = document.querySelector('#outcome');
  const count = document.querySelector('#step-count');
  let current = 0;
  let recommendation = '';
  const arrow = '<svg class="icon" aria-hidden="true"><use href="#i-arrow"/></svg>';

  function render(focus = false) {
    steps.forEach((step, index) => {
      step.hidden = index !== current;
      step.disabled = index !== current;
    });
    progress.forEach((item, index) => {
      item.classList.toggle('is-current', index === current);
      item.classList.toggle('is-complete', index < current);
      if (index === current) item.setAttribute('aria-current', 'step');
      else item.removeAttribute('aria-current');
    });
    count.textContent = `0${current + 1} / 03`;
    back.hidden = current === 0;
    next.innerHTML = `${current === 2 ? 'Prepare my assessment' : 'Continue'} ${arrow}`;
    if (focus) steps[current].querySelector('h3').focus({ preventScroll: true });
    form.dispatchEvent(new CustomEvent('assessment:step', { bubbles: true }));
  }

  function validateWebsite() {
    const value = website.value.trim();
    try {
      const url = new URL(/^[a-z][a-z\d+.-]*:/i.test(value) ? value : `https://${value}`);
      if (!['http:', 'https:'].includes(url.protocol) || !url.hostname.includes('.') || url.username || url.password || /\s/.test(value)) throw new Error('Invalid website');
      website.value = url.href.replace(/\/$/, '');
      website.setCustomValidity('');
      return true;
    } catch {
      website.setCustomValidity('Enter a website address, such as yourwebsite.com.');
      website.reportValidity();
      return false;
    }
  }
  website.addEventListener('input', () => website.setCustomValidity(''));
  const getChallenge = () => form.querySelector('input[name="bottleneck"]:checked')?.value || '';
  const recommendations = {
    'Traffic and AI search visibility': 'Start with a content and discovery audit. Review how clearly your site explains your expertise, then map the structured knowledge that will help search and AI tools understand it.',
    'Site speed and performance': 'Start with a performance audit. Identify what slows your key pages, then prioritize the improvements that make the biggest difference to the people using your site.',
    'Maintenance costs and plugin bloat': 'Start with an infrastructure audit. Map the plugins and services your site relies on, identify overlap, and plan a simpler foundation your team can maintain.',
    'Content creation and distribution': 'Start by mapping your audience and content workflow. Capture your brand voice, then build a practical path from one useful insight to the channels your buyers use.'
  };

  form.addEventListener('submit', event => {
    event.preventDefault();
    if (current === 0 && !validateWebsite()) return;
    if (current < 2) {
      current += 1;
      render(true);
      return;
    }
    // Native validation has already checked required fields and minimum length.
    const challenge = getChallenge();
    recommendation = recommendations[challenge];
    document.querySelector('#result-text').textContent = recommendation;
    document.querySelector('#result-website').textContent = website.value;
    document.querySelector('#result-focus').textContent = challenge;
    form.hidden = true;
    result.hidden = false;
    count.textContent = 'Complete';
    progress.forEach(item => {
      item.classList.remove('is-current');
      item.classList.add('is-complete');
      item.removeAttribute('aria-current');
    });
    result.querySelector('h3').focus({ preventScroll: true });
    result.dispatchEvent(new CustomEvent('assessment:step', { bubbles: true }));
  });
  back.addEventListener('click', () => { current = Math.max(0, current - 1); render(true); });
  document.querySelector('#restart').addEventListener('click', () => {
    current = 0;
    result.hidden = true;
    form.hidden = false;
    render(true);
  });
  document.querySelector('#download').addEventListener('click', () => {
    const content = [
      'MRK WP — AI Readiness Assessment',
      '',
      `Website: ${website.value}`,
      `Industry: ${industry.value}`,
      `Biggest challenge: ${getChallenge()}`,
      `Desired outcome: ${outcome.value.trim()}`,
      '',
      'YOUR STARTING POINT',
      recommendation,
      '',
      'Prepared locally in the MRK WP design preview. No application has been submitted.'
    ].join('\n');
    const url = URL.createObjectURL(new Blob([content], { type: 'text/plain;charset=utf-8' }));
    const link = document.createElement('a');
    link.href = url;
    link.download = 'mrk-wp-readiness-assessment.txt';
    document.body.append(link);
    link.click();
    link.remove();
    setTimeout(() => URL.revokeObjectURL(url), 1500);
  });

  render();
})();
