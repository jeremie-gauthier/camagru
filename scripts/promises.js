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

const fileReader = (file) => {
	return new Promise((resolve, reject) => {
		if (file.size === 0) {
			reject(new Error("Empty File"));
		}
		const reader = new FileReader();

		reader.readAsDataURL(file);
		reader.onload = () => resolve(reader.result);
		reader.onerror = (err) => reject(err);
	});
};
