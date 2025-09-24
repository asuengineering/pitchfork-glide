// blocks/pf-carousel/view.js
(function () {
	// ----- Helpers -----------------------------------------------------------

	function toCamelCase(kebab) {
		return kebab.replace(/-([a-z])/g, (_, c) => c.toUpperCase());
	}

	function coerce(value) {
		// Cast strings from data-* into booleans, numbers, or JSON when appropriate
		if (value === 'true') return true;
		if (value === 'false') return false;
		if (value === 'null') return null;

		// Numbers
		if (!isNaN(value) && value.trim() !== '') return Number(value);

		// JSON (objects/arrays)
		if ((value.startsWith('{') && value.endsWith('}')) ||
			(value.startsWith('[') && value.endsWith(']'))) {
			try { return JSON.parse(value); } catch (e) { }
		}

		return value;
	}

	function parseGlideOptionsFromAttrs(el) {
		const opts = {};
		// Accept either data-glide or data-glide-* forms:
		//  - data-glide='{"type":"carousel","perView":3}'
		//  - data-glide-type="carousel" data-glide-per-view="3"
		const rootJson = el.getAttribute('data-glide');
		if (rootJson) {
			try {
				Object.assign(opts, JSON.parse(rootJson));
			} catch (e) {
				console.warn('[PF Carousel] Invalid JSON in data-glide:', e);
			}
		}

		for (const attr of el.attributes) {
			const name = attr.name;
			if (!name.startsWith('data-glide-')) continue;
			const key = toCamelCase(name.replace('data-glide-', '')); // e.g. per-view -> perView
			const raw = attr.value;
			opts[key] = coerce(raw);
		}

		// Sensible fallbacks (you can adjust later)
		if (opts.type == null) opts.type = 'carousel';
		if (opts.perView == null) opts.perView = 1;
		if (opts.gap == null) opts.gap = 0;

		return opts;
	}

	function initInstance(el) {
		if (!window.Glide) {
			console.error('[PF Carousel] Glide not found on window. Did you load glidejs-script first?');
			return;
		}
		if (el._pfGlide) return; // don’t double-init

		const options = parseGlideOptionsFromAttrs(el);
		// Keep a reference for debugging
		const glide = new window.Glide(el, options);
		glide.mount();
		el._pfGlide = glide;
	}

	function initAll() {
		document.querySelectorAll('.pf-carousel').forEach(initInstance);
	}

	// ----- Boot (frontend) ---------------------------------------------------
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAll);
	} else {
		initAll();
	}

	// ----- Editor support (re-init when blocks appear/update) ----------------
	// Works for ACF previews and core editor insertions.
	const isEditor = document.body.classList.contains('block-editor-page') ||
		document.body.classList.contains('wp-admin');

	if (isEditor && 'MutationObserver' in window) {
		const mo = new MutationObserver((mutations) => {
			for (const m of mutations) {
				// If our wrapper nodes were added, try init
				if (m.addedNodes && m.addedNodes.length) {
					initAll();
				}
			}
		});
		mo.observe(document.documentElement, { childList: true, subtree: true });
	}
})();
