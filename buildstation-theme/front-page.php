<?php
/**
 * The template for displaying the front page
 *
 * @package Buildstation
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="top">
<section style="max-width: 1200px; margin: 0 auto; padding: 96px 24px 72px; display: flex; flex-wrap: wrap; gap: 56px; align-items: center">
<div style="flex: 1 1 460px; min-width: 0; display: flex; flex-direction: column; gap: 28px">
<div class="bs-terminal-pill" title="Click to copy"><span style="color:#00ff41">$</span> <code>./buildstation --harness aider,openhands,swe-agent --local-only</code> <span class="bs-copy-badge">[copy]</span></div>

<!-- Live Telemetry Ticker (Motion Graphic) -->
<div class="bs-telemetry-bar" aria-label="Real-time benchmark telemetry">
  <span class="bs-telemetry-dot">●</span>
  <span class="bs-telemetry-badge">LIVE BENCHMARK</span>
  <span class="bs-telemetry-stream" id="bsTelemetryStream">vLLM :: Qwen2.5-Coder-7B (Q4_K_M) → 48.6 tok/s [VRAM 6.8GB]</span>
  <span class="bs-telemetry-cursor">_</span>
</div>

<h1 class="bs-hero-heading" style="margin: 0; font-family: Poppins, sans-serif; font-weight: 900; font-size: clamp(28px, 6vw, 76px); line-height: 1.05; letter-spacing: -0.02em; color: #e2e8f0"><span class="bs-settle-word" style="--w-i:0">The</span> <span class="bs-settle-word" style="--w-i:1">leaderboard</span> <span class="bs-settle-word" style="--w-i:2">ran</span> <span class="bs-settle-word" style="--w-i:3">on</span> <span class="bs-settle-word" style="--w-i:4">an</span> <span class="bs-settle-word" style="--w-i:5">H100.</span> <span class="bs-settle-word" style="--w-i:6; font-weight: 600; color: #94a3b8">You</span> <span class="bs-settle-word" style="--w-i:7; font-weight: 600; color: #94a3b8">have</span> <span class="bs-settle-word bs-settle-accent" style="--w-i:8; font-family: 'Roboto Mono', monospace; font-weight: 700; color: #2563eb">16GB</span><span class="bs-settle-word" style="--w-i:9; font-weight: 600; color: #94a3b8">.</span></h1>
<p style="margin: 0; font-size: 19px; line-height: 1.6; color: #94a3b8; max-width: 540px">Buildstation tests coding agents on small local models: Aider, OpenHands, SWE-agent, AutoCodeRover and more, running open-weight models on consumer hardware. Same rig, real numbers, measured rather than claimed.</p>
<div style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center">
<a href="<?php echo esc_url(buildstation_get_link('youtube_url', 'https://www.youtube.com/@BuildstationHQ/shorts')); ?>" target="_blank" rel="noopener" style="font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #0f172a; background: #00ff41; text-decoration: none; border-radius: 6px; padding: 16px 24px; min-height: 52px; box-sizing: border-box; display: inline-flex; align-items: center; gap: 10px">
<svg aria-hidden="true" width="18" height="18" viewBox="0 0 18 18"><path d="M4 2.5 L15 9 L4 15.5 Z" fill="#0f172a"></path></svg>
Watch on YouTube</a>
<a href="#method" style="font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0; text-decoration: none; border: 1px solid #94a3b8; border-radius: 6px; padding: 16px 24px; min-height: 52px; box-sizing: border-box; display: inline-flex; align-items: center">How we test</a>
</div>
</div>

<!-- hero excalidraw sketch -->
<figure style="flex: 1 1 440px; min-width: 0; margin: 0">
<svg role="img" aria-label="Hand-drawn sketch: an RTX 4060 Ti with 16GB VRAM feeds a local runtime like Ollama or vLLM, which produces a measured tokens-per-second result" viewBox="0 0 560 440" style="width: 100%; height: auto; display: block">
<defs>
<pattern id="hachHero" width="9" height="9" patternUnits="userSpaceOnUse" patternTransform="rotate(-40)"><line x1="0" y1="0" x2="0" y2="9" stroke="#2563eb" stroke-width="2"></line></pattern>
<pattern id="hachHero2" width="7" height="7" patternUnits="userSpaceOnUse" patternTransform="rotate(35)"><line x1="0" y1="0" x2="0" y2="7" stroke="#1e293b" stroke-width="2"></line></pattern>
</defs>
<!-- box A: rig -->
<path d="M32 52 C 100 48, 180 51, 248 50 C 250 85, 246 125, 247 161 C 170 163, 100 159, 31 160 C 29 120, 33 85, 32 52" fill="url(#hachHero2)" stroke="none"></path>
<path d="M32 52 C 100 48, 180 51, 248 50 C 250 85, 246 125, 247 161 C 170 163, 100 159, 31 160 C 29 120, 33 85, 32 52" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M29 49 C 110 53, 190 48, 245 52 C 248 90, 249 130, 249 158 C 160 161, 90 162, 33 162 C 31 125, 28 80, 30 51" fill="none" stroke="#e2e8f0" stroke-width="1.3" stroke-linecap="round"></path>
<text x="140" y="96" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="30" fill="#e2e8f0">RTX 4060 Ti</text>
<text x="140" y="134" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="22" fill="#2563eb">16GB VRAM</text>
<!-- box B: runtime -->
<path d="M318 50 C 390 47, 460 52, 530 49 C 532 90, 529 125, 531 160 C 460 163, 390 158, 317 161 C 315 120, 319 85, 318 50" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M315 47 C 400 52, 470 47, 528 52 C 529 88, 533 130, 529 163 C 450 160, 380 164, 319 159 C 317 125, 313 80, 316 49" fill="none" stroke="#e2e8f0" stroke-width="1.3" stroke-linecap="round"></path>
<text x="424" y="96" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="30" fill="#e2e8f0">ollama · vllm</text>
<text x="424" y="134" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="500" font-size="17" fill="#94a3b8">llama.cpp</text>
<!-- arrow A to B with pulse -->
<path class="bs-pulse-beam" stroke-dasharray="6 6" d="M254 104 C 270 98, 292 99, 310 105" fill="none" stroke="#2563eb" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M298 95 L 311 105 L 297 113" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
<!-- ellipse C: result -->
<path d="M286 248 C 372 244, 422 272, 418 312 C 414 352, 360 372, 284 370 C 206 368, 152 346, 154 308 C 156 270, 208 250, 290 249" fill="url(#hachHero)" stroke="none"></path>
<path d="M286 248 C 372 244, 422 272, 418 312 C 414 352, 360 372, 284 370 C 206 368, 152 346, 154 308 C 156 270, 208 250, 290 249" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M282 245 C 368 248, 425 276, 420 316 C 412 356, 352 375, 280 373 C 200 371, 150 342, 152 304 C 158 266, 214 246, 300 247" fill="none" stroke="#e2e8f0" stroke-width="1.2" stroke-linecap="round"></path>
<rect x="216" y="286" width="136" height="48" rx="6" fill="#0f172a"></rect>
<text x="284" y="320" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="26" fill="#e2e8f0">tok/s</text>
<!-- arrow B to C with pulse -->
<path class="bs-pulse-beam" stroke-dasharray="6 6" d="M428 170 C 432 206, 418 232, 394 258" fill="none" stroke="#2563eb" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M391 242 L 393 260 L 410 253" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
<!-- dashed A to C (constraint) -->
<path class="bs-pulse-beam-reverse" d="M140 170 C 138 210, 160 238, 190 262" fill="none" stroke="#94a3b8" stroke-width="2" stroke-dasharray="6 7" stroke-linecap="round"></path>
<text x="40" y="226" font-family="Caveat, cursive" font-weight="500" font-size="24" fill="#94a3b8">the real ceiling</text>
<!-- annotation -->
<text x="330" y="420" font-family="Caveat, cursive" font-weight="700" font-size="28" fill="#e2e8f0">measured, not claimed</text>
<path d="M376 396 C 368 384, 362 378, 352 372" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"></path>
<path d="M352 386 L 350 371 L 364 372" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</figure>
</section>

<section aria-label="The test bench" style="border-top: 1px solid #1e293b; border-bottom: 1px solid #1e293b">
<div style="max-width: 1200px; margin: 0 auto; padding: 24px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center">
<span style="font-family: Caveat, cursive; font-weight: 700; font-size: 26px; color: #94a3b8; margin-right: 12px">the test bench →</span>
<span style="font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 15px; color: #e2e8f0; border: 1px solid #94a3b8; border-radius: 4px; padding: 8px 12px"><?php echo esc_html(buildstation_get_spec('cpu', 'i7-14700KF')); ?></span>
<span style="font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 15px; color: #e2e8f0; border: 1px solid #94a3b8; border-radius: 4px; padding: 8px 12px"><?php echo esc_html(buildstation_get_spec('gpu', 'RTX 4060 Ti · 16GB')); ?></span>
<span style="font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 15px; color: #e2e8f0; border: 1px solid #94a3b8; border-radius: 4px; padding: 8px 12px"><?php echo esc_html(buildstation_get_spec('ram', '64GB DDR5')); ?></span>
<span style="font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 15px; color: #e2e8f0; border: 1px solid #94a3b8; border-radius: 4px; padding: 8px 12px"><?php echo esc_html(buildstation_get_spec('os', 'Ubuntu 24.04')); ?></span>
</div>
</section>

<section id="harnesses" style="max-width: 1200px; margin: 0 auto; padding: 112px 24px 24px; display: flex; flex-wrap: wrap; gap: 56px; align-items: center">
<div style="flex: 1 1 460px; min-width: 0; display: flex; flex-direction: column; gap: 24px">
<p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// the niche</p>
<h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 52px); line-height: 1.08; letter-spacing: -0.02em; color: #e2e8f0">Coding harnesses on small local models</h2>
<p style="margin: 0; font-size: 18px; line-height: 1.6; color: #94a3b8">A coding agent is a model plus a scaffold. Put the same <span style="font-family: 'Roboto Mono', monospace; font-weight: 500; color: #e2e8f0">7–12B</span> model in a different harness and you get a different agent. Buildstation tests the two separately, on <span style="font-family: 'Roboto Mono', monospace; font-weight: 500; color: #e2e8f0">16GB</span>, so you know which one to change.</p>
<ul aria-label="Harnesses under test" style="margin: 0; padding: 0; list-style: none; display: flex; flex-wrap: wrap; gap: 14px">
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M2 4 C 30 1, 70 5, 98 2 C 99 35, 97 65, 99 97 C 70 99, 30 96, 1 98 C 0 65, 3 35, 2 4" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">aider</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M1 2 C 30 5, 70 1, 99 4 C 97 35, 100 65, 98 98 C 70 96, 30 99, 2 97 C 3 65, 0 35, 1 2" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">openhands</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M2 3 C 30 1, 70 4, 98 1 C 100 35, 97 65, 99 98 C 70 100, 30 97, 1 99 C 2 65, 0 35, 2 3" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">swe-agent</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M1 3 C 30 5, 70 2, 99 4 C 98 35, 100 65, 97 97 C 70 99, 30 96, 2 98 C 1 65, 3 35, 1 3" fill="none" stroke="#2563eb" stroke-width="2.4" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">autocoderover</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M2 2 C 30 4, 70 1, 98 3 C 100 35, 98 65, 99 97 C 70 98, 30 100, 1 97 C 3 65, 1 35, 2 2" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">cline</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M1 4 C 30 2, 70 5, 99 2 C 98 35, 99 65, 98 98 C 70 96, 30 99, 2 97 C 0 65, 2 35, 1 4" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">continue</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M2 3 C 30 5, 70 1, 98 4 C 99 35, 97 65, 99 97 C 70 99, 30 97, 1 98 C 2 65, 0 35, 2 3" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">opencode</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M1 2 C 30 4, 70 2, 99 3 C 97 35, 99 65, 98 98 C 70 97, 30 99, 2 98 C 1 65, 3 35, 1 2" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">goose</span></li>
<li style="position: relative; padding: 10px 16px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 16px; color: #e2e8f0"><svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M2 4 C 30 2, 70 4, 98 2 C 100 35, 98 65, 99 98 C 70 96, 30 98, 1 97 C 2 65, 1 35, 2 4" fill="none" stroke="#e2e8f0" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg><span style="position: relative">roo code</span></li>
</ul>
<p style="margin: 0; font-family: Caveat, cursive; font-weight: 700; font-size: 26px; color: #94a3b8">first up: autocoderover on vLLM ↑</p>
</div>

<figure style="flex: 1 1 440px; min-width: 0; margin: 0">
<svg role="img" aria-label="Hand-drawn test matrix: four harnesses (aider, openhands, swe-agent, autocoderover) against 7B, 9B and 12B models, results pending; the 7B column is circled as same model, four harnesses" viewBox="0 0 540 410" style="width: 100%; height: auto; display: block">
<defs><pattern id="hachMx" width="8" height="8" patternUnits="userSpaceOnUse" patternTransform="rotate(-40)"><line x1="0" y1="0" x2="0" y2="8" stroke="#1e293b" stroke-width="2.4"></line></pattern></defs>
<path d="M16 26 C 160 22, 380 27, 526 24 C 528 120, 525 250, 527 346 C 380 348, 160 345, 15 347 C 13 250, 17 120, 16 26" fill="url(#hachMx)" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M13 23 C 170 27, 370 21, 524 27 C 525 130, 529 260, 524 349 C 370 345, 170 350, 18 344" fill="none" stroke="#e2e8f0" stroke-width="1.1" stroke-linecap="round"></path>
<path d="M18 80 C 180 78, 360 82, 524 79 M18 145 C 180 147, 360 143, 524 146 M18 210 C 180 208, 360 212, 524 209 M18 275 C 180 277, 360 273, 524 276" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round"></path>
<path d="M190 28 C 188 120, 192 250, 190 344 M300 28 C 302 120, 298 250, 300 344 M410 28 C 408 120, 412 250, 410 344" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round"></path>
<text x="34" y="62" font-family="Caveat, cursive" font-weight="700" font-size="24" fill="#94a3b8">harness ↓ model →</text>
<text x="245" y="64" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="24" fill="#2563eb">7B</text>
<text x="355" y="64" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="24" fill="#2563eb">9B</text>
<text x="465" y="64" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="24" fill="#2563eb">12B</text>
<text x="34" y="119" font-family="Roboto Mono, monospace" font-weight="500" font-size="18" fill="#e2e8f0">aider</text>
<text x="34" y="184" font-family="Roboto Mono, monospace" font-weight="500" font-size="18" fill="#e2e8f0">openhands</text>
<text x="34" y="249" font-family="Roboto Mono, monospace" font-weight="500" font-size="18" fill="#e2e8f0">swe-agent</text>
<text x="34" y="314" font-family="Roboto Mono, monospace" font-weight="500" font-size="17" fill="#e2e8f0">autocoderover</text>
<g font-family="Caveat, cursive" font-weight="700" font-size="30" fill="#94a3b8" text-anchor="middle">
<text x="245" y="122">?</text><text x="355" y="122">?</text><text x="465" y="122">?</text>
<text x="245" y="187">?</text><text x="355" y="187">?</text><text x="465" y="187">?</text>
<text x="245" y="252">?</text><text x="355" y="252">?</text><text x="465" y="252">?</text>
<text x="245" y="317">?</text><text x="355" y="317">?</text><text x="465" y="317">?</text>
</g>
<path d="M246 76 C 286 74, 300 120, 299 210 C 298 300, 284 344, 244 344 C 204 344, 192 300, 191 210 C 190 120, 204 78, 250 77" fill="none" stroke="#e2e8f0" stroke-width="2.6" stroke-linecap="round"></path>
<path d="M300 392 C 280 380, 262 368, 252 352" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"></path>
<path d="M249 368 L 251 351 L 265 359" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
<text x="308" y="398" font-family="Caveat, cursive" font-weight="700" font-size="28" fill="#e2e8f0">same model, four harnesses</text>
</svg>
</figure>
</section>

<section id="about" style="max-width: 1200px; margin: 0 auto; padding: 112px 24px 48px; display: flex; flex-direction: column; gap: 48px">
<div style="display: flex; flex-direction: column; gap: 16px; max-width: 720px">
<p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// 01 the problem</p>
<h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 52px); line-height: 1.08; letter-spacing: -0.02em; color: #e2e8f0">The spec-sheet problem</h2>
<p style="margin: 0; font-size: 18px; line-height: 1.6; color: #94a3b8">Most model coverage tells you what a model can do on hardware you will never own. That number doesn't help you pick what to run tonight.</p>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 28px">

<article style="flex: 1 1 300px; min-width: 0; position: relative; padding: 32px; display: flex; flex-direction: column; gap: 16px">
<svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M1 1.5 C 30 0.5, 70 2, 99 1 C 99.5 30, 98.6 70, 99 99 C 70 99.6, 30 98.5, 1 99.2 C 0.4 70, 1.5 30, 1 1.5" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path><path d="M0.4 0.8 C 35 1.8, 65 0.3, 99.6 1.9 C 98.9 35, 100 65, 98.7 99.5 C 65 98.8, 35 100, 0.6 98.6 C 1.2 65, 0 35, 0.4 0.8" fill="none" stroke="#94a3b8" stroke-width="1" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg>
<svg aria-hidden="true" width="72" height="72" viewBox="0 0 72 72">
<path d="M14 10 C 30 9, 44 11, 58 10 L 58 24 C 44 25, 28 23, 14 24 Z" fill="none" stroke="#e2e8f0" stroke-width="2.2" stroke-linejoin="round"></path>
<path d="M14 29 C 30 28, 44 30, 58 29 L 58 43 C 44 44, 28 42, 14 43 Z" fill="none" stroke="#e2e8f0" stroke-width="2.2" stroke-linejoin="round"></path>
<path d="M14 48 C 30 47, 44 49, 58 48 L 58 62 C 44 63, 28 61, 14 62 Z" fill="none" stroke="#e2e8f0" stroke-width="2.2" stroke-linejoin="round"></path>
<path d="M20 17 L 26 17 M20 36 L 26 36 M20 55 L 26 55" stroke="#2563eb" stroke-width="3" stroke-linecap="round"></path>
<path d="M6 66 C 26 46, 46 26, 66 6" fill="none" stroke="#94a3b8" stroke-width="2.6" stroke-linecap="round"></path>
</svg>
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em; color: #e2e8f0">Benchmarks run in a datacenter</h3>
<p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">Headline scores come off multi-GPU servers. Quantized to fit <span style="font-family: 'Roboto Mono', monospace; font-weight: 500; color: #e2e8f0">16GB</span>, the same model behaves differently.</p>
</article>

<article style="flex: 1 1 300px; min-width: 0; position: relative; padding: 32px; display: flex; flex-direction: column; gap: 16px">
<svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M1.2 1 C 30 2, 70 0.4, 98.8 1.6 C 99.6 30, 98.4 70, 99.2 98.8 C 70 99.8, 30 98.2, 0.8 99 C 1.6 70, 0.2 30, 1.2 1" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path><path d="M0.5 1.9 C 35 0.6, 65 2.2, 99.5 0.7 C 98.6 35, 99.9 65, 98.9 99.6 C 65 98.5, 35 99.9, 0.3 98.7 C 1.4 65, 0.1 35, 0.5 1.9" fill="none" stroke="#94a3b8" stroke-width="1" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg>
<svg aria-hidden="true" width="72" height="72" viewBox="0 0 72 72">
<path d="M12 28 C 12 26, 13 24, 16 24 L 26 24 L 50 10 C 52 30, 52 44, 50 62 L 26 48 L 16 48 C 13 48, 12 46, 12 44 Z" fill="none" stroke="#e2e8f0" stroke-width="2.2" stroke-linejoin="round"></path>
<path d="M22 49 C 23 56, 25 61, 28 64" fill="none" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
<path d="M57 26 C 60 28, 61 32, 60 36 M62 18 C 68 24, 69 40, 62 48" fill="none" stroke="#2563eb" stroke-width="2.6" stroke-linecap="round"></path>
</svg>
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em; color: #e2e8f0">Launch day, no numbers</h3>
<p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">Every release is "a new frontier." Few posts tell you the quant, the context length or the tokens per second you'll actually get.</p>
</article>

<article style="flex: 1 1 300px; min-width: 0; position: relative; padding: 32px; display: flex; flex-direction: column; gap: 16px">
<svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M0.8 1.4 C 30 0.6, 70 1.8, 99.2 0.9 C 98.7 30, 99.6 70, 98.9 99.1 C 70 98.4, 30 99.7, 1.1 98.9 C 0.3 70, 1.6 30, 0.8 1.4" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round" vector-effect="non-scaling-stroke"></path><path d="M1.5 0.6 C 35 1.6, 65 0.2, 99.8 1.3 C 99.1 35, 100 65, 99.3 99.4 C 65 99.9, 35 98.6, 0.5 99.6 C 1.1 65, 0.2 35, 1.5 0.6" fill="none" stroke="#94a3b8" stroke-width="1" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg>
<svg aria-hidden="true" width="72" height="72" viewBox="0 0 72 72">
<defs><pattern id="hachMeter" width="6" height="6" patternUnits="userSpaceOnUse" patternTransform="rotate(-45)"><line x1="0" y1="0" x2="0" y2="6" stroke="#2563eb" stroke-width="2"></line></pattern></defs>
<path d="M24 64 C 24 46, 25 26, 24 8 C 32 7, 40 9, 48 8 C 49 26, 47 46, 48 64 C 40 65, 32 63, 24 64 Z" fill="none" stroke="#e2e8f0" stroke-width="2.2" stroke-linejoin="round"></path>
<path d="M26 62 L 26 16 L 46 15 L 46 62 Z" fill="url(#hachMeter)"></path>
<path d="M16 15 C 30 13, 46 16, 58 14" fill="none" stroke="#94a3b8" stroke-width="2.2" stroke-dasharray="4 4" stroke-linecap="round"></path>
</svg>
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em; color: #e2e8f0">VRAM is the real limit</h3>
<p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">Parameter count, quant and context all draw from the same <span style="font-family: 'Roboto Mono', monospace; font-weight: 500; color: #e2e8f0">16GB</span>. Every test here starts from that budget.</p>
</article>
</div>
</section>

<section id="method" style="max-width: 1200px; margin: 0 auto; padding: 96px 24px; display: flex; flex-wrap: wrap; gap: 56px; align-items: flex-start">
<div style="flex: 1 1 440px; min-width: 0; display: flex; flex-direction: column; gap: 32px">
<div style="display: flex; flex-direction: column; gap: 16px">
<p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// 02 the method</p>
<h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 52px); line-height: 1.08; letter-spacing: -0.02em; color: #e2e8f0">Every test is a run you can repeat</h2>
</div>
<div style="display: flex; flex-direction: column; gap: 14px">
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 600; font-size: 24px; color: #e2e8f0">What you get</h3>
<ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 14px">
<li style="display: flex; gap: 14px; align-items: flex-start; font-size: 17px; line-height: 1.5; color: #e2e8f0"><svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" style="flex: 0 0 24px; margin-top: 1px"><path d="M3 13 C 6 15, 8 18, 9 20 C 12 13, 16 8, 21 4" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>Model, quant and context length, stated up front</li>
<li style="display: flex; gap: 14px; align-items: flex-start; font-size: 17px; line-height: 1.5; color: #e2e8f0"><svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" style="flex: 0 0 24px; margin-top: 1px"><path d="M3 13 C 6 15, 8 18, 9 20 C 12 13, 16 8, 21 4" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path></svg><span><span style="font-family: 'Roboto Mono', monospace; font-weight: 500">tok/s</span> and <span style="font-family: 'Roboto Mono', monospace; font-weight: 500">vram_used</span> on the same rig, every time</span></li>
<li style="display: flex; gap: 14px; align-items: flex-start; font-size: 17px; line-height: 1.5; color: #e2e8f0"><svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" style="flex: 0 0 24px; margin-top: 1px"><path d="M3 13 C 6 15, 8 18, 9 20 C 12 13, 16 8, 21 4" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>The exact command and config, so you can rerun it</li>
<li style="display: flex; gap: 14px; align-items: flex-start; font-size: 17px; line-height: 1.5; color: #e2e8f0"><svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" style="flex: 0 0 24px; margin-top: 1px"><path d="M3 13 C 6 15, 8 18, 9 20 C 12 13, 16 8, 21 4" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>A verdict: what to run, and what to skip</li>
</ul>
</div>
<div style="display: flex; flex-direction: column; gap: 14px">
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 600; font-size: 24px; color: #94a3b8">What you don't get</h3>
<ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 14px">
<li style="display: flex; gap: 14px; align-items: flex-start; font-size: 17px; line-height: 1.5; color: #94a3b8"><svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" style="flex: 0 0 24px; margin-top: 1px"><path d="M5 5 C 10 10, 14 14, 19 19 M19 5 C 14 9, 10 14, 5 19" fill="none" stroke="#94a3b8" stroke-width="2.4" stroke-linecap="round"></path></svg>Scores copied from a model card</li>
<li style="display: flex; gap: 14px; align-items: flex-start; font-size: 17px; line-height: 1.5; color: #94a3b8"><svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" style="flex: 0 0 24px; margin-top: 1px"><path d="M5 5 C 10 10, 14 14, 19 19 M19 5 C 14 9, 10 14, 5 19" fill="none" stroke="#94a3b8" stroke-width="2.4" stroke-linecap="round"></path></svg>Release-news recaps</li>
<li style="display: flex; gap: 14px; align-items: flex-start; font-size: 17px; line-height: 1.5; color: #94a3b8"><svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" style="flex: 0 0 24px; margin-top: 1px"><path d="M5 5 C 10 10, 14 14, 19 19 M19 5 C 14 9, 10 14, 5 19" fill="none" stroke="#94a3b8" stroke-width="2.4" stroke-linecap="round"></path></svg>The word "game-changing"</li>
</ul>
</div>
</div>

<!-- sketched terminal capture -->
<figure style="flex: 1 1 440px; min-width: 0; margin: 0; display: flex; flex-direction: column; gap: 12px">
<div style="position: relative; padding: 28px 28px 32px">
<svg aria-hidden="true" viewBox="0 0 100 100" preserveAspectRatio="none" style="position: absolute; inset: 0; width: 100%; height: 100%; overflow: visible; pointer-events: none"><path d="M1 1.5 C 30 0.5, 70 2, 99 1 C 99.5 30, 98.6 70, 99 99 C 70 99.6, 30 98.5, 1 99.2 C 0.4 70, 1.5 30, 1 1.5" fill="#0b1222" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke"></path><path d="M0.4 0.8 C 35 1.8, 65 0.3, 99.6 1.9 C 98.9 35, 100 65, 98.7 99.5 C 65 98.8, 35 100, 0.6 98.6 C 1.2 65, 0 35, 0.4 0.8" fill="none" stroke="#e2e8f0" stroke-width="1" stroke-linecap="round" vector-effect="non-scaling-stroke"></path></svg>
<div style="position: relative; display: flex; gap: 8px; margin-bottom: 20px">
<svg aria-hidden="true" width="56" height="14" viewBox="0 0 56 14"><path d="M7 2 C 11 2, 12 6, 12 7 C 12 11, 9 12, 7 12 C 3 12, 2 9, 2 7 C 2 4, 4 2, 8 2" fill="none" stroke="#94a3b8" stroke-width="1.8"></path><path d="M27 2 C 31 2, 32 6, 32 7 C 32 11, 29 12, 27 12 C 23 12, 22 9, 22 7 C 22 4, 24 2, 28 2" fill="none" stroke="#94a3b8" stroke-width="1.8"></path><path d="M47 2 C 51 2, 52 6, 52 7 C 52 11, 49 12, 47 12 C 43 12, 42 9, 42 7 C 42 4, 44 2, 48 2" fill="none" stroke="#94a3b8" stroke-width="1.8"></path></svg>
</div>
<pre style="position: relative; margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 15px; line-height: 1.9; color: #e2e8f0; white-space: pre-wrap; overflow-wrap: anywhere">$ bench --harness aider --model &lt;name&gt; --quant Q4_K_M --ctx 8192
<span style="color: #94a3b8">gpu        </span>RTX 4060 Ti 16GB
<span style="color: #94a3b8">runtime    </span>ollama
<span style="color: #94a3b8">harness    </span>aider
<span style="color: #94a3b8">solved     </span>[  ] / [  ] tasks
<span style="color: #94a3b8">vram_used  </span>[  ] GB
<span style="color: #94a3b8">tok/s      </span>[  ]
<span style="color: #94a3b8">verdict    </span>[run it | skip it]</pre>
</div>
<figcaption style="font-family: Caveat, cursive; font-weight: 700; font-size: 26px; color: #94a3b8; padding-left: 8px">↑ every video ships with this block</figcaption>
</figure>
</section>

<section id="process" style="border-top: 1px solid #1e293b">
<div style="max-width: 1200px; margin: 0 auto; padding: 96px 24px; display: flex; flex-direction: column; gap: 48px">
<div style="display: flex; flex-direction: column; gap: 16px; max-width: 720px">
<p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// 03 the process</p>
<h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 52px); line-height: 1.08; letter-spacing: -0.02em; color: #e2e8f0">Constraint first, then the leaderboard</h2>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-start">

<div style="flex: 1 1 260px; min-width: 0; display: flex; flex-direction: column; gap: 14px">
<svg aria-hidden="true" width="64" height="64" viewBox="0 0 64 64"><path d="M32 5 C 48 4, 59 16, 58 32 C 57 48, 46 59, 31 58 C 16 57, 5 47, 6 31 C 7 16, 18 6, 34 6" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path><text x="32" y="42" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="26" fill="#e2e8f0">1</text></svg>
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em; color: #e2e8f0">Pick the constraint</h3>
<p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">Start from a real limit: <span style="font-family: 'Roboto Mono', monospace; font-weight: 500; color: #e2e8f0">16GB</span> of VRAM, a model size band, a task like coding agents.</p>
</div>

<svg class="bs-flowarrow" aria-hidden="true" width="80" height="64" viewBox="0 0 80 64" style="flex: 0 0 80px; margin-top: 4px"><path d="M4 34 C 22 26, 46 38, 70 30" fill="none" stroke="#94a3b8" stroke-width="2.4" stroke-linecap="round"></path><path d="M58 22 L 71 30 L 59 39" fill="none" stroke="#94a3b8" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>

<div style="flex: 1 1 260px; min-width: 0; display: flex; flex-direction: column; gap: 14px">
<svg aria-hidden="true" width="64" height="64" viewBox="0 0 64 64"><path d="M31 6 C 47 5, 58 17, 58 31 C 58 47, 47 58, 32 58 C 15 58, 6 46, 6 32 C 6 17, 17 7, 33 5" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path><text x="32" y="42" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="26" fill="#e2e8f0">2</text></svg>
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em; color: #e2e8f0">Run it the same way</h3>
<p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">Same rig, same harness, same prompts. Harness effects get separated from model effects.</p>
</div>

<svg class="bs-flowarrow" aria-hidden="true" width="80" height="64" viewBox="0 0 80 64" style="flex: 0 0 80px; margin-top: 4px"><path d="M4 30 C 24 38, 48 24, 70 32" fill="none" stroke="#94a3b8" stroke-width="2.4" stroke-linecap="round"></path><path d="M58 24 L 71 32 L 58 41" fill="none" stroke="#94a3b8" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>

<div style="flex: 1 1 260px; min-width: 0; display: flex; flex-direction: column; gap: 14px">
<svg aria-hidden="true" width="64" height="64" viewBox="0 0 64 64"><path d="M33 5 C 49 6, 59 18, 58 33 C 57 49, 45 59, 30 58 C 14 57, 5 45, 6 30 C 8 15, 19 5, 35 7" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path><text x="32" y="42" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="26" fill="#e2e8f0">3</text></svg>
<h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em; color: #e2e8f0">Rank it and publish</h3>
<p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">A countdown with the numbers on screen and the config in the description. Lead with the result.</p>
</div>
</div>
</div>
</section>

<section id="videos" style="border-top: 1px solid #1e293b">
<div style="max-width: 1200px; margin: 0 auto; padding: 96px 24px; display: flex; flex-direction: column; gap: 48px">
<div style="display: flex; flex-wrap: wrap; gap: 24px; align-items: flex-end; justify-content: space-between">
<div style="display: flex; flex-direction: column; gap: 16px; max-width: 720px">
<p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// 04 the series</p>
<h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 52px); line-height: 1.08; letter-spacing: -0.02em; color: #e2e8f0">Start here</h2>
</div>
<a href="<?php echo esc_url(buildstation_get_link('youtube_url', 'https://www.youtube.com/@BuildstationHQ/shorts')); ?>" target="_blank" rel="noopener" class="bs-link" style="font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 15px; color: #e2e8f0; text-decoration: underline; text-underline-offset: 4px; padding: 12px 0">all videos →</a>
</div>
<div style="display: flex; flex-wrap: wrap; gap: 28px">

  <!-- Curated Benchmark Video Card 1 -->
  <a href="<?php echo esc_url(buildstation_get_link('youtube_url', 'https://www.youtube.com/@BuildstationHQ/shorts')); ?>" target="_blank" rel="noopener" class="bs-video-card" style="flex: 1 1 300px; min-width: 0; text-decoration: none; color: #e2e8f0; display: flex; flex-direction: column; gap: 18px">
  <div class="bs-video-thumb" style="position: relative; overflow: hidden; border-radius: 8px; border: 1px solid #1e293b; background: #0b1222">
    <svg aria-hidden="true" viewBox="0 0 320 180" style="width: 100%; height: auto; display: block">
    <defs><pattern id="hachT1" width="10" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(-40)"><line x1="0" y1="0" x2="0" y2="10" stroke="#1e293b" stroke-width="3"></line></pattern></defs>
    <path d="M4 6 C 100 3, 220 7, 316 4 C 318 60, 315 120, 317 176 C 220 178, 100 175, 3 177 C 2 120, 5 60, 4 6" fill="url(#hachT1)" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
    <path d="M2 3 C 110 7, 210 2, 318 7 C 316 70, 319 120, 315 178 C 210 175, 110 179, 5 175 C 6 110, 1 60, 3 5" fill="none" stroke="#e2e8f0" stroke-width="1.1" stroke-linecap="round"></path>
    <text x="28" y="78" font-family="Poppins, sans-serif" font-weight="900" font-size="54" fill="#e2e8f0">TOP 5</text>
    <text x="30" y="118" font-family="Roboto Mono, monospace" font-weight="700" font-size="28" fill="#2563eb">16GB VRAM</text>
    <path d="M248 66 C 262 76, 272 84, 282 92 C 272 100, 262 108, 248 118 C 246 100, 247 84, 248 66 Z" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linejoin="round"></path>
    <text x="30" y="156" font-family="Caveat, cursive" font-weight="700" font-size="24" fill="#94a3b8">most watched</text>
    </svg>
    <div class="bs-yt-overlay">
      <span class="bs-yt-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="#00ff41"><path d="M8 5v14l11-7z"/></svg> YouTube Shorts</span>
    </div>
  </div>
  <h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em">Five best LLMs for 16GB VRAM</h3>
  <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">The constraint-first countdown that set the format for the channel.</p>
  <span style="font-family: 'Roboto Mono', monospace; font-size: 14px; font-weight: 700; color: #2563eb; display: inline-flex; align-items: center; gap: 6px;">Watch on YouTube <span style="color: #00ff41">→</span></span>
  </a>

  <!-- Curated Benchmark Video Card 2 -->
  <a href="<?php echo esc_url(buildstation_get_link('youtube_url', 'https://www.youtube.com/@BuildstationHQ/shorts')); ?>" target="_blank" rel="noopener" class="bs-video-card" style="flex: 1 1 300px; min-width: 0; text-decoration: none; color: #e2e8f0; display: flex; flex-direction: column; gap: 18px">
  <div class="bs-video-thumb" style="position: relative; overflow: hidden; border-radius: 8px; border: 1px solid #1e293b; background: #0b1222">
    <svg aria-hidden="true" viewBox="0 0 320 180" style="width: 100%; height: auto; display: block">
    <defs><pattern id="hachT2" width="10" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(40)"><line x1="0" y1="0" x2="0" y2="10" stroke="#1e293b" stroke-width="3"></line></pattern></defs>
    <path d="M3 5 C 100 7, 220 3, 317 6 C 315 60, 318 120, 316 177 C 220 175, 100 178, 4 176 C 5 120, 2 60, 3 5" fill="url(#hachT2)" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
    <path d="M5 3 C 110 5, 210 2, 315 4 C 318 70, 315 120, 318 175 C 210 178, 110 174, 2 178 C 3 110, 6 60, 4 4" fill="none" stroke="#e2e8f0" stroke-width="1.1" stroke-linecap="round"></path>
    <text x="30" y="106" font-family="Roboto Mono, monospace" font-weight="700" font-size="76" fill="#e2e8f0">5</text>
    <text x="86" y="78" font-family="Roboto Mono, monospace" font-weight="700" font-size="54" fill="#94a3b8">4</text>
    <text x="132" y="60" font-family="Roboto Mono, monospace" font-weight="700" font-size="38" fill="#94a3b8">3</text>
    <path d="M174 120 C 210 112, 240 96, 280 52" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path>
    <path d="M266 54 L 281 51 L 279 66" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
    <text x="30" y="156" font-family="Caveat, cursive" font-weight="700" font-size="24" fill="#94a3b8">serialized countdown</text>
    </svg>
    <div class="bs-yt-overlay">
      <span class="bs-yt-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="#00ff41"><path d="M8 5v14l11-7z"/></svg> YouTube Shorts</span>
    </div>
  </div>
  <h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em">Top 5 open-weight LLMs</h3>
  <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">A running series ranking open-weight models on the same bench, one constraint at a time.</p>
  <span style="font-family: 'Roboto Mono', monospace; font-size: 14px; font-weight: 700; color: #2563eb; display: inline-flex; align-items: center; gap: 6px;">Watch on YouTube <span style="color: #00ff41">→</span></span>
  </a>

  <!-- Curated Benchmark Video Card 3 -->
  <a href="<?php echo esc_url(buildstation_get_link('youtube_url', 'https://www.youtube.com/@BuildstationHQ/shorts')); ?>" target="_blank" rel="noopener" class="bs-video-card" style="flex: 1 1 300px; min-width: 0; text-decoration: none; color: #e2e8f0; display: flex; flex-direction: column; gap: 18px">
  <div class="bs-video-thumb" style="position: relative; overflow: hidden; border-radius: 8px; border: 1px solid #1e293b; background: #0b1222">
    <svg aria-hidden="true" viewBox="0 0 320 180" style="width: 100%; height: auto; display: block">
    <defs><pattern id="hachT3" width="10" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(-40)"><line x1="0" y1="0" x2="0" y2="10" stroke="#1e293b" stroke-width="3"></line></pattern></defs>
    <path d="M4 4 C 100 6, 220 2, 316 5 C 317 60, 314 120, 317 176 C 220 178, 100 174, 3 177 C 4 120, 2 60, 4 4" fill="url(#hachT3)" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
    <path d="M28 40 C 70 38, 110 41, 132 39 C 133 60, 131 80, 133 100 C 110 102, 70 99, 27 101 C 26 80, 29 60, 28 40" fill="#0f172a" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
    <text x="80" y="78" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#e2e8f0">harness</text>
    <path d="M188 40 C 230 38, 270 41, 292 39 C 293 60, 291 80, 293 100 C 270 102, 230 99, 187 101 C 186 80, 189 60, 188 40" fill="#0f172a" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
    <text x="240" y="78" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#e2e8f0">model</text>
    <text x="160" y="80" text-anchor="middle" font-family="Poppins, sans-serif" font-weight="800" font-size="26" fill="#2563eb">vs</text>
    <text x="30" y="156" font-family="Caveat, cursive" font-weight="700" font-size="24" fill="#94a3b8">coming next</text>
    </svg>
    <div class="bs-yt-overlay">
      <span class="bs-yt-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="#00ff41"><path d="M8 5v14l11-7z"/></svg> YouTube Shorts</span>
    </div>
  </div>
  <h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em">Harness vs model</h3>
  <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">Small local models, <span style="font-family: 'Roboto Mono', monospace; font-weight: 500; color: #e2e8f0">7–12B</span>, run through AutoCodeRover on vLLM. How much is the model, and how much is the scaffold?</p>
  <span style="font-family: 'Roboto Mono', monospace; font-size: 14px; font-weight: 700; color: #2563eb; display: inline-flex; align-items: center; gap: 6px;">Watch on YouTube <span style="color: #00ff41">→</span></span>
  </a>

  <!-- Curated Benchmark Video Card 4: SWE-bench Deep Dive -->
  <a href="<?php echo esc_url(home_url('/how-swe-bench-actually-scores-ai-models/')); ?>" class="bs-video-card" style="flex: 1 1 300px; min-width: 0; text-decoration: none; color: #e2e8f0; display: flex; flex-direction: column; gap: 18px">
  <div class="bs-video-thumb" style="position: relative; overflow: hidden; border-radius: 8px; border: 1px solid #1e293b; background: #0b1222">
    <svg aria-hidden="true" viewBox="0 0 320 180" style="width: 100%; height: auto; display: block">
    <defs><pattern id="hachT4" width="10" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(45)"><line x1="0" y1="0" x2="0" y2="10" stroke="#1e293b" stroke-width="3"></line></pattern></defs>
    <path d="M4 4 C 100 6, 220 2, 316 5 C 317 60, 314 120, 317 176 C 220 178, 100 174, 3 177 C 4 120, 2 60, 4 4" fill="url(#hachT4)" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
    <path d="M2 3 C 110 5, 210 2, 315 4 C 318 70, 315 120, 318 175 C 210 178, 110 174, 2 178 C 3 110, 6 60, 4 4" fill="none" stroke="#e2e8f0" stroke-width="1.1" stroke-linecap="round"></path>
    <text x="24" y="66" font-family="Poppins, sans-serif" font-weight="900" font-size="34" fill="#e2e8f0">SWE-BENCH</text>
    <text x="26" y="102" font-family="Roboto Mono, monospace" font-weight="700" font-size="22" fill="#00ff41">0% CREDIT RULE</text>
    <text x="26" y="146" font-family="Caveat, cursive" font-weight="700" font-size="24" fill="#94a3b8">docker grading</text>
    </svg>
    <div class="bs-yt-overlay">
      <span class="bs-yt-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="#00ff41"><path d="M8 5v14l11-7z"/></svg> Benchmark Deep Dive</span>
    </div>
  </div>
  <h3 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: 24px; letter-spacing: -0.02em">How SWE-bench actually scores models</h3>
  <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #94a3b8">The Docker test harness, the dual-list pytest matrix, and why 11 passing tests out of 12 earns a 0% resolve score.</p>
  <span style="font-family: 'Roboto Mono', monospace; font-size: 14px; font-weight: 700; color: #2563eb; display: inline-flex; align-items: center; gap: 6px;">Read full deep dive <span style="color: #00ff41">→</span></span>
  </a>

</div>
</div>
</section>

</div>
</div>
</section>

<section id="privacy" style="border-top: 1px solid #1e293b">
<div style="max-width: 1200px; margin: 0 auto; padding: 96px 24px; display: flex; flex-wrap: wrap; gap: 56px; align-items: center">
<figure style="flex: 1 1 360px; min-width: 0; margin: 0">
<svg role="img" aria-label="Hand-drawn sketch: a locked box labelled your code sits beside a local model on your own hardware, with a crossed-out cloud and no API calls" viewBox="0 0 440 260" style="width: 100%; height: auto; display: block">
<defs><pattern id="hachLock" width="8" height="8" patternUnits="userSpaceOnUse" patternTransform="rotate(-45)"><line x1="0" y1="0" x2="0" y2="8" stroke="#2563eb" stroke-width="2"></line></pattern></defs>
<path d="M30 110 C 80 108, 130 111, 170 109 C 172 150, 169 190, 171 228 C 130 230, 80 227, 29 229 C 28 190, 31 150, 30 110" fill="url(#hachLock)" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M60 108 C 58 70, 70 52, 100 52 C 130 52, 142 70, 140 108" fill="none" stroke="#e2e8f0" stroke-width="2.6" stroke-linecap="round"></path>
<rect x="52" y="152" width="96" height="40" rx="6" fill="#0f172a"></rect>
<text x="100" y="180" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#e2e8f0">your code</text>
<path d="M252 120 C 310 117, 370 121, 412 118 C 414 160, 411 196, 413 230 C 370 232, 310 229, 251 231 C 250 196, 253 160, 252 120" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M249 117 C 320 121, 380 116, 410 121 C 411 165, 415 200, 410 233 C 360 230, 300 234, 253 229" fill="none" stroke="#e2e8f0" stroke-width="1.1" stroke-linecap="round"></path>
<text x="332" y="166" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="28" fill="#e2e8f0">local model</text>
<text x="332" y="202" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="500" font-size="16" fill="#94a3b8">on-prem</text>
<path d="M180 170 C 200 164, 222 166, 244 172" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M232 162 L 245 172 L 232 181" fill="none" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M270 70 C 262 70, 256 62, 262 54 C 262 40, 280 34, 290 42 C 296 28, 322 28, 326 44 C 340 42, 348 56, 340 66 C 344 74, 336 80, 328 78 L 274 78 C 268 78, 266 74, 270 70 Z" fill="none" stroke="#94a3b8" stroke-width="2.2" stroke-linejoin="round"></path>
<path d="M254 92 C 280 70, 320 44, 354 22" fill="none" stroke="#94a3b8" stroke-width="2.6" stroke-linecap="round"></path>
<text x="360" y="62" font-family="Caveat, cursive" font-weight="500" font-size="22" fill="#94a3b8">no API calls</text>
</svg>
</figure>
<div style="flex: 1 1 460px; min-width: 0; display: flex; flex-direction: column; gap: 24px">
<p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// 05 on-prem privacy</p>
<h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 52px); line-height: 1.08; letter-spacing: -0.02em; color: #e2e8f0">Your code and data never leave the box</h2>
<p style="margin: 0; font-size: 18px; line-height: 1.6; color: #94a3b8">Cloud AI APIs log prompts, retain completions, and require transmitting proprietary codebase context to external servers. Running open-weight models locally ensures zero network egress, zero third-party telemetry, and complete operational privacy.</p>
<ul style="margin: 0; padding: 0; list-style: none; display: flex; flex-direction: column; gap: 12px; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 15px; color: #e2e8f0">
<li>→ zero API calls · zero telemetry leaked off-box</li>
<li>→ deterministic benchmarks on hardware you own</li>
<li>→ run air-gapped on your workstation or private server</li>
</ul>
<div>
<a href="#videos" class="bs-btn bs-btn-outline" style="min-height: 52px; padding: 16px 24px;">Watch benchmarks →</a>
</div>
</div>
</div>
</section>

<section id="dispatch" style="border-top: 1px solid #1e293b; background: #0b1222">
<div style="max-width: 1200px; margin: 0 auto; padding: 96px 24px 64px; display: flex; flex-direction: column; gap: 32px">
  <div style="display: flex; flex-direction: column; gap: 16px; max-width: 760px">
    <p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// 06 benchmark dispatch</p>
    <h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(24px, 4vw, 52px); line-height: 1.08; letter-spacing: -0.02em; color: #e2e8f0">What subscribers get: raw test artifacts</h2>
    <p style="margin: 0; font-size: 18px; line-height: 1.6; color: #94a3b8">Every video on the channel has an unredacted companion dispatch: 18 scored runs, token counts, error diffs, and exact vLLM model flags. Here is what a typical run dispatch looks like.</p>
  </div>

  <div class="bsx-score" style="border: 1px solid #1e293b; border-radius: 12px; padding: 32px; background: #0f172a">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">
      <span class="bsx-mock">MOCK DATA: made-up numbers, layout only</span>
      <span style="font-family: 'Roboto Mono', monospace; font-size: 12px; color: var(--accent); border: 1px solid var(--accent); padding: 4px 8px; border-radius: 4px;">DISPATCH #01 PREVIEW</span>
    </div>

    <span class="bs-eyebrow">// harness scores · SWE-bench Verified · 16GB GPU</span>
    <h3 style="font-family: 'Poppins', sans-serif; font-weight: 900; font-size: clamp(26px, 4.5vw, 40px); color: var(--text); margin-bottom: 12px;">Same model, different harness</h3>
    <p class="bsx-lede" style="font-size: 16px; color: var(--text-dim); margin-bottom: 24px;">How many coding tasks small local models resolve when only the agent harness changes. <span class="bsx-mono" style="color: var(--text);">18</span> scored runs; runs are compared only within the same task list.</p>

    <!-- Hero Card -->
    <section class="bsx-hero" style="border: 1px solid var(--grid); border-radius: 12px; padding: 28px; margin: 24px 0; background: #0b1222">
      <span class="bs-eyebrow" style="color: var(--urgent)">Measured Delta</span>
      <div class="bsx-hero-num" style="font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: clamp(52px, 9vw, 96px); color: var(--urgent); line-height: 1;">+4.3</div>
      <div class="bsx-hero-unit" style="font-family: 'Poppins', sans-serif; font-weight: 800; font-size: clamp(18px, 2.5vw, 24px); margin: 8px 0 12px;">tasks for AutoCodeRover on Gemma 4 E4B (within noise)</div>
      <p class="bsx-hero-text" style="color: var(--text-dim); margin: 0 0 20px;">Gemma 4 E4B: AutoCodeRover 7.7 vs mini-SWE-agent 3.3 of 50 tasks (mean of repeats), within noise (noise floor 10).</p>
      <div class="bsx-pills">
        <span class="bs-spec-pill">50 tasks</span>
        <span class="bs-spec-pill">18 runs</span>
        <span class="bs-spec-pill">6 cells</span>
        <span class="bs-spec-pill">tasks/verified50.txt</span>
      </div>
    </section>

    <!-- Key Terms Accordion -->
    <details class="bsx-key" open style="border: 1px solid var(--grid); border-radius: 12px; padding: 16px 20px; margin: 24px 0; background: #0b1222;">
      <summary style="font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 16px; cursor: pointer; color: var(--text);">Key: abbreviations and definitions</summary>
      <dl style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px 28px; margin: 16px 0 4px;">
        <div style="border-top: 1px solid var(--grid); padding-top: 8px;"><dt><code style="color: var(--text); font-weight: 700;">acr</code> <b style="font-family: 'Poppins', sans-serif; font-size: 14px; color: var(--text);">AutoCodeRover</b></dt><dd style="margin: 2px 0 0; font-size: 13px; color: var(--text-dim);">structured: code-search APIs (class, method, snippet), then a patch-writing step</dd></div>
        <div style="border-top: 1px solid var(--grid); padding-top: 8px;"><dt><code style="color: var(--text); font-weight: 700;">mini</code> <b style="font-family: 'Poppins', sans-serif; font-size: 14px; color: var(--text);">mini-SWE-agent</b></dt><dd style="margin: 2px 0 0; font-size: 13px; color: var(--text-dim);">minimal loop: one bash tool, the model plans every step itself</dd></div>
        <div style="border-top: 1px solid var(--grid); padding-top: 8px;"><dt><code style="color: var(--text); font-weight: 700;">gemma4_12b</code> <b style="font-family: 'Poppins', sans-serif; font-size: 14px; color: var(--text);">Gemma 4 12B</b></dt><dd style="margin: 2px 0 0; font-size: 13px; color: var(--text-dim);">Google Gemma 4 12B, QAT 4-bit weights (W4A16)</dd></div>
        <div style="border-top: 1px solid var(--grid); padding-top: 8px;"><dt><code style="color: var(--text); font-weight: 700;">noise floor</code></dt><dd style="margin: 2px 0 0; font-size: 13px; color: var(--text-dim);">largest spread among repeats; smaller differences are not claims</dd></div>
      </dl>
    </details>

    <!-- Resolved tasks per cell -->
    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 20px; color: var(--text); margin: 32px 0 8px;">Resolved tasks per cell</h4>
    <p class="bsx-note" style="color: var(--text-dim); font-size: 14px; margin: 0 0 12px; font-family: 'Roboto Mono', monospace;">Mean of repeats; each repeat and its spread below.</p>
    <div class="bsx-scroll">
      <table class="bsx-grid">
        <thead>
          <tr>
            <th></th>
            <th>Coder 7B <code>coder_7b</code></th>
            <th>Gemma 4 12B <code>gemma4_12b</code></th>
            <th>Gemma 4 E4B <code>gemma4_e4b</code></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>AutoCodeRover <code>acr</code></th>
            <td><span class="bsx-big">15.3</span><span class="bsx-of"> / 50</span><span class="bsx-sub">r1 15 · r2 17 · r3 14 · spread 3</span></td>
            <td><span class="bsx-big">10.0</span><span class="bsx-of"> / 50</span><span class="bsx-sub">r1 10 · r2 13 · r3 7 · spread 6</span></td>
            <td><span class="bsx-big">7.7</span><span class="bsx-of"> / 50</span><span class="bsx-sub">r1 7 · r2 11 · r3 5 · spread 6</span></td>
          </tr>
          <tr>
            <th>mini-SWE-agent <code>mini</code></th>
            <td><span class="bsx-big">12.0</span><span class="bsx-of"> / 50</span><span class="bsx-sub">r1 7 · r2 12 · r3 17 · spread 10</span></td>
            <td><span class="bsx-big">7.0</span><span class="bsx-of"> / 50</span><span class="bsx-sub">r1 7 · r2 5 · r3 9 · spread 4</span></td>
            <td><span class="bsx-big">3.3</span><span class="bsx-of"> / 50</span><span class="bsx-sub">r1 2 · r2 4 · r3 4 · spread 2</span></td>
          </tr>
          <tr class="bsx-gap">
            <th>Gap <code>acr − mini</code></th>
            <td><span class="bsx-mono" style="color: var(--urgent);">+3.3</span><span class="bsx-sub">within noise</span></td>
            <td><span class="bsx-mono" style="color: var(--urgent);">+3.0</span><span class="bsx-sub">within noise</span></td>
            <td><span class="bsx-mono" style="color: var(--urgent);">+4.3</span><span class="bsx-sub">within noise</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Funnel -->
    <h4 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 20px; color: var(--text); margin: 32px 0 8px;">Funnel (Where each cell loses tasks)</h4>
    <p class="bsx-note" style="color: var(--text-dim); font-size: 14px; margin: 0 0 12px; font-family: 'Roboto Mono', monospace;">Mean per cell, of 50 tasks.</p>
    <div class="bsx-scroll">
      <table>
        <thead>
          <tr>
            <th>Cell</th><th>patch</th><th>applied</th><th>localized</th><th>resolved</th>
          </tr>
        </thead>
        <tbody>
          <tr><th>AutoCodeRover <span class="d">×</span> Coder 7B</th><td><div class="bsx-bar" title="patch: 43.7 of 50"><span style="width:87.3%"></span><b>43.7</b></div></td><td><div class="bsx-bar" title="applied: 39.0 of 50"><span style="width:78.0%"></span><b>39.0</b></div></td><td><div class="bsx-bar" title="localized: 30.3 of 50"><span style="width:60.7%"></span><b>30.3</b></div></td><td><div class="bsx-bar" title="resolved: 15.3 of 50"><span style="width:30.7%"></span><b>15.3</b></div></td></tr>
          <tr><th>AutoCodeRover <span class="d">×</span> Gemma 4 12B</th><td><div class="bsx-bar" title="patch: 44.3 of 50"><span style="width:88.7%"></span><b>44.3</b></div></td><td><div class="bsx-bar" title="applied: 37.3 of 50"><span style="width:74.7%"></span><b>37.3</b></div></td><td><div class="bsx-bar" title="localized: 27.3 of 50"><span style="width:54.7%"></span><b>27.3</b></div></td><td><div class="bsx-bar" title="resolved: 10.0 of 50"><span style="width:20.0%"></span><b>10.0</b></div></td></tr>
          <tr><th>mini-SWE-agent <span class="d">×</span> Coder 7B</th><td><div class="bsx-bar" title="patch: 41.0 of 50"><span style="width:82.0%"></span><b>41.0</b></div></td><td><div class="bsx-bar" title="applied: 35.7 of 50"><span style="width:71.3%"></span><b>35.7</b></div></td><td><div class="bsx-bar" title="localized: 27.0 of 50"><span style="width:54.0%"></span><b>27.0</b></div></td><td><div class="bsx-bar" title="resolved: 12.0 of 50"><span style="width:24.0%"></span><b>12.0</b></div></td></tr>
        </tbody>
      </table>
    </div>

    <!-- Gated Subscriber Section (Partial view with blur & overlay) -->
    <div id="subscribe" class="bsx-gated-wrapper">
      <div class="bsx-gated-preview">
        <!-- Blurred Mock Tables (Outcome per run, Cost per task, 50-task matrix) -->
        <h4 style="font-family: 'Poppins', sans-serif; font-size: 20px;">Outcome per run (18 runs)</h4>
        <div class="bsx-legend"><span><i class="bsx-res"></i>resolved</span><span><i class="bsx-unr"></i>unresolved</span><span><i class="bsx-brk"></i>broken patch</span><span><i class="bsx-nop"></i>no patch</span></div>
        <table>
          <thead><tr><th>Run</th><th>resolved</th><th>unresolved</th><th>broken</th><th>no patch</th></tr></thead>
          <tbody>
            <tr><th>MOCK_acr_coder_7b_r1</th><td>15</td><td>21</td><td>7</td><td>7</td></tr>
            <tr><th>MOCK_acr_gemma4_12b_r1</th><td>10</td><td>19</td><td>15</td><td>6</td></tr>
            <tr><th>MOCK_mini_coder_7b_r1</th><td>7</td><td>25</td><td>9</td><td>9</td></tr>
            <tr><th>MOCK_acr_coder_7b_r2</th><td>17</td><td>15</td><td>12</td><td>6</td></tr>
            <tr><th>MOCK_mini_coder_7b_r2</th><td>12</td><td>17</td><td>14</td><td>7</td></tr>
          </tbody>
        </table>

        <h4 style="font-family: 'Poppins', sans-serif; font-size: 20px; margin-top: 24px;">Task-by-task 50-task solve matrix</h4>
        <table>
          <thead><tr><th>Task</th><th>acr 7b</th><th>acr 12b</th><th>acr e4b</th><th>mini 7b</th><th>mini 12b</th><th>mini e4b</th><th>total</th></tr></thead>
          <tbody>
            <tr><th>django__django-14373</th><td>3/3</td><td>1/3</td><td>1/3</td><td>2/3</td><td>1/3</td><td>0/3</td><td>8</td></tr>
            <tr><th>pytest-dev__pytest-10356</th><td>2/3</td><td>2/3</td><td>0/3</td><td>1/3</td><td>0/3</td><td>2/3</td><td>7</td></tr>
            <tr><th>astropy__astropy-12907</th><td>1/3</td><td>1/3</td><td>1/3</td><td>1/3</td><td>2/3</td><td>0/3</td><td>6</td></tr>
            <tr><th>django__django-13820</th><td>2/3</td><td>1/3</td><td>2/3</td><td>0/3</td><td>0/3</td><td>1/3</td><td>6</td></tr>
            <tr><th>django__django-9296</th><td>2/3</td><td>0/3</td><td>1/3</td><td>1/3</td><td>1/3</td><td>1/3</td><td>6</td></tr>
          </tbody>
        </table>
      </div>

      <!-- The Subscriber Paywall / Call to Action -->
      <div class="bsx-gate-overlay">
        <div class="bsx-gate-card">
          <span style="font-family: 'Roboto Mono', monospace; font-size: 13px; font-weight: 700; color: var(--urgent); display: inline-block; margin-bottom: 8px;">[ 🔒 SUBSCRIBER REPORT // 50-TASK MATRIX & FULL RUN TELEMETRY ]</span>
          <h3 style="font-family: 'Poppins', sans-serif; font-weight: 800; font-size: clamp(22px, 3.5vw, 30px); color: var(--text); margin: 0 0 12px; line-height: 1.15;">
            Get the unredacted benchmark dispatches
          </h3>
          <p style="font-size: 16px; color: var(--text-dim); margin: 0 auto 24px; max-width: 480px; line-height: 1.6;">
            We don't send promotional hype. When a benchmark run finishes, you get the raw scoring sheet, the prompt & token counts, and the exact vLLM reproduction flags.
          </p>

          <form class="bs-subscribe-form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; width: 100%; max-width: 480px; margin: 0 auto;">
            <input type="hidden" name="action" value="buildstation_subscribe">
            <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('buildstation_subscribe_nonce')); ?>">
            <input type="text" name="bs_hp" value="" style="display:none !important;" tabindex="-1" autocomplete="off">
            <label for="bs-email" style="position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0)">Email address</label>
            <input id="bs-email" name="email" type="email" required placeholder="you@workstation.local" style="flex: 1 1 240px; min-width: 0; min-height: 48px; box-sizing: border-box; padding: 0 16px; background: #0f172a; color: #e2e8f0; border: 1px solid var(--accent); border-radius: 6px; font-family: 'Roboto Mono', monospace; font-size: 14px">
            <button type="submit" style="min-height: 48px; padding: 0 20px; background: var(--urgent); color: #0f172a; border: 0; border-radius: 6px; font-family: 'Roboto Mono', monospace; font-weight: 700; font-size: 14px; cursor: pointer">send me dispatches →</button>
            <div class="bs-subscribe-status" style="width: 100%; display: none; font-family: 'Roboto Mono', monospace; font-size: 14px; margin-top: 8px;"></div>
          </form>

          <div style="margin-top: 20px; font-family: 'Roboto Mono', monospace; font-size: 12px; color: var(--text-dim);">
            <span>Zero spam · One email per video run · </span>
            <a href="<?php echo esc_url(home_url('/reports/scoring_sheet_mock.html')); ?>" target="_blank" rel="noopener" style="color: var(--accent); text-decoration: underline;">View sample unredacted artifact →</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section id="hardware" aria-label="Under the hood" style="border-top: 1px solid #1e293b">
<div style="max-width: 1200px; margin: 0 auto; padding: 96px 24px 48px; display: flex; flex-direction: column; gap: 32px; align-items: center; text-align: center">
<p style="margin: 0; font-family: 'Roboto Mono', monospace; font-weight: 500; font-size: 14px; color: #94a3b8">// under the hood</p>
<h2 style="margin: 0; font-family: Poppins, sans-serif; font-weight: 800; font-size: clamp(22px, 3.4vw, 44px); line-height: 1.1; letter-spacing: -0.02em; color: #e2e8f0">Every result comes off this box.</h2>
<figure style="margin: 0; width: 100%">
<svg role="img" aria-label="Hand-drawn cross-section of a computer chassis showing the CPU, RAM, GPU, NVMe drive and power supply; beams rise from the CPU and GPU and project a neural network diagram with input features, two hidden layers of neurons, weighted connections and an output decision plot" viewBox="0 0 1200 670" style="width: 100%; height: auto; display: block">
<defs>
<pattern id="hachNN" width="7" height="7" patternUnits="userSpaceOnUse" patternTransform="rotate(-40)"><line x1="0" y1="0" x2="0" y2="7" stroke="#2563eb" stroke-width="2"></line></pattern>
<pattern id="hachNNg" width="7" height="7" patternUnits="userSpaceOnUse" patternTransform="rotate(40)"><line x1="0" y1="0" x2="0" y2="7" stroke="#1e293b" stroke-width="2.4"></line></pattern>
<pattern id="hachBeam" width="10" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(-20)"><line x1="0" y1="0" x2="0" y2="10" stroke="#1e293b" stroke-width="2"></line></pattern>
</defs>

<!-- beams from CPU and GPU (animated neural circuit pulses) -->
<path d="M390 500 L 236 304 L 476 304 Z" fill="url(#hachBeam)"></path>
<path d="M756 490 L 556 304 L 1012 304 Z" fill="url(#hachBeam)"></path>
<g fill="none" stroke="#2563eb" stroke-width="2.2" stroke-linecap="round">
<path class="bs-pulse-circuit bs-delay-1" stroke-dasharray="8 8" d="M390 500 C 340 440, 280 360, 236 304"></path>
<path class="bs-pulse-circuit bs-delay-2" stroke-dasharray="8 8" d="M390 500 C 420 440, 455 360, 476 304"></path>
<path class="bs-pulse-circuit bs-delay-3" stroke-dasharray="8 8" d="M756 490 C 690 430, 610 350, 556 304"></path>
<path class="bs-pulse-circuit bs-delay-4" stroke-dasharray="8 8" d="M756 490 C 850 430, 950 350, 1012 304"></path>
</g>
<path d="M230 302 C 450 298, 780 304, 1018 300" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round"></path>

<!-- network labels -->
<text x="260" y="44" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#94a3b8">features</text>
<text x="515" y="44" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#94a3b8">hidden layers</text>
<text x="770" y="44" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#94a3b8">+1 layer</text>
<text x="940" y="96" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#94a3b8">output</text>
<text x="230" y="116" text-anchor="end" font-family="Roboto Mono, monospace" font-weight="500" font-size="16" fill="#94a3b8">x1</text>
<text x="230" y="176" text-anchor="end" font-family="Roboto Mono, monospace" font-weight="500" font-size="16" fill="#94a3b8">x2</text>
<text x="230" y="236" text-anchor="end" font-family="Roboto Mono, monospace" font-weight="500" font-size="16" fill="#94a3b8">x1·x2</text>

<!-- weights: input to hidden 1 -->
<g fill="none" stroke-linecap="round">
<line x1="278" y1="110" x2="412" y2="70" stroke="#2563eb" stroke-width="3"></line>
<line x1="278" y1="110" x2="412" y2="120" stroke="#94a3b8" stroke-width="1.5"></line>
<line x1="278" y1="110" x2="412" y2="170" stroke="#2563eb" stroke-width="2"></line>
<line x1="278" y1="110" x2="412" y2="220" stroke="#94a3b8" stroke-width="1"></line>
<line x1="278" y1="110" x2="412" y2="270" stroke="#2563eb" stroke-width="1"></line>
<line x1="278" y1="170" x2="412" y2="70" stroke="#94a3b8" stroke-width="1"></line>
<line x1="278" y1="170" x2="412" y2="120" stroke="#2563eb" stroke-width="3.5"></line>
<line x1="278" y1="170" x2="412" y2="170" stroke="#2563eb" stroke-width="1.5"></line>
<line x1="278" y1="170" x2="412" y2="220" stroke="#94a3b8" stroke-width="2.5"></line>
<line x1="278" y1="170" x2="412" y2="270" stroke="#94a3b8" stroke-width="1"></line>
<line x1="278" y1="230" x2="412" y2="70" stroke="#2563eb" stroke-width="1"></line>
<line x1="278" y1="230" x2="412" y2="120" stroke="#94a3b8" stroke-width="1"></line>
<line x1="278" y1="230" x2="412" y2="170" stroke="#94a3b8" stroke-width="2"></line>
<line x1="278" y1="230" x2="412" y2="220" stroke="#2563eb" stroke-width="3"></line>
<line x1="278" y1="230" x2="412" y2="270" stroke="#2563eb" stroke-width="2"></line>
<!-- hidden 1 to hidden 2 -->
<line x1="448" y1="70" x2="582" y2="70" stroke="#2563eb" stroke-width="2.5"></line>
<line x1="448" y1="70" x2="582" y2="120" stroke="#94a3b8" stroke-width="1"></line>
<line x1="448" y1="70" x2="582" y2="170" stroke="#2563eb" stroke-width="1"></line>
<line x1="448" y1="70" x2="582" y2="220" stroke="#94a3b8" stroke-width="1.5"></line>
<line x1="448" y1="70" x2="582" y2="270" stroke="#2563eb" stroke-width="1"></line>
<line x1="448" y1="120" x2="582" y2="70" stroke="#94a3b8" stroke-width="1"></line>
<line x1="448" y1="120" x2="582" y2="120" stroke="#2563eb" stroke-width="3"></line>
<line x1="448" y1="120" x2="582" y2="170" stroke="#94a3b8" stroke-width="2"></line>
<line x1="448" y1="120" x2="582" y2="220" stroke="#2563eb" stroke-width="1"></line>
<line x1="448" y1="120" x2="582" y2="270" stroke="#94a3b8" stroke-width="1"></line>
<line x1="448" y1="170" x2="582" y2="70" stroke="#2563eb" stroke-width="1"></line>
<line x1="448" y1="170" x2="582" y2="120" stroke="#94a3b8" stroke-width="1.5"></line>
<line x1="448" y1="170" x2="582" y2="170" stroke="#2563eb" stroke-width="4"></line>
<line x1="448" y1="170" x2="582" y2="220" stroke="#2563eb" stroke-width="1.5"></line>
<line x1="448" y1="170" x2="582" y2="270" stroke="#94a3b8" stroke-width="1"></line>
<line x1="448" y1="220" x2="582" y2="70" stroke="#94a3b8" stroke-width="1"></line>
<line x1="448" y1="220" x2="582" y2="120" stroke="#2563eb" stroke-width="1"></line>
<line x1="448" y1="220" x2="582" y2="170" stroke="#94a3b8" stroke-width="2.5"></line>
<line x1="448" y1="220" x2="582" y2="220" stroke="#2563eb" stroke-width="3"></line>
<line x1="448" y1="220" x2="582" y2="270" stroke="#2563eb" stroke-width="1.5"></line>
<line x1="448" y1="270" x2="582" y2="70" stroke="#2563eb" stroke-width="1"></line>
<line x1="448" y1="270" x2="582" y2="120" stroke="#94a3b8" stroke-width="1"></line>
<line x1="448" y1="270" x2="582" y2="170" stroke="#2563eb" stroke-width="1.5"></line>
<line x1="448" y1="270" x2="582" y2="220" stroke="#94a3b8" stroke-width="1"></line>
<line x1="448" y1="270" x2="582" y2="270" stroke="#2563eb" stroke-width="2.5"></line>
<!-- hidden 2 to hidden 3 -->
<line x1="618" y1="70" x2="752" y2="110" stroke="#2563eb" stroke-width="2.5"></line>
<line x1="618" y1="70" x2="752" y2="170" stroke="#94a3b8" stroke-width="1"></line>
<line x1="618" y1="70" x2="752" y2="230" stroke="#2563eb" stroke-width="1"></line>
<line x1="618" y1="120" x2="752" y2="110" stroke="#94a3b8" stroke-width="1"></line>
<line x1="618" y1="120" x2="752" y2="170" stroke="#2563eb" stroke-width="3"></line>
<line x1="618" y1="120" x2="752" y2="230" stroke="#94a3b8" stroke-width="1.5"></line>
<line x1="618" y1="170" x2="752" y2="110" stroke="#2563eb" stroke-width="2"></line>
<line x1="618" y1="170" x2="752" y2="170" stroke="#2563eb" stroke-width="1"></line>
<line x1="618" y1="170" x2="752" y2="230" stroke="#94a3b8" stroke-width="2.5"></line>
<line x1="618" y1="220" x2="752" y2="110" stroke="#94a3b8" stroke-width="1"></line>
<line x1="618" y1="220" x2="752" y2="170" stroke="#2563eb" stroke-width="2.5"></line>
<line x1="618" y1="220" x2="752" y2="230" stroke="#2563eb" stroke-width="1.5"></line>
<line x1="618" y1="270" x2="752" y2="110" stroke="#2563eb" stroke-width="1"></line>
<line x1="618" y1="270" x2="752" y2="170" stroke="#94a3b8" stroke-width="1"></line>
<line x1="618" y1="270" x2="752" y2="230" stroke="#2563eb" stroke-width="3"></line>
<!-- hidden 3 to output -->
<path d="M788 110 C 830 112, 850 138, 880 140" stroke="#2563eb" stroke-width="3"></path>
<path d="M788 170 C 830 170, 850 170, 880 170" stroke="#94a3b8" stroke-width="2"></path>
<path d="M788 230 C 830 228, 850 202, 880 200" stroke="#2563eb" stroke-width="2.5"></path>
</g>

<!-- neurons -->
<g stroke="#e2e8f0" stroke-width="1.8">
<rect x="242" y="92" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="242" y="152" width="36" height="36" rx="4" fill="url(#hachNNg)"></rect>
<rect x="242" y="212" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="412" y="52" width="36" height="36" rx="4" fill="url(#hachNNg)"></rect>
<rect x="412" y="102" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="412" y="152" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="412" y="202" width="36" height="36" rx="4" fill="url(#hachNNg)"></rect>
<rect x="412" y="252" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="582" y="52" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="582" y="102" width="36" height="36" rx="4" fill="url(#hachNNg)"></rect>
<rect x="582" y="152" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="582" y="202" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="582" y="252" width="36" height="36" rx="4" fill="url(#hachNNg)"></rect>
<rect x="752" y="92" width="36" height="36" rx="4" fill="url(#hachNNg)"></rect>
<rect x="752" y="152" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
<rect x="752" y="212" width="36" height="36" rx="4" fill="url(#hachNN)"></rect>
</g>

<!-- output decision plot -->
<path d="M881 111 C 920 108, 960 112, 999 110 C 1001 150, 998 190, 1000 229 C 960 231, 920 228, 880 230 C 878 190, 882 150, 881 111" fill="url(#hachNNg)" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
<path d="M884 214 C 916 190, 948 160, 996 122" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round" stroke-dasharray="5 5"></path>
<g fill="#2563eb"><circle cx="898" cy="130" r="5"></circle><circle cx="920" cy="146" r="5"></circle><circle cx="904" cy="176" r="5"></circle><circle cx="944" cy="126" r="5"></circle><circle cx="926" cy="170" r="5"></circle></g>
<g fill="#e2e8f0"><circle cx="980" cy="160" r="5"></circle><circle cx="956" cy="196" r="5"></circle><circle cx="984" cy="210" r="5"></circle><circle cx="934" cy="214" r="5"></circle><circle cx="972" cy="186" r="5"></circle></g>

<!-- chassis cross-section -->
<path d="M192 462 C 400 458, 800 463, 1008 460 C 1010 510, 1007 570, 1009 610 C 800 612, 400 608, 191 611 C 189 570, 193 510, 192 462" fill="#0b1222" stroke="#e2e8f0" stroke-width="2.6" stroke-linecap="round"></path>
<path d="M189 459 C 420 463, 780 458, 1006 463 C 1007 520, 1011 575, 1006 613 C 780 609, 420 614, 194 608" fill="none" stroke="#e2e8f0" stroke-width="1.2" stroke-linecap="round"></path>
<path d="M202 594 C 400 592, 800 596, 998 593" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"></path>
<!-- NVMe -->
<path d="M220 552 C 250 550, 280 553, 310 551 C 311 562, 309 572, 311 582 C 280 584, 250 581, 219 583 C 218 572, 221 562, 220 552" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"></path>
<text x="265" y="573" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="500" font-size="14" fill="#94a3b8">nvme</text>
<!-- CPU -->
<path d="M341 506 C 370 504, 410 507, 439 505 C 441 530, 438 560, 440 584 C 410 586, 370 583, 340 585 C 338 560, 342 530, 341 506" fill="none" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
<rect x="362" y="525" width="56" height="40" rx="3" fill="url(#hachNN)" stroke="#e2e8f0" stroke-width="2"></rect>
<!-- RAM -->
<g fill="none" stroke="#e2e8f0" stroke-width="1.8"><rect x="466" y="498" width="9" height="88" rx="2"></rect><rect x="482" y="498" width="9" height="88" rx="2"></rect><rect x="498" y="498" width="9" height="88" rx="2"></rect><rect x="514" y="498" width="9" height="88" rx="2"></rect></g>
<!-- GPU -->
<path d="M580 492 C 680 489, 830 493, 932 490 C 934 515, 931 545, 933 572 C 830 574, 680 571, 579 573 C 578 545, 581 515, 580 492" fill="url(#hachNNg)" stroke="#e2e8f0" stroke-width="2.4" stroke-linecap="round"></path>
<path d="M584 573 L 928 573 L 928 584 L 584 584 Z" fill="url(#hachNN)" stroke="#e2e8f0" stroke-width="1.6"></path>
<path d="M670 502 C 688 502, 700 516, 700 532 C 700 550, 686 562, 670 562 C 652 562, 640 548, 640 532 C 640 514, 654 502, 672 503" fill="#0b1222" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
<g class="bs-fan-rotate" style="transform-origin: 670px 532px;">
<path d="M670 532 C 676 520, 684 514, 690 514 M670 532 C 682 538, 688 546, 688 552 M670 532 C 660 540, 652 544, 646 542 M670 532 C 662 522, 658 514, 660 508" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"></path>
</g>
<path d="M840 502 C 858 502, 870 516, 870 532 C 870 550, 856 562, 840 562 C 822 562, 810 548, 810 532 C 810 514, 824 502, 842 503" fill="#0b1222" stroke="#e2e8f0" stroke-width="2.2" stroke-linecap="round"></path>
<g class="bs-fan-rotate" style="transform-origin: 840px 532px;">
<path d="M840 532 C 846 520, 854 514, 860 514 M840 532 C 852 538, 858 546, 858 552 M840 532 C 830 540, 822 544, 816 542 M840 532 C 832 522, 828 514, 830 508" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round"></path>
</g>
<!-- PSU -->
<path d="M950 500 C 965 499, 985 501, 998 500 C 999 530, 997 560, 998 585 C 985 586, 965 584, 949 585 C 948 560, 951 530, 950 500" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"></path>
<path d="M958 516 L 990 516 M958 528 L 990 528 M958 540 L 990 540 M958 552 L 990 552 M958 564 L 990 564" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round"></path>

<!-- chassis labels -->
<text x="390" y="648" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="18" fill="#e2e8f0">i7-14700KF</text>
<text x="494" y="648" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="24" fill="#94a3b8">ram</text>
<text x="756" y="648" text-anchor="middle" font-family="Roboto Mono, monospace" font-weight="700" font-size="18" fill="#e2e8f0">RTX 4060 Ti · 16GB</text>
<text x="974" y="648" text-anchor="middle" font-family="Caveat, cursive" font-weight="700" font-size="24" fill="#94a3b8">psu</text>
<text x="1040" y="420" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#e2e8f0">weights live</text>
<text x="1040" y="450" font-family="Caveat, cursive" font-weight="700" font-size="26" fill="#e2e8f0">in VRAM</text>
<path d="M1060 462 C 1040 480, 960 486, 920 488" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round"></path>
<path d="M932 478 L 918 488 L 933 496" fill="none" stroke="#e2e8f0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</figure>
</div>
</section>
</main>

<?php
get_footer();
