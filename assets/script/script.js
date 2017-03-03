window.onload = function() {
	var iconRename = document.querySelectorAll('.icon-rename');
	var containerRename = document.querySelectorAll('.container-rename-field');

	var iconReplace = document.querySelectorAll('.icon-replace');
	var containerReplace = document.querySelectorAll('.container-replace-field');

	var iconModify = document.querySelectorAll('.icon-modify');
	var containerModify = document.querySelectorAll('.container-modify-field');

	for (var i = 0; i < iconRename.length; i ++) {
		iconRename[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'block'; // containerRename appears
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none'; //containerReplace disappears
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
			console.log(this.parentNode.parentNode.parentNode.childNodes[1]);
		};
	}

	for (var i = 0; i < iconReplace.length; i ++) {
		iconReplace[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'block'; // containerReplace appears
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'none'; // containerRename disappears
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
			console.log(this.parentNode.parentNode.parentNode.childNodes[2]);
		};
	}

	for (var i = 0; i < iconModify.length; i ++) {
		iconModify[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'block';
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
			console.log(this.parentNode.parentNode.parentNode.childNodes[3]);
		};
	}
};