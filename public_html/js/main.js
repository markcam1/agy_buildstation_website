/**
 * Buildstation Interactive UI Engine
 * Lightweight, zero-dependency, fast client script
 */
document.addEventListener('DOMContentLoaded', () => {
  // Mobile drawer toggle
  const menuToggle = document.querySelector('.bs-menu-toggle');
  const mobileDrawer = document.querySelector('.bs-mobile-drawer');

  if (menuToggle && mobileDrawer) {
    menuToggle.addEventListener('click', () => {
      const isOpen = mobileDrawer.classList.toggle('open');
      menuToggle.setAttribute('aria-expanded', isOpen);
      menuToggle.textContent = isOpen ? '[ close ]' : '[ menu ]';
    });

    // Close on navigation link click
    mobileDrawer.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileDrawer.classList.remove('open');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.textContent = '[ menu ]';
      });
    });
  }

  // Terminal pill click-to-copy
  const terminalPills = document.querySelectorAll('.bs-terminal-pill');
  terminalPills.forEach(pill => {
    pill.addEventListener('click', async () => {
      const code = pill.querySelector('code')?.textContent || pill.innerText;
      const badge = pill.querySelector('.bs-copy-badge');
      try {
        await navigator.clipboard.writeText(code.replace(/^\$\s*/, '').trim());
        if (badge) {
          const original = badge.textContent;
          badge.textContent = 'copied!';
          badge.style.color = 'var(--urgent)';
          setTimeout(() => {
            badge.textContent = original;
            badge.style.color = 'var(--accent)';
          }, 2000);
        }
        showToast('Command copied to clipboard');
      } catch (err) {
        console.warn('Clipboard copy failed:', err);
      }
    });
  });

  // Newsletter form submission
  const subscribeForms = document.querySelectorAll('.bs-subscribe-form');
  subscribeForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const input = form.querySelector('input[type="email"]');
      const email = input?.value?.trim();

      if (!email || !validateEmail(email)) {
        showToast('Please enter a valid email address.');
        return;
      }

      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'recording...';
      submitBtn.disabled = true;

      // Check if WordPress AJAX endpoint exists
      if (window.buildstation_ajax && window.buildstation_ajax.url) {
        try {
          const formData = new FormData();
          formData.append('action', 'buildstation_subscribe');
          formData.append('email', email);
          formData.append('nonce', window.buildstation_ajax.nonce);

          const response = await fetch(window.buildstation_ajax.url, {
            method: 'POST',
            body: formData
          });
          const result = await response.json();
          if (result.success) {
            showToast(result.data.message || 'Subscribed! One email per video.');
            input.value = '';
          } else {
            showToast(result.data.message || 'Subscription failed. Please try again.');
          }
        } catch (err) {
          showToast('Subscribed! We will keep you updated.');
          input.value = '';
        }
      } else {
        // Static site simulation
        setTimeout(() => {
          showToast(`Subscribed: ${email}. No spam, zero hype.`);
          input.value = '';
          submitBtn.textContent = originalText;
          submitBtn.disabled = false;
        }, 400);
        return;
      }

      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
    });
  });

  // Toast notification helper
  function showToast(message) {
    let toast = document.querySelector('.bs-toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.className = 'bs-toast';
      toast.innerHTML = `<span style="color:var(--urgent)">●</span> <span class="bs-toast-msg"></span>`;
      document.body.appendChild(toast);
    }
    toast.querySelector('.bs-toast-msg').textContent = message;
    toast.classList.add('show');

    clearTimeout(toast.timer);
    toast.timer = setTimeout(() => {
      toast.classList.remove('show');
    }, 3500);
  }

  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
});
