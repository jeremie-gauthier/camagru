const noPicInfo = document.getElementById("no-picture");
let nbPictures = document.getElementById("list-pictures").childElementCount;
let current = null;

if (nbPictures === 0) {
	noPicInfo.hidden = false;
}

const likePicture = async (elem) => {
	const add = () => {
		elem.innerHTML = "favorite";
		counter.innerHTML = parseInt(counter.innerHTML) + 1;
	};

	const del = () => {
		elem.innerHTML = "favorite_border";
		counter.innerHTML = parseInt(counter.innerHTML) - 1;
	};

	const pictureId = elem.id.split("like-card")[1];
	const url = `/gallery/src/handler.php?pictureId=${pictureId}`;
	const counter = document.getElementById(`sum-likes-card${pictureId}`);

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

const editLegend = (pictureId) => {
	try {
		const pictureLegend = document.getElementById(`legend-card${pictureId}`);

		overlay.hidden = false;
		overlayText.focus();
		overlayText.value = pictureLegend.innerHTML;
		overlayText.selectionStart = overlayText.textLength;
		counter.innerHTML = overlayText.textLength + "/255";
		current = pictureId;
	} catch (err) {
		showToast("error", err.message ?? err);
	}
};

const putLegend = async () => {
	const pictureLegend = document.getElementById(`legend-card${current}`);
	const tmp = pictureLegend.innerHTML;

	try {
		const url = "/gallery/src/handler.php";
		const data = { pictureId: current, legend: overlayText.value };
		const headers = { "Content-type": "application/x-www-form-urlencoded" };

		pictureLegend.innerHTML = overlayText.value;
		overlay.hidden = true;
		current = null;
		await AsyncRequest.put(url, data, headers);
	} catch (err) {
		showToast("error", err.message ?? err);
		pictureLegend.innerHTML = tmp;
	}
};

const delPicture = async (pictureId) => {
	const card = document.getElementById(`card${pictureId}`);

	try {
		const url = `picture/src/handler.php?id=${pictureId}`;

		card.hidden = true;
		nbPictures--;
		if (nbPictures === 0) {
			noPicInfo.hidden = false;
		}
		await AsyncRequest.delete(url);
		showToast("success", "Image supprim&eacute;e");
	} catch (err) {
		showToast("error", err.message ?? err);
		card.hidden = false;
		nbPictures++;
		noPicInfo.hidden = true;
	}
};
