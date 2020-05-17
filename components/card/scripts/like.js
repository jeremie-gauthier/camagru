const likePicture = async (elem, counter, pictureId) => {
	const add = () => {
		elem.innerHTML = "favorite";
		counter.innerHTML = parseInt(counter.innerHTML) + 1;
	};

	const del = () => {
		elem.innerHTML = "favorite_border";
		counter.innerHTML = parseInt(counter.innerHTML) - 1;
	};

	const url = `/gallery/src/handler.php?pictureId=${pictureId}`;

	try {
		if (elem.innerHTML == "favorite_border") {
			add();
			await AsyncRequest.get(url);
		} else {
			del();
			await AsyncRequest.delete(url);
		}
	} catch (err) {
		showToast("error", err.message ?? err);
		if (elem.innerHTML === "favorite_border") add();
		else del();
	}
};
