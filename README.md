# rainshade — block theme

Block theme (WordPress 6.7+, tested for 7.0). No plugins required.

## Editing
- **Colors & fonts:** Appearance → Editor → Styles. Everything uses theme.json presets
  (`base`, `surface`, `contrast`, `muted`, `accent`; fonts `display`, `serif`, `mono`).
  New fonts: Appearance → Fonts (WP 7.0 Font Library), then pick them in Styles.
- **Front page:** Appearance → Editor → Templates → Front page.

## Blocks
| Block | What it does |
|---|---|
| `rainshade/window` | Full-width photo behind fogged glass; visitors wipe it. Photo, focal point, release line, link — sidebar. |
| `rainshade/fog-quote` | Words written through fogged glass over a photo; hover clears it. |
| `rainshade/forecast` + `track` | Tracklist as a forecast: title, bpm, chance of tears. |
| `rainshade/shows` + `show` | Live dates; past dates hide themselves. |
| Image style **Rain on hover** | Any Image block → Styles → Rain on hover. |

Video: add a Vimeo/YouTube Embed block (no files on the server). For background loops use Vimeo with `?background=1`.

## Development
```
cp .env.example .env   # BROWSERSYNC_PROXY=https://rainshade.test
npm install
npm run watch          # build + BrowserSync; reloads on scss, js, php, theme.json, templates, block.json
npm run build          # one-off build
```
| Source | Output |
|---|---|
| `assets/scss/style.scss` (+ partials, theme header) | `style.css` |
| `assets/admin/editor.scss` | `assets/admin/editor.css` |
| `blocks/*/style.scss` | `blocks/*/style.css` |
| `assets/js/_*.js` | `assets/js/scripts.min.js` |

Compiled files are committed, so the theme works without a build on the server.

## Files
- `assets/js/_water.js` — fog canvas + water drops (no dependencies, pauses off-screen, respects reduced motion).
- `assets/fonts` — Unbounded, Instrument Serif, Geist Mono (SIL OFL 1.1), served locally.
- Block editor scripts (`blocks/*/editor.js`) are plain JS using `wp.*` globals — no bundler needed.
