const comment = document.getElementById("overlay-text");
const counter = document.getElementById("overlay-counter");
const forbiddenInputs = ["&", "<", ">", "'", '"'];
let previousOverlayText = "";

overlay.onmousedown = (e) => {
	if (e.target.id === overlay.id) {
		overlay.hidden = true;
	}
};

overlay.onkeyup = ({ key }) => {
	if (key === "Escape") {
		overlay.hidden = true;
	}
};

comment.onkeydown = () => {
	previousOverlayText = comment.value;
};

comment.oninput = (e) => {
	const {
		target: { textLength },
		data,
		inputType,
	} = e;

	if (inputType === "insertFromPaste") {
		comment.value = previousOverlayText;
		return;
	}

	if (forbiddenInputs.includes(data)) {
		comment.value = comment.value.slice(0, -1);
	} else {
		counter.innerHTML = textLength + "/255";
		if (textLength === 255) {
			counter.style.color = "red";
		} else {
			counter.style.color = "white";
		}
	}
};
