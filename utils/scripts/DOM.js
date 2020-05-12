const setAttributes = (element, attributes) => {
	const attrs = Object.entries(attributes);
	for (const [attr, value] of attrs) {
		element.setAttribute(attr, value);
	}
};

const createElement = (parent, element, attrs = {}, innerHTML = null) => {
	const elem = document.createElement(element);
	setAttributes(elem, attrs);
	elem.innerHTML = innerHTML;
	parent.appendChild(elem);
	return elem;
};

const removeElement = (element) => {
	element?.parentNode?.removeChild(element);
};
