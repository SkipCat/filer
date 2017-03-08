window.onload = function() {
	var iconRename = document.querySelectorAll('.icon-rename');
	var iconReplace = document.querySelectorAll('.icon-replace');
	var iconModify = document.querySelectorAll('.icon-modify');
	var iconMove = document.querySelectorAll('.icon-move');
	var iconDelete = document.querySelectorAll('.icon-delete');

	var iconRenameFolder = document.querySelectorAll('.icon-rename-folder');
	var iconDeleteFolder = document.querySelectorAll('.icon-delete-folder');
	var iconMoveFolder = document.querySelectorAll('.icon-move-folder');

	var buttonNewFolder = document.querySelector('#button-folder');
	var formFolder = document.querySelector('.create-folder form');

	// FOLDER ACTIONS
	buttonNewFolder.onclick = function() {
		formFolder.style.display = 'flex';
	};
	for (var i = 0; i < iconRenameFolder.length; i ++) { // containerRenameFolder appears
		iconRenameFolder[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'block';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
		};
	}
	for (var i = 0; i < iconMoveFolder.length; i ++) { // containerMoveFolder appears
		iconMoveFolder[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'block';
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
		};
	}
	for (var i = 0; i < iconDeleteFolder.length; i ++) { // containerDeleteFolder appears
		iconDeleteFolder[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'block'; 
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
		};
	}

	// FILE ACTIONS
	for (var i = 0; i < iconRename.length; i ++) { // containerRename appears
		iconRename[i].onclick = function() {
			console.log(this.parentNode.parentNode.parentNode.childNodes[1], this.parentNode.parentNode.parentNode.childNodes[2], this.parentNode.parentNode.parentNode.childNodes[3], this.parentNode.parentNode.parentNode.childNodes[4], this.parentNode.parentNode.parentNode.childNodes[5]);
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'block';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none'; // containerReplace disappears
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none'; // containerModify disappears
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'none'; // containerMove disappears
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'none'; // containerDelete disappears

		};
	}
	for (var i = 0; i < iconReplace.length; i ++) { // containerReplace appears
		iconReplace[i].onclick = function() {
			console.log(this.parentNode.parentNode.parentNode.childNodes[2]);
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'block'; 
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'none';
		};
	}
	for (var i = 0; i < iconModify.length; i ++) { // containerReplace appears
		iconModify[i].onclick = function() {
			console.log(this.parentNode.parentNode.childNodes[3]);
			this.parentNode.parentNode.childNodes[3].style.display = 'block';
			this.parentNode.parentNode.childNodes[1].style.display = 'none';
			this.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.childNodes[4].style.display = 'none';
			this.parentNode.parentNode.childNodes[5].style.display = 'none';
		};
	}
	for (var i = 0; i < iconMove.length; i ++) { // containerReplace appears
		iconMove[i].onclick = function() {
			console.log(this.parentNode.parentNode.parentNode.childNodes[4]);
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'block'; 
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'none';
		};
	}
	for (var i = 0; i < iconDelete.length; i ++) { // containerReplace appears
		iconDelete[i].onclick = function() {
			console.log(this.parentNode.parentNode.parentNode.childNodes[5]);
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'flex'; 
			this.parentNode.parentNode.parentNode.childNodes[1].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'none';
		};
	}
};