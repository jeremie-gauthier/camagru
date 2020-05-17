function debounce(func, wait) {
	let timeout;

	return function () {
		const ctx = this;

		const later = function () {
			timeout = null;
			func.apply(ctx, arguments);
		};

		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
	};
}
