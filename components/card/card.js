const template = document.getElementById("template-card");
let currentOffset = 0;

const fetchCards = async (element, user = null) => {
	try {
		const url = `/components/card/request.php?offset=${currentOffset}&limit=5&user=${user}`;
		currentOffset += 5;
		const pictures = await AsyncRequest.get(url);
		console.log(pictures);
		addPicturesToDOM(element, pictures);
	} catch (err) {
		currentOffset -= 5;
		throw err;
	}
};

const addPicturesToDOM = (element, pictures) => {
	pictures.forEach((picture) => {
		const clone = document.importNode(template.content, true);

		clone.getElementById(
			"card-img"
		).src = `/assets/users/${picture.idPictures}.png`;

		element.appendChild(clone);
	});
};
