(() => {
  'use strict';
  const topLink = document.querySelector('.floating-top');
  if (topLink) {
    const updateTop = () => { topLink.hidden = window.scrollY < 600; };
    window.addEventListener('scroll', updateTop, {passive:true});
    updateTop();
    topLink.addEventListener('click', event => {
      event.preventDefault();
      window.scrollTo({top:0, behavior:matchMedia('(prefers-reduced-motion:reduce)').matches?'instant':'smooth'});
      document.querySelector('.site-header .logo').focus({preventScroll:true});
    });
  }

  const menu = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  const resources = document.querySelector('.resources-toggle');
  const panel = document.querySelector('#resources-menu');
  if (menu && nav && resources && panel) {
    function setResources(open, focus = false) { panel.hidden = !open; resources.setAttribute('aria-expanded', String(open)); if (focus) resources.focus(); }
    function setMenu(open, focus = false) { nav.classList.toggle('is-open',open); menu.setAttribute('aria-expanded',String(open)); menu.setAttribute('aria-label',open?'Close navigation':'Open navigation'); if(!open) setResources(false); if(focus) menu.focus(); }
    menu.addEventListener('click',()=>setMenu(menu.getAttribute('aria-expanded')!=='true'));
    resources.addEventListener('click',()=>setResources(panel.hidden));
    document.addEventListener('click',e=>{if(!e.target.closest('.site-header'))setMenu(false);});
    document.addEventListener('keydown',e=>{if(e.key==='Escape'){if(!panel.hidden)setResources(false,true);else if(nav.classList.contains('is-open'))setMenu(false,true);}});
    nav.addEventListener('focusout',e=>{if(e.relatedTarget&&!nav.contains(e.relatedTarget))setResources(false);});
    nav.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));
    matchMedia('(min-width:761px)').addEventListener('change',()=>setMenu(false));
  }
  const yearEl = document.querySelector('#year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();
  document.querySelectorAll('.resource-collection').forEach(section=>{
    const track=section.querySelector('.resource-carousel'),prev=section.querySelector('.carousel-prev'),next=section.querySelector('.carousel-next');
    const update=()=>{prev.disabled=track.scrollLeft<2;next.disabled=track.scrollLeft+track.clientWidth>=track.scrollWidth-2;};
    prev.addEventListener('click',()=>track.scrollBy({left:-track.clientWidth*.86,behavior:matchMedia('(prefers-reduced-motion:reduce)').matches?'instant':'smooth'}));
    next.addEventListener('click',()=>track.scrollBy({left:track.clientWidth*.86,behavior:matchMedia('(prefers-reduced-motion:reduce)').matches?'instant':'smooth'}));
    track.addEventListener('scroll',update,{passive:true});new ResizeObserver(update).observe(track);update();
  });
  async function copy(text,status){try{await navigator.clipboard.writeText(text);status.textContent='Copied. Ready to paste.';}catch{status.textContent='Select the text above and copy it to continue.';}}
  document.querySelector('#copy-prompt')?.addEventListener('click',()=>copy(document.querySelector('#prompt-text').textContent,document.querySelector('#copy-status')));
  const form=document.querySelector('#enquiry-form');
  if(form){
    if(new URLSearchParams(location.search).get('interest')==='advisory')document.querySelector('#contact-interest').value='advisory';
    const result=document.querySelector('#enquiry-result'),summary=document.querySelector('#enquiry-summary');
    form.addEventListener('submit',e=>{e.preventDefault();const data=new FormData(form);summary.textContent=`Name: ${data.get('name')}\nEmail: ${data.get('email')}\nInterest: ${data.get('interest')}\n\n${data.get('message')}`;form.hidden=true;result.hidden=false;result.querySelector('h3').focus();});
    document.querySelector('#copy-enquiry').addEventListener('click',()=>copy(summary.textContent,document.querySelector('#enquiry-copy-status')));
    document.querySelector('#edit-enquiry').addEventListener('click',()=>{result.hidden=true;form.hidden=false;form.querySelector('input').focus();});
  }
  document.querySelectorAll('.tool-filter').forEach(button=>button.addEventListener('click',()=>{document.querySelectorAll('.tool-filter').forEach(b=>b.setAttribute('aria-pressed',String(b===button)));let count=0;document.querySelectorAll('.tool-card').forEach(card=>{card.hidden=button.dataset.category!=='all'&&card.dataset.category!==button.dataset.category;if(!card.hidden)count++;});document.querySelector('#tool-count').textContent=`${count} tools`; }));
})();
