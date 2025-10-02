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

	function setArrowState(root, glide) {
		if (!root || !glide) return;

		const prevBtn = root.querySelector('.glide__arrow.glide__arrow--left');
		const nextBtn = root.querySelector('.glide__arrow.glide__arrow--right');

		// Reliable slide count from DOM
		const total = root.querySelectorAll('.glide__slide').length;

		// Glide settings + index fallbacks
		const perView = (glide && glide.settings && Number(glide.settings.perView)) || 1;
		const index = (typeof glide.index === 'number') ? glide.index : Number(glide.index) || 0;

		// last index visible (0-based). Use Math.max to avoid negative.
		const lastIndex = Math.max(0, Math.ceil(total - perView));

		// At-start / at-end boolean flags
		const atStart = index <= 0;
		const atEnd = index >= lastIndex;

		// Toggle root classes for styling (used to control shadow/peek display)
		root.classList.toggle('pf-carousel--at-start', atStart);
		root.classList.toggle('pf-carousel--at-end', atEnd);

		// Prev button
		if (prevBtn) {
			prevBtn.disabled = atStart; // native attribute -> unfocusable & non-clickable
			prevBtn.setAttribute('aria-disabled', atStart ? 'true' : 'false');
			prevBtn.classList.toggle('is-disabled', atStart); // optional
		}

		// Next button
		if (nextBtn) {
			nextBtn.disabled = atEnd;
			nextBtn.setAttribute('aria-disabled', atEnd ? 'true' : 'false');
			nextBtn.classList.toggle('is-disabled', atEnd);
		}
	}


	function initInstance(el) {
		if (!window.Glide) {
			console.error('[PF Carousel] Glide not found.');
			return;
		}
		if (el._pfGlide) return;

		const options = parseGlideOptionsFromAttrs(el);

		// If bounded mode is requested, force non-loop behavior
		const bounded = el.getAttribute('data-glide-bounded') === 'true' || options.bounded === true;
		if (bounded) {
			options.type = 'slider';   // non-looping
			options.rewind = false;    // do not rewind to start
			// Optionally set bound flag as well
			options.bound = true;
		}

		const glide = new window.Glide(el, options);
		glide.mount();
		el._pfGlide = glide;

		// Run once now to set arrow states
		setArrowState(el, glide);

		// Update arrow states after each run (user action or programmatic)
		glide.on('run.after', () => setArrowState(el, glide));
		glide.on('mount.after', () => setArrowState(el, glide));
		glide.on('resize', () => setArrowState(el, glide));
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
