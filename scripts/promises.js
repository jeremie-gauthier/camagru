const imgLoadAsync = (src) => {
	return new Promise((resolve, reject) => {
		const img = new Image();
		img.src = src;
		img.onload = () => resolve(img);
		img.onerror = (err) => reject(err);
	});
};
