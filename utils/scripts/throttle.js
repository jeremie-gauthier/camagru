const throttle = (func, wait) => {
	let waiting;

	return function () {
		const ctx = this;

		if (!waiting) {
			func.apply(ctx, arguments);
			waiting = true;
			setTimeout(() => (waiting = false), wait);
		}
	};
};
