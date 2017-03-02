window.onload = function() {
	var iconRename = document.querySelectorAll('.icon-rename');
	var containerRename = document.querySelectorAll('.container-rename-field');

	var iconReplace = document.querySelectorAll('.icon-replace');
	var containerReplace = document.querySelectorAll('.container-replace-field');

	for (var i = 0; i < iconRename.length; i ++) {
		iconRename[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'block';
			console.log(this.parentNode.parentNode.parentNode.childNodes[1]);
		};
	}

	for (var i = 0; i < iconReplace.length; i ++) {
		iconReplace[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'block';
			console.log(this.parentNode.parentNode.parentNode.childNodes[2]);
		};
	}
};