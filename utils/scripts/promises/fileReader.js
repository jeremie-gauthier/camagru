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
