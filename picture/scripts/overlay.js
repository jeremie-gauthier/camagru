const comment = document.getElementById("overlay-text");
const counter = document.getElementById("overlay-counter");

overlay.onclick = (e) => {
	if (e.target.id === overlay.id) {
		overlay.hidden = true;
	}
};

overlay.onkeyup = (e) => {
	if (e.key === "Escape") {
		overlay.hidden = true;
	}
};

comment.oninput = ({ target }) => {
	const { textLength } = target;

	counter.innerHTML = textLength + "/255";
	if (textLength === 255) {
		counter.style.color = "red";
	} else {
		counter.style.color = "white";
	}
};
