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

const overlayCom = document.getElementById("overlay-comment-container");
const overlayTextCom = document.getElementById("overlay-comment-text");
const counterCom = document.getElementById("overlay-comment-counter");

overlayCom.onmousedown = ({ target }) => {
	if (target.id === overlayCom.id) {
		overlayCom.hidden = true;
		current = null;
	}
};

overlayCom.onkeyup = ({ key }) => {
	if (key === "Escape") {
		overlayCom.hidden = true;
		current = null;
	}
};

overlayTextCom.onkeydown = () => {
	previousOverlayText = overlayTextCom.value;
};

overlayTextCom.oninput = (e) => {
	const {
		target: { textLength },
		data,
		inputType,
	} = e;

	if (inputType === "insertFromPaste") {
		overlayTextCom.value = previousOverlayText;
		return;
	}

	if (forbiddenInputs.includes(data)) {
		overlayTextCom.value = overlayTextCom.value.slice(0, -1);
	} else {
		counterCom.innerHTML = textLength + "/255";
		if (textLength === 255) {
			counterCom.style.color = "red";
		} else {
			counterCom.style.color = "white";
		}
	}
};
