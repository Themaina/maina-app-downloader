@once
    <style>
        .app-downloader { --ad-color: var(--primary-color, var(--tp-theme-primary, #0d6efd)); position: relative; z-index: 1; padding: clamp(5.5rem, 10vw, 8rem) 1rem 5rem; line-height: 1.5; }
        .app-downloader, .app-downloader *, .app-downloader *::before, .app-downloader *::after { box-sizing: border-box; }
        .app-downloader h1, .app-downloader p { text-transform: none; letter-spacing: normal; font-family: inherit; color: inherit; }
        .app-downloader a { text-decoration: none; }
        .app-downloader img { max-width: 100%; }
        .app-downloader svg[data-style="fill"] { fill: currentColor; }
        .app-downloader svg[data-style="line"] { fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        .app-downloader__card { max-width: 26rem; margin: 0 auto; text-align: center; }
        .app-downloader__icon { width: 4.5rem; height: 4.5rem; border-radius: 1.1rem; object-fit: cover; margin-bottom: 1.25rem; box-shadow: 0 4px 16px rgba(0, 0, 0, .12); }
        .app-downloader__title { font-size: clamp(1.6rem, 4vw, 2rem); font-weight: 700; line-height: 1.2; margin: 0 0 .5rem; }
        .app-downloader__text { margin: 0 0 2rem; opacity: .65; }
        .app-downloader__list { display: grid; gap: .75rem; }
        .app-downloader__label { margin: 1.75rem 0 .75rem; font-size: .75rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; opacity: .5; }
        .app-downloader__empty { padding: 1.75rem 1rem; border: 1px dashed currentColor; border-radius: .75rem; opacity: .6; }
        .app-downloader__open { display: inline-block; margin-top: 1.75rem; font-size: .9rem; opacity: .7; }
        .app-downloader__size { opacity: .7; font-weight: 500; }

        .app-downloader__btn {
            display: flex; align-items: center; justify-content: center; gap: .6rem;
            padding: .9rem 1.25rem; border-radius: .75rem; font-weight: 600; font-size: 1rem; line-height: 1.3; text-decoration: none;
            color: var(--ad-color); background: transparent; border: 1.5px solid color-mix(in srgb, var(--ad-color) 35%, transparent);
            transition: background-color .15s ease, border-color .15s ease, transform .15s ease;
        }
        .app-downloader__btn:hover, .app-downloader__btn:focus-visible { border-color: var(--ad-color); background: color-mix(in srgb, var(--ad-color) 8%, transparent); color: var(--ad-color); transform: translateY(-1px); }
        .app-downloader__btn svg { width: 1.3rem; height: 1.3rem; flex: none; }
        .app-downloader__btn--primary, .app-downloader__btn--primary:hover, .app-downloader__btn--primary:focus-visible { color: #fff; background: var(--ad-color); border-color: var(--ad-color); }
        .app-downloader__btn--primary { padding: 1.05rem 1.25rem; font-size: 1.1rem; }
        .app-downloader__btn--primary:hover, .app-downloader__btn--primary:focus-visible { filter: brightness(1.08); }

        /* Hero */
        .app-downloader--hero { padding: 0; }
        .app-downloader--hero .ad-hero { padding-top: clamp(7rem, 12vw, 9.5rem); }
        .ad-hero { position: relative; overflow: hidden; padding: 4.5rem 1rem 5rem; color: #fff; margin: 0; background: linear-gradient(135deg, var(--ad-color), color-mix(in srgb, var(--ad-color) 55%, #000)); }
        .ad-hero::before, .ad-hero::after { content: ""; position: absolute; border-radius: 50%; background: rgba(255, 255, 255, .07); }
        .ad-hero::before { width: 28rem; height: 28rem; top: -14rem; right: -8rem; }
        .ad-hero::after { width: 22rem; height: 22rem; bottom: -12rem; left: -6rem; }
        .ad-hero .app-downloader__card { position: relative; z-index: 1; }
        .ad-hero .app-downloader__icon { box-shadow: 0 0 0 .4rem rgba(255, 255, 255, .25); }
        .ad-hero .app-downloader__text { opacity: .85; }
        .ad-hero .app-downloader__btn { color: #fff; border-color: rgba(255, 255, 255, .45); }
        .ad-hero .app-downloader__btn:hover, .ad-hero .app-downloader__btn:focus-visible { color: #fff; border-color: #fff; background: rgba(255, 255, 255, .12); }
        .ad-hero .app-downloader__btn--primary, .ad-hero .app-downloader__btn--primary:hover, .ad-hero .app-downloader__btn--primary:focus-visible { color: var(--ad-color); background: #fff; border-color: #fff; filter: none; }
        .ad-hero .app-downloader__open { color: #fff; }

        /* Split */
        .ad-split { display: grid; gap: 2rem; align-items: center; max-width: 62rem; margin: 0 auto; }
        @media (min-width: 768px) { .ad-split { grid-template-columns: 1.1fr .9fr; gap: 3rem; } }
        .ad-split__copy { text-align: start; }
        .ad-split__copy .app-downloader__icon { margin-bottom: 1rem; }
        .ad-split__copy .app-downloader__text { margin-bottom: 1.75rem; }
        .ad-split__copy .app-downloader__list, .ad-split__copy .app-downloader__btn--primary { max-width: 24rem; }
        .ad-split__art { display: flex; justify-content: center; padding: 2.5rem 1rem; border-radius: 1.5rem; background: radial-gradient(circle at 30% 20%, color-mix(in srgb, var(--ad-color) 22%, transparent), transparent 62%), color-mix(in srgb, var(--ad-color) 7%, transparent); }
        .ad-phone { position: relative; width: 11.5rem; aspect-ratio: 9 / 18.5; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .9rem; border: .5rem solid #111827; border-radius: 2rem; color: #fff; background: linear-gradient(160deg, var(--ad-color), color-mix(in srgb, var(--ad-color) 50%, #000)); box-shadow: 0 18px 40px rgba(0, 0, 0, .25); }
        .ad-phone::before { content: ""; position: absolute; top: .45rem; width: 3rem; height: .35rem; border-radius: 99px; background: #111827; }
        .ad-phone__logo { width: 4rem; height: 4rem; border-radius: 1rem; object-fit: cover; display: grid; place-items: center; font-size: 1.8rem; font-weight: 700; background: rgba(255, 255, 255, .2); }
        .ad-phone__name { max-width: 85%; font-weight: 600; font-size: .95rem; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .ad-phone__bars { width: 60%; }
        .ad-phone__bars span { display: block; height: .35rem; margin: .4rem 0; border-radius: 99px; background: rgba(255, 255, 255, .35); }
        .ad-phone__bars span:nth-child(2) { width: 70%; }

        /* Tiles */
        .ad-tiles { max-width: 54rem; margin: 0 auto; text-align: center; }
        .ad-tiles__head { max-width: 26rem; margin: 0 auto; }
        .ad-tiles__grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(10.5rem, 1fr)); }
        .ad-tile { position: relative; display: flex; flex-direction: column; align-items: center; gap: .55rem; padding: 1.6rem 1rem 1.25rem; border-radius: 1rem; color: inherit; text-decoration: none; border: 1.5px solid color-mix(in srgb, currentColor 14%, transparent); transition: border-color .15s ease, box-shadow .15s ease, transform .15s ease; }
        .ad-tile:hover, .ad-tile:focus-visible { color: inherit; border-color: var(--ad-color); box-shadow: 0 10px 28px color-mix(in srgb, var(--ad-color) 18%, transparent); transform: translateY(-3px); }
        .ad-tile--on { border-color: var(--ad-color); background: color-mix(in srgb, var(--ad-color) 6%, transparent); }
        .ad-tile__icon { display: grid; place-items: center; width: 3.25rem; height: 3.25rem; border-radius: 50%; color: var(--ad-color); background: color-mix(in srgb, var(--ad-color) 12%, transparent); }
        .ad-tile__icon svg { width: 1.5rem; height: 1.5rem; }
        .ad-tile__name { font-weight: 600; line-height: 1.25; }
        .ad-tile__cta { font-size: .82rem; font-weight: 600; color: var(--ad-color); }
        .ad-tile__chip { position: absolute; top: -.6rem; left: 50%; transform: translateX(-50%); padding: .1rem .65rem; border-radius: 999px; font-size: .68rem; font-weight: 700; letter-spacing: .03em; text-transform: uppercase; white-space: nowrap; color: #fff; background: var(--ad-color); }

        @media (prefers-reduced-motion: reduce) { .app-downloader__btn, .ad-tile { transition: none; transform: none !important; } }
    </style>
@endonce
