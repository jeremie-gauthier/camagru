const imgLoader = (src) => {
	return new Promise((resolve, reject) => {
		if (src.length <= 5) {
			reject(new Error("Cannot read data"));
		}
		const img = new Image();

		img.src = src;
		img.onload = () => resolve(img);
		img.onerror = (err) => reject(err);
	});
};
