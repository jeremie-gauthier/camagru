const noPicInfo = document.getElementById("no-picture");
let nbPictures = document.getElementById("list-pictures").childElementCount;

if (nbPictures === 0) {
	noPicInfo.hidden = false;
}
