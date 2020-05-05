const mapElements = (ids) => {
	return ids.map((id) => document.getElementById(id));
};

const createElement = (parent, element, attrs = {}, innerHTML = null) => {
	const elem = document.createElement(element);
	const entries = Object.entries(attrs);
	for (const [attr, value] of entries) {
		elem.setAttribute(attr, value);
	}
	elem.innerHTML = innerHTML;
	parent.appendChild(elem);
	return elem;
};

const removeElement = (element) => {
	element?.parentNode?.removeChild(element);
};
