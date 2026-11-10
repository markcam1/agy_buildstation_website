# Buildstation Style Guide

Brand reference for all marketing output: documents, video, images, posters.
Written to be dropped into an AI context window whole.

---

## Quick start

Everything needed to style something correctly, in copy-paste form.

**Hex values**

```
#0f172a  background
#2563eb  accent
#e2e8f0  text
#00ff41  urgent (one per frame)
#94a3b8  text dim
#1e293b  grid / borders
#3a4a5e  text enter (animation only)
```

**Fonts**

```
Poppins 800/900    headlines
Poppins 600        subheads
Roboto Mono 500/700  numbers, stats, labels, code
Inter 400/600      long-form body (documents only)
```

**CSS**

```css
:root {
  --bg: #0f172a;
  --accent: #2563eb;
  --text: #e2e8f0;
  --urgent: #00ff41;
  --text-dim: #94a3b8;
  --grid: #1e293b;
  --text-enter: #3a4a5e;

  --font-head: "Poppins", sans-serif;
  --font-mono: "Roboto Mono", monospace;
  --font-body: "Inter", sans-serif;
}
```

```html
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;800;900&family=Roboto+Mono:wght@500;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
```

**TypeScript** (`src/theme.ts` — Remotion loads fonts via `@remotion/google-fonts`, not the link tag above)

```ts
export const BG         = "#0f172a";
export const ACCENT     = "#2563eb";
export const TEXT       = "#e2e8f0";
export const URGENT     = "#00ff41";
export const TEXT_DIM   = "#94a3b8";
export const GRID       = "#1e293b";
export const TEXT_ENTER = "#3a4a5e";
```

**Prompt fragment** — paste into an image or video generation prompt

```
Palette strictly limited to deep blue-black #0f172a, electric blue #2563eb,
and light grey #e2e8f0, with a single neon green #00ff41 accent on exactly
one element. Dark background. Flat, technical, unglamorous. No gradients,
no glow, no lens flare.
```

**The five rules that matter most**

1. Dark background, always. No light-mode brand assets.
2. Every number a viewer should remember is Roboto Mono.
3. One `#00ff41` element per frame. Never two.
4. No fifth color.
5. Lead with the result.

---

## 1. The brand in one paragraph

Buildstation is a developer-facing channel about local AI, developer tooling, and
model testing on consumer hardware. The through-line is **constraint**: what
actually runs on the machine you own, measured rather than claimed. The aesthetic
is terminal-adjacent — dark surfaces, monospace numbers, high-contrast type, one
loud accent. Everything should look like it came off a workstation, not out of a
marketing deck.

**Voice:** measured, specific, unimpressed. Lead with the result. Name the
constraint. Show the number. No hype adjectives, no "game-changing," no emoji in
body copy.

---

## 2. Color

| Token | Hex | Role |
|---|---|---|
| `BG` | `#0f172a` | Background. Default surface everywhere. |
| `ACCENT` | `#2563eb` | Headings, key figures, emphasis, links, CTAs. |
| `TEXT` | `#e2e8f0` | Body copy, labels, captions. |
| `URGENT` | `#00ff41` | Urgency and hero numbers. **One element per frame.** |

Derived shades, for gradients, borders, and states:

| Token | Hex | Role |
|---|---|---|
| `TEXT_DIM` | `#94a3b8` | Secondary text, connective words, axis labels. |
| `GRID` | `#1e293b` | Hairlines, card borders, chart gridlines, background grids. |
| `TEXT_ENTER` | `#3a4a5e` | Entry shade for text animations. |

**Rules**

- Dark background always. No light-mode variants of brand assets.
- `URGENT` green is a spotlight, not a palette member. One element per frame, per
  slide, per poster. Two uses and it stops meaning anything.
- Never introduce a fifth hue. Topic-branded one-offs (a video about a specific
  product) may use that product's palette for *that project only*, and do not
  become brand assets.
- No gradients between brand colors. Flat fills, or a single subtle `BG`→`GRID`
  vignette.

---

## 3. Typography

| Role | Family | Weight |
|---|---|---|
| Headlines, hero text | Poppins | 800–900 |
| Subheads, connective words | Poppins | 600 |
| Numbers, stats, labels, code, filenames | Roboto Mono | 500–700 |
| Long-form body (documents only) | Inter | 400–600 |

**Rules**

- Every number a viewer is meant to remember is Roboto Mono. VRAM, tokens/sec,
  model size, rank, price. This is the single most load-bearing type rule in the
  brand.
- Roboto Mono exposes no weight above 700.
- Headlines are sentence case or ALL CAPS. Never Title Case.
- Tight tracking on headlines (`-0.02em`), normal on mono.
- Minimum on-screen size in video: 48px at 1080x1920.

---

## 4. Documents

Specs, READMEs, reports, LinkedIn posts, newsletter copy.

- **Markdown first.** Everything authors as `.md` and converts out.
- Tables beat paragraphs for anything comparative. If you wrote three sentences
  comparing two things, it was a table.
- Code, filenames, flags, and model names in backticks.
- Section headers are short noun phrases, not questions.
- Numbers get units and context inline: `14 tok/s on 16GB` not `fast`.
- No emoji. No bold for emphasis mid-sentence — restructure the sentence instead.
- Lead every document with the conclusion. The reader should be able to stop
  after the first paragraph and have the answer.
- When exported to PDF or slides: `BG` background, `TEXT` body, `ACCENT` headers,
  Roboto Mono for any figure.

---

## 5. Video

All video sits somewhere on a four-tier ladder from flat graphics to
photographic. Most videos use two or three tiers; mixing all four in one piece
reads as chaotic.

### Tier 1 — Motion graphics (Remotion)

Title cards, section cards, spec cards, charts, end cards.

- 9:16, 1080x1920, 30fps for Shorts. Landscape compositions follow their own
  layout.
- Flat fills on `BG`. Cards get a `1px solid GRID` edge and a soft drop shadow.
- Text lands in final position and changes color. It does not slide, spring, or
  overshoot.
- One motion idea per segment. Backgrounds and frames hold still.
- Timing at 30fps: word cascade 5–6 frames apart, color settle 20–25 frames
  front-loaded, box wipe 10–12 frames, exits 12–18 frames, minimum 30-frame hold
  on a completed frame.
- Caption band is fixed and reused across scenes.

Full implementation detail lives in the `buildstation-motion` skill.

### Tier 2 — Screen capture

Terminal sessions, Studio, dashboards, model output.

- Terminal theme matches the brand: `#0f172a` background, `#e2e8f0` text.
- Zoom so text is legible at phone size. If you have to squint on a 6" screen,
  it's too small — crop rather than scale the whole window.
- Speed-ramp dead time; never show a loading bar in real time.
- Highlight the result with an `URGENT` underline or box the moment it appears,
  then remove it.

### Tier 3 — Stylized render

Diagrams, abstract renders, character work, illustrated explainers.

- Dark field, limited palette, geometric. Think technical illustration, not
  concept art.
- Wireframes, isometric layouts, node graphs, exploded views.
- Hard no: glowing brains, humanoid robots, circuit-board faces, floating holographic
  UI, "digital transformation" abstractions.

### Tier 4 — Photographic

Hardware shots, desk b-roll, on-camera.

- Dark room, cool key light, one practical accent in frame. The accent light is
  the physical equivalent of `URGENT` — one source, not an RGB wash.
- Hardware in frame should be real and yours. Visible cables and imperfect cable
  management are on-brand; a staged minimalist desk is not.
- Shallow depth of field on component shots, deep on wide shots.
- No stock footage of people in offices. If a human appears, it's you.

### Transitions

Hard cuts between tiers. No crossfades, no whips, no zoom transitions. A motion
graphics card cuts straight to screen capture.

---

## 6. Images

### Generated images

Use narrative-prose prompts, not keyword lists. Specify, in order: subject and
action, environment, lighting, camera and lens, palette, mood. State the brand
palette explicitly by hex when the image is a brand asset.

Scaffold:

> A [subject] [doing something specific], in [environment]. Lit by [key light]
> with a single [accent color] practical source. Shot on [lens] at [aperture],
> [framing]. Palette limited to deep blue-black, electric blue, and light grey.
> [Mood], technical, unglamorous.

**Avoid:** symmetry for its own sake, lens flare, bokeh particles, chrome, neon
grids receding to a horizon, anything that reads as 2010s tech-stock.

### Photographic images

Same rules as Tier 4 video. Shoot wider than you need; crops to 16:9, 9:16, and
1:1 all come from the same frame.

### Treatment

- Images sit on `BG` with a `1px GRID` border and 12px corner radius.
- No drop shadows on photos, only on cards.
- Desaturate anything whose native colors fight the palette rather than
  color-grading it to match.

---

## 7. Posters and thumbnails

The highest-stakes surface. One job: make the constraint legible in under a
second.

### Format

| Use | Size |
|---|---|
| YouTube thumbnail | 1280x720 |
| Shorts cover | 1080x1920 |
| Social / LinkedIn | 1200x627 |
| Square | 1080x1080 |

### Rules

- **Four words maximum.** Three is better. The title bar carries the rest.
- The constraint is the headline: `16GB VRAM`, `$0 API`, `7B ONLY`. Not the topic.
- One hero number in Roboto Mono, oversized — 30–40% of frame height. This is
  usually where `URGENT` goes.
- Text occupies one half, subject the other. Never center-overlay text on a face.
- Hardware or terminal output as subject. Not a logo.
- High contrast at 10% scale. Check it by shrinking it, not by zooming in.
- No arrows, no circles, no shocked-face framing, no red/yellow outside the
  palette.

### Serialized formats

Series entries share a fixed template and vary one slot. The countdown series
holds layout, type, and palette constant and changes only the rank number and
the model name. Consistency across a series is worth more than per-thumbnail
optimization — viewers should recognize entry four from entry one.

---

## 8. Quick reference

**Always**

- Dark background, high contrast
- Mono for every number that matters
- One `URGENT` element per frame
- Lead with the result
- Hard cuts between visual tiers

**Never**

- Light-mode brand assets
- A fifth color
- Title Case headlines
- Emoji in body copy
- Glowing brains, humanoid robots, holographic UI
- Text sliding in from offscreen
- Stock photos of people
- More than four words on a thumbnail
