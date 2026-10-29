# rainshade theme — context for Claude

Hybrid WordPress theme (PHP templates + theme.json + custom blocks) for **rainshade** (electronic artist, "dance music for sad people"). Debut album **Fall**, out 30.10.2026.
Links: https://linktr.ee/rainshade · https://www.youtube.com/@rainshade_music · rainshade.music@gmail.com

## Concept: the fogged window
- Front page opens on a photo behind fogged night glass; the visitor wipes it with cursor/finger, it slowly fogs up again.
- Water drops are tiny lenses (show the sharp photo behind, magnified); some run down in jerks leaving clear trails.
- Fog only on the hero (`rainshade/window`) and the quote (`rainshade/fog-quote`). Other images: plain, "Rain on hover" style.
- Tracklist is a weather forecast (bpm + "chance of tears"). Footer: "wipe the glass again ↑".
- Copy is lowercase; the artist name is always one word on one line: `rainshade`.
- Italic only for the "dance music for sad people" line — don't overuse italics.

## Rules
- **Fonts must have no Russian origin** — check provenance before adding any font. Current: Unbounded (NaN, Berlin / Studio Koto), Instrument Serif (Instrument, US), Geist Mono (Vercel + Basement). JetBrains Mono was removed for this reason.
- No audio/video files on the server — embeds only (Spotify/Bandcamp/Vimeo/YouTube).
- No ACF or other field plugins. Colors: Customizer → Colors (overrides the theme.json palette via `wp_theme_json_data_theme`). Fonts: theme.json presets + WP 7.0 Font Library.
- Keep it minimal; no over-engineering. Block editor JS is plain `wp.*` globals, no bundler.

## Structure
- PHP templates: `header.php`, `footer.php` (markup in `template-parts/header.php|footer.php`, menus in Appearance → Menus), `index.php`, `page.php`, `page-sections.php` (Template "Sections"), `404.php`. No block templates (`templates/`, `parts/`).
- `functions.php` only requires `inc/`: helpers, setup (supports, menus), assets, blocks, customizer.
- Every section is its own dynamic block in `blocks/` (window, release, fog-quote, visuals, photo-row, shows) so any page can be built from them.

## Build
`npm run watch` (gulp + BrowserSync proxy from `.env`, open http://localhost:3000). Edit `.scss` sources, never compiled `style.css` / `editor.css` / `blocks/*/style.css` / `scripts.min.js`. See README.md.