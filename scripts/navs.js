let navs;
let contents;

window.onload = () => {
	navs = document.getElementsByClassName("extras");
	contents = document.getElementById("tab-content").children;
};

const switchNav = (element) => {
	const current = document.getElementsByClassName("active")[0];
	if (element === current) return;
	current.classList.remove("active");
	element.classList.add("active");
	for (content of contents) {
		if (
			content.getAttribute("aria-labelledby") === element.getAttribute("id")
		) {
			content.removeAttribute("hidden");
		} else {
			content.setAttribute("hidden", "");
		}
	}
};
