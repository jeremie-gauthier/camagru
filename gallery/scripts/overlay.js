const overlay = document.getElementById("overlay-legend-container");
const overlayText = document.getElementById("overlay-legend-text");
const counter = document.getElementById("overlay-legend-counter");
const forbiddenInputs = ["&", "<", ">", "'", '"'];
let previousOverlayText = "";

overlay.onmousedown = ({ target }) => {
	if (target.id === overlay.id) {
		overlay.hidden = true;
		current = null;
	}
};

overlay.onkeyup = ({ key }) => {
	if (key === "Escape") {
		overlay.hidden = true;
		current = null;
	}
};

overlayText.onkeydown = () => {
	previousOverlayText = overlayText.value;
};

overlayText.oninput = (e) => {
	const {
		target: { textLength },
		data,
		inputType,
	} = e;

	if (inputType === "insertFromPaste") {
		overlayText.value = previousOverlayText;
		return;
	}

	if (forbiddenInputs.includes(data)) {
		overlayText.value = overlayText.value.slice(0, -1);
	} else {
		counter.innerHTML = textLength + "/255";
		if (textLength === 255) {
			counter.style.color = "red";
		} else {
			counter.style.color = "white";
		}
	}
};
