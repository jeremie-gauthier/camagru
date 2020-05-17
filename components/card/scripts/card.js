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
		const {
			alreadyLiked,
			author,
			comments,
			diUsers,
			idPictures,
			legend,
			likes,
			regDate,
		} = picture;

		clone.getElementById("card-img").src = `/assets/users/${idPictures}.png`;

		clone.getElementById("card-title").innerHTML = author;

		const likeCounter = clone.getElementById("sum-likes-card");
		likeCounter.innerHTML = likes;

		const like = clone.getElementById("like-card");
		if (alreadyLiked === "0") like.innerHTML = "favorite_border";
		else if (alreadyLiked === "1") like.innerHTML = "favorite";
		like.onclick = () =>
			isUserLogged(likePicture)(like, likeCounter, idPictures);

		const commentCounter = clone.getElementById("sum-comments-card");
		commentCounter.id += idPictures;
		commentCounter.innerHTML = comments;

		const comment = clone.getElementById("comment-card");
		comment.onclick = () => isUserLogged(openComment)(idPictures);

		element.appendChild(clone);
	});
};
