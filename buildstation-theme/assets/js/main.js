/**
 * Buildstation Interactive UI Engine & Motion Graphics
 * Lightweight, zero-dependency, brand-strict client script
 */
document.addEventListener('DOMContentLoaded', () => {
  // 1. Mobile drawer toggle
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

  // 2. Terminal pill click-to-copy
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

  // 3. Motion Graphic: Live Telemetry Monospace Stream
  const telemetryElement = document.getElementById('bsTelemetryStream');
  if (telemetryElement) {
    const telemetryLogs = [
      "vLLM :: Qwen2.5-Coder-7B-Instruct (Q4_K_M) → 48.6 tok/s [VRAM 6.8 GB / 16.0 GB]",
      "ollama :: Mistral-Nemo-12B (Q4_K_M) → 31.4 tok/s [VRAM 9.2 GB / 16.0 GB]",
      "llama.cpp :: DeepSeek-Coder-V2-Lite (Q3_K_M) → 22.8 tok/s [VRAM 13.9 GB / 16.0 GB]",
      "vLLM :: Starcoder2-15B (AWQ) → 26.5 tok/s [VRAM 12.1 GB / 16.0 GB]",
      "ollama :: Llama-3.1-8B-Instruct (Q8_0) → 38.2 tok/s [VRAM 9.8 GB / 16.0 GB]",
      "aider :: AutoCodeRover + vLLM on SWE-bench lite → 28.4% [pass@1]"
    ];

    let logIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let currentLog = telemetryLogs[0];
    let typeSpeed = 35;

    function typeTelemetry() {
      currentLog = telemetryLogs[logIndex];

      if (!isDeleting) {
        telemetryElement.textContent = currentLog.substring(0, charIndex + 1);
        charIndex++;

        if (charIndex === currentLog.length) {
          // Pause at completed string
          isDeleting = true;
          setTimeout(typeTelemetry, 3500);
          return;
        }
      } else {
        // Fast backspace
        telemetryElement.textContent = currentLog.substring(0, charIndex - 1);
        charIndex--;

        if (charIndex === 0) {
          isDeleting = false;
          logIndex = (logIndex + 1) % telemetryLogs.length;
          setTimeout(typeTelemetry, 400);
          return;
        }
      }

      const nextInterval = isDeleting ? 12 : typeSpeed;
      setTimeout(typeTelemetry, nextInterval);
    }

    // Start telemetry typing after initial hero entry
    setTimeout(typeTelemetry, 1200);
  }

  // 4. URL query notification check (?subscribed=1 or ?error=...)
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('subscribed')) {
    showToast('Subscribed! One email per video, zero spam.');
    const statusBox = document.querySelector('.bs-subscribe-status');
    if (statusBox) {
      statusBox.innerHTML = '<span style="color:var(--urgent)">✓ Subscribed! One email per video, zero spam.</span>';
      statusBox.style.display = 'block';
    }
  } else if (urlParams.has('error')) {
    showToast('Please enter a valid email address.');
  }

  // 5. Robust Newsletter form submission
  const subscribeForms = document.querySelectorAll('.bs-subscribe-form');
  subscribeForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const input = form.querySelector('input[type="email"]');
      const email = input?.value?.trim();
      const statusBox = form.querySelector('.bs-subscribe-status');

      if (!email || !validateEmail(email)) {
        showToast('Please enter a valid email address.');
        if (statusBox) {
          statusBox.innerHTML = '<span style="color:#ef4444">Please enter a valid email address.</span>';
          statusBox.style.display = 'block';
        }
        return;
      }

      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'recording...';
      submitBtn.disabled = true;

      const endpoint = (window.buildstation_ajax && window.buildstation_ajax.url)
        ? window.buildstation_ajax.url
        : (form.action || '/wp-admin/admin-ajax.php');

      try {
        const formData = new FormData(form);
        if (!formData.get('action')) {
          formData.append('action', 'buildstation_subscribe');
        }
        if (window.buildstation_ajax && window.buildstation_ajax.nonce && !formData.get('nonce')) {
          formData.append('nonce', window.buildstation_ajax.nonce);
        }
        formData.append('is_ajax', '1');

        const response = await fetch(endpoint, {
          method: 'POST',
          body: formData,
          headers: {
            'Accept': 'application/json'
          }
        });

        if (!response.ok) {
          throw new Error(`HTTP error ${response.status}`);
        }

        const result = await response.json();
        if (result.success) {
          const msg = result.data?.message || 'Subscribed! One email per video, zero spam.';
          showToast(msg);
          if (statusBox) {
            statusBox.innerHTML = `<span style="color:var(--urgent)">✓ ${msg}</span>`;
            statusBox.style.display = 'block';
          }
          input.value = '';
        } else {
          const errMsg = result.data?.message || 'Subscription failed. Please check your email.';
          showToast(errMsg);
          if (statusBox) {
            statusBox.innerHTML = `<span style="color:#ef4444">${errMsg}</span>`;
            statusBox.style.display = 'block';
          }
        }
      } catch (err) {
        console.warn('AJAX subscription error, attempting form submit fallback:', err);
        // Fallback to standard HTTP form POST
        form.submit();
        return;
      }

      submitBtn.textContent = originalText;
      submitBtn.disabled = false;
    });
  });

  // 6. Toast notification helper
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
    }, 4000);
  }

  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
});
