# GoodProcure — Hero Video & Image Generation Prompts

Use these to generate the hero background clips (and any supplementary imagery) with an
external AI tool — Midjourney/Ideogram/DALL-E for still "starter" frames, then Runway
Gen-3/Gen-4, Kling, Luma Dream Machine, or Pika for image-to-video animation. Image-to-video
(starter still → motion prompt) gives far more control and consistency than text-to-video
alone, which is why every entry below is split into two prompts.

Drop finished clips into `public/site/assets/videos/` using the exact filenames listed —
the site already links to them and will pick them up automatically, no code changes needed.

---

## Style bible — paste this into every tool's "style"/"context" field if it has one

**Look:** Dark industrial cinematic. Near-black base (#0A0C0F), moody low-key lighting from
practical sources only (warehouse sodium lamps, work lights, golden-hour window light, blue
hour sky) — never flat, bright, corporate-stock-photo lighting. One accent color pops per
scene: warm amber/gold (#FFB020) for warmth/industry, or cool cyan-blue (#33C7FF) for
tech/maritime scenes — pick whichever suits the subject, don't mix both in one clip.

**Camera:** Slow, deliberate, gimbal-smooth movement only — a slow push-in, a slow lateral
pan, a slow orbit, or subtle parallax. No handheld shake, no fast cuts, no whip pans.

**Treatment:** Real working environments (contractors, warehouses, ports, offices, rigs)
shot with premium editorial polish — shallow depth of field, soft bokeh, light film grain,
high contrast with crushed near-black shadows. Should feel like a Chevron/Shell/BW Pro brand
film, not generic stock footage.

**Format:** 16:9, 1920×1080 minimum (4K preferred if the tool supports it), 10–20 second
loop. First and last frame should be visually close enough to loop seamlessly (similar
framing/lighting) since it autoplays on repeat, muted, no audio track needed.

**Avoid (negative prompt):** on-screen text, logos, watermarks, readable brand names or
license plates, people looking/posing at camera, flat overcast daylight, cartoonish or
over-saturated rendering, fast/shaky camera motion, crowded chaotic framing.

---

## 1. Homepage hero — `hero-home.mp4`

**Starter image prompt:**
> Wide interior shot of a large industrial warehouse aisle at dusk, tall steel shelving
> racks loaded with wrapped pallets and crates receding into the distance, warm golden
> light streaming through high clerestory windows and cutting through fine dust in the air,
> a blurred silhouette of a worker in the mid-distance checking a tablet against a pallet,
> forklift parked to one side, near-black shadows in the foreground, cinematic wide-angle
> lens, shallow depth of field, moody amber and deep-navy color grade, photorealistic,
> 16:9, ultra-detailed

**Video motion prompt:**
> Slow, smooth forward dolly push down the warehouse aisle toward the worker, dust motes
> drifting through the golden light beams, very subtle parallax between foreground shelving
> and background, worker makes a small natural gesture (tapping the tablet), no camera
> shake, 12–15 second loop, first and last frame framing should match for a seamless loop

---

## 2. Services listing hero — `hero-services.mp4`

**Starter image prompt:**
> Elevated drone-height view of a busy industrial supply yard at blue hour, rows of
> shipping containers, stacked construction materials, and parked work trucks arranged in
> orderly grids, city or refinery silhouette faint on the horizon, deep navy-to-black sky
> with a thin band of amber sunset light at the horizon line, single warm sodium security
> light glowing in the yard, cinematic aerial photography, high contrast, 16:9

**Video motion prompt:**
> Very slow, smooth aerial push-forward/descend over the yard, as if a drone is gliding
> low and steady toward the horizon, no rotation, no fast movement, ambient light flicker
> from the sodium lamp only, 12–15 second loop

---

## 3. Office, Admin & Corporate Procurement — `hero-office-admin-corporate-procurement.mp4`

**Starter image prompt:**
> Clean modern corporate supply room, neat shelving stocked with boxed office equipment,
> printer paper, branded-blank shipping boxes, a person in business-casual attire
> mid-motion placing a box onto a shelf, soft warm interior lighting mixed with cool blue
> monitor glow from a desk visible in the background, shallow depth of field on the boxes
> in the foreground, muted navy and amber palette, editorial corporate photography style,
> 16:9

**Video motion prompt:**
> Slow lateral pan across the supply shelving as the person continues placing the box,
> soft focus pull from foreground boxes to the person in the background, calm and orderly
> pacing, 10–14 second loop

---

## 4. Technology & IT Procurement — `hero-technology-it-procurement.mp4`

**UPDATED per client feedback (Aug 2026): the original data-center/server-room concept was
misleading — this service is basic office computers and desktops, not enterprise
infrastructure. Use this prompt instead:**

**Starter image prompt:**
> Clean modern office desk setup, a desktop computer tower beside a monitor displaying a
> simple dashboard, keyboard and mouse, a stack of new-in-box computer peripherals nearby
> ready to be unboxed, soft warm daylight from a window mixed with the monitor's cool glow,
> shallow depth of field, calm and approachable atmosphere — not a server room, not
> industrial, just an ordinary well-lit office, editorial photography, 16:9

**Video motion prompt:**
> Slow, gentle push-in toward the desktop setup, monitor screen content shifts subtly,
> soft natural light shifts as if from passing clouds, calm and unhurried pacing, 10–14
> second loop

---

## 5. Construction & Infrastructure Procurement — `hero-construction-infrastructure-procurement.mp4`

**Starter image prompt:**
> Active construction site at golden hour, exposed steel rebar and structural beams in the
> foreground, a hard-hat worker in the mid-ground checking a clipboard against a stack of
> delivered materials, warm low sun flaring behind the structure, fine dust and light haze
> catching the sunlight, crane silhouette in the far background, cinematic wide shot, high
> contrast amber-and-charcoal color grade, 16:9

**Video motion prompt:**
> Slow diagonal push-in from the rebar in the foreground toward the worker, dust particles
> drifting through the golden backlight, distant crane makes an almost imperceptibly slow
> movement, 12–15 second loop

---

## 6. Oil & Gas Procurement & Consumables — `hero-oil-gas-procurement.mp4`

**Starter image prompt:**
> Industrial refinery or rig complex at dusk, network of pipes, valves, and steel walkways
> silhouetted against a deep navy sky, warm amber warning lights glowing along the
> structure, faint steam or vapor rising from a stack, wide establishing shot, moody
> low-key lighting, high contrast, cinematic industrial photography, 16:9

**Video motion prompt:**
> Slow, steady lateral pan across the pipework and structure, steam drifts slowly upward,
> amber lights hold a gentle steady glow with very slight flicker, no fast motion, 12–15
> second loop

---

## 7. Maritime Supply — `hero-maritime-supply.mp4`

**Starter image prompt:**
> Wide dockside shot at blue hour, a cargo vessel's hull and a gantry crane mid-load with a
> shipping container suspended, stacked containers in the foreground in soft focus, cool
> blue-navy sky transitioning to a thin warm horizon line, dock lights glowing amber in
> contrast to the cool ambient light, light sea mist in the air, cinematic wide-angle,
> 16:9

**Video motion prompt:**
> Slow orbit-style drift around the foreground containers revealing the vessel and crane,
> the suspended container continues its slow descent, gentle water reflections shimmer,
> 14–18 second loop

---

## 8. Site & Camp Welfare Supplies — `hero-site-camp-welfare-supplies.mp4`

**Starter image prompt:**
> Warm, human interior of a site/work-camp common room in the evening, neatly made bunks
> or a communal dining table visible, a worker unpacking a supply crate of everyday
> essentials, warm tungsten lighting (not industrial-cold), a small personal touch like a
> folded towel or a mug on the table, cozy but modest atmosphere, shallow depth of field,
> warm amber-and-brown color grade — noticeably warmer and more human than the other clips
> on this site, editorial documentary photography style, 16:9

**Video motion prompt:**
> Slow, gentle push-in on the worker unpacking the crate, soft handheld-feel but still
> smooth and controlled (subtle, not shaky), warm light flickers softly like a real bulb,
> 10–14 second loop

---

## 9. Products — `hero-products.mp4`

**Starter image prompt:**
> Close-up macro-style still life of procurement materials and tools arranged on a dark
> surface — work gloves, a coil of cable, a hard hat, small hardware components — softly
> lit from one side with a warm key light and a cool rim light for contrast, shallow depth
> of field with strong foreground-to-background blur falloff, moody product photography,
> near-black background, 16:9

**Video motion prompt:**
> Slow macro dolly/slide across the arranged items, focus racking gently from one item to
> the next, light glints subtly shift as the camera moves, 10–12 second loop

---

## 10. Blog — `hero-blog.mp4`

**Starter image prompt:**
> Overhead-angled desk scene, an open notebook with handwritten notes, a laptop showing a
> soft blurred procurement dashboard, a cup of coffee, a pen resting on a printed
> quotation/PO document, warm desk-lamp lighting against a dark background, shallow depth
> of field, editorial/documentary still-life photography, calm and thoughtful mood, 16:9

**Video motion prompt:**
> Slow top-down drift/push over the desk items, steam rises gently from the coffee, a hand
> enters softly to turn a notebook page or click the laptop trackpad, 10–14 second loop

---

## Notes on filenames (must match exactly)

```
public/site/assets/videos/hero-home.mp4
public/site/assets/videos/hero-services.mp4
public/site/assets/videos/hero-office-admin-corporate-procurement.mp4
public/site/assets/videos/hero-technology-it-procurement.mp4
public/site/assets/videos/hero-construction-infrastructure-procurement.mp4
public/site/assets/videos/hero-oil-gas-procurement.mp4
public/site/assets/videos/hero-maritime-supply.mp4
public/site/assets/videos/hero-site-camp-welfare-supplies.mp4
public/site/assets/videos/hero-products.mp4
public/site/assets/videos/hero-blog.mp4
```

Keep each file under ~8MB (compress with H.264, target bitrate ~4–6 Mbps at 1080p) so pages
stay fast — the hero videos autoplay muted/looped and load eagerly on the homepage, and
lazily on the other pages' `<video>` tags.

---
---

# Still Images

These are wired up the same way as the hero videos — just save the file with the exact
name below and it appears automatically, no admin upload needed. I did NOT include prompts
for team/About photos (`about-us-image-elite.jpg`, `board.jpg`, `board2.jpg`) — those are
real photos of the actual team and should stay real; that authenticity is core to this
brand's voice ("we're a growing company," "no reviews yet"). AI images below are only for
generic environmental/category imagery, never standing in for real people or real products.

**Format for all of these:** landscape, 1600×1200px minimum, JPG, same style bible as the
videos above (dark industrial cinematic, one accent color, premium editorial polish) —
these should look like a still frame pulled from the matching hero video.

## Service images (6) — shown on the services listing cards and each service's detail page

**1. Office, Admin & Corporate — `service-office-admin-corporate-procurement.jpg`**
> Clean modern office supply room, neatly organized shelving of boxed office equipment and
> printer paper, a person in business-casual attire holding a clipboard while reviewing
> stock, soft warm interior lighting with a cool blue monitor glow in the background,
> shallow depth of field, muted navy and amber palette, editorial corporate photography,
> near-black shadow falloff, 4:3 or 16:9, high detail

**2. Technology & IT — `service-technology-it-procurement.jpg`** (updated per client
feedback — basic office computers, not a data center)
> Clean modern office desk with a desktop computer tower, monitor, keyboard, and mouse,
> a small stack of boxed peripherals nearby, soft warm daylight mixed with the monitor's
> glow, shallow depth of field, calm and ordinary office setting, editorial photography

**3. Construction & Infrastructure — `service-construction-infrastructure-procurement.jpg`**
> Active construction site at golden hour, exposed steel rebar and structural beams in the
> foreground, a hard-hat worker checking a stack of delivered materials against a
> clipboard, warm low sun flaring behind the structure, fine dust catching the light,
> crane silhouette in the background, amber-and-charcoal color grade, cinematic wide shot

**4. Oil & Gas — `service-oil-gas-procurement.jpg`**
> Industrial refinery or rig complex at dusk, pipes, valves, and steel walkways
> silhouetted against a deep navy sky, warm amber warning lights glowing along the
> structure, faint steam rising from a stack, wide establishing shot, moody low-key
> lighting, high contrast, cinematic industrial photography

**5. Maritime Supply — `service-maritime-supply.jpg`**
> Dockside shot at blue hour, a cargo vessel's hull beside a gantry crane holding a
> suspended shipping container, stacked containers in soft-focus foreground, cool
> blue-navy sky with a thin warm horizon line, amber dock lights, light sea mist,
> cinematic wide-angle

**6. Site & Camp Welfare — `service-site-camp-welfare-supplies.jpg`**
> Warm, human interior of a site/work-camp common room in the evening, a worker unpacking
> a supply crate of everyday essentials onto a table, warm tungsten lighting (not
> industrial-cold), a small personal touch like a folded towel or a mug nearby, cozy but
> modest atmosphere, shallow depth of field, warm amber-and-brown grade — noticeably
> warmer/more human than the other five images, documentary photography style

Save all six to: `public/site/assets/images/`

```
service-office-admin-corporate-procurement.jpg
service-technology-it-procurement.jpg
service-construction-infrastructure-procurement.jpg
service-oil-gas-procurement.jpg
service-maritime-supply.jpg
service-site-camp-welfare-supplies.jpg
```

## Product placeholder — `product-placeholder.jpg`

Used as the fallback product-card image for any product that doesn't have its own photo
uploaded yet in the admin panel. Keep this generic — not a specific item, since it stands
in for many different real products.

> Close-up still-life of generic procurement materials and tools arranged on a dark
> surface — a coil of cable, a hard hat, work gloves, small hardware components — softly
> lit from one side with a warm key light and a cool rim light for contrast, shallow depth
> of field, moody product photography, near-black background, square or 4:3 crop

Save to: `public/site/assets/images/product-placeholder.jpg`

## Optional: social share cover image — `gps-og-cover.jpg`

A real file already exists at this path (used for Facebook/WhatsApp/LinkedIn link
previews when someone shares a page). Only regenerate this if you want to update it —
it's not broken or missing.

> Wide 1200×630px banner: dark near-black background, the GoodProcure shield logo
> positioned left-of-center, bold condensed uppercase headline space reserved for
> "Procurement You Can Actually Rely On." in steel blue, a subtle amber accent line,
> faint warehouse/industrial silhouette texture in the background at low opacity, clean
> and legible at thumbnail size, minimal, high contrast

Save to: `public/site/assets/images/gps-og-cover.jpg` (overwrites the existing one)
