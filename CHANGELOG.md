# Changelog

## 1.1.2
- Made with passion by maina888: author and links now point to mainax.vercel.app.
- PHP namespace is now `Maina888\AppDownloader`. Clear caches after updating (`php artisan optimize:clear`).
- New "Support this project" section and GitHub Sponsor link.

## 1.1.1
- Plugin id is `maina888/app-downloader` again, so sites that installed it from the marketplace keep receiving updates.
- Marketplace description file and README table fix.

## 1.1.0
- First public release on the Botble Marketplace, free under the MIT License.
- Vendor namespace is now `Maina888\AppDownloader`.
- Release zips are built automatically from GitHub releases.

## 1.0.0
- Initial release.
- Smart `/download` route that redirects by device: iOS, Android, Huawei AppGallery, Amazon Appstore, Windows, Microsoft Store, macOS, Linux.
- Minimal, theme-aware chooser page with app name, pitch, icon and optional "Open in app" deep link.
- Daily visit counter per platform (no personal data) and a QR code on the settings page.
- `?chooser=1` and `?platform=` URL options.
- English, Vietnamese, Spanish, French and Arabic translations.
- http(s)-only link validation; `no-store` and `Vary: User-Agent` headers; crawlers always get the chooser page.
- Four selectable chooser designs (Minimal, Hero, Split, Tiles) with accent colour and `?design=` preview.
- Chunked installer uploads per platform (up to 2 GB), served through a private download route.
- Simpler settings page.
- Works with themes whose header overlays the page; accent colour accepts any picker format.
- Unit tests for detection, fallbacks and deep-link validation.
