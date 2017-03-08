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

	// FILES
	for (var i = 0; i < iconModify.length; i ++) {
		iconModify[i].onclick = function() {
			this.parentNode.parentNode.childNodes[6].style.display = 'block';
			this.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.childNodes[3].style.display = 'none';
			this.parentNode.parentNode.childNodes[4].style.display = 'none';
			this.parentNode.parentNode.childNodes[5].style.display = 'none';
		};
	}
	for (var i = 0; i < iconRename.length; i ++) {
		iconRename[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'block'; // container rename
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none'; // container replace
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'none'; // container move
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'none'; // container delete 

			if (this.parentNode.parentNode.parentNode.childNodes[7] !== undefined) {
				this.parentNode.parentNode.parentNode.childNodes[6].style.display = 'none';
			}
		};
	}
	for (var i = 0; i < iconReplace.length; i ++) {
		iconReplace[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'block'; 
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'none';

			if (this.parentNode.parentNode.parentNode.childNodes[7] !== undefined) {
				this.parentNode.parentNode.parentNode.childNodes[6].style.display = 'none';
			}
		};
	}
	for (var i = 0; i < iconMove.length; i ++) {
		iconMove[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'block';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'none';

			if (this.parentNode.parentNode.parentNode.childNodes[7] !== undefined) {
				this.parentNode.parentNode.parentNode.childNodes[6].style.display = 'none';
			}
		};
	}
	for (var i = 0; i < iconDelete.length; i ++) {
		iconDelete[i].onclick = function() {
			this.parentNode.parentNode.parentNode.childNodes[5].style.display = 'block';
			this.parentNode.parentNode.parentNode.childNodes[2].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[3].style.display = 'none';
			this.parentNode.parentNode.parentNode.childNodes[4].style.display = 'none';

			if (this.parentNode.parentNode.parentNode.childNodes[7] !== undefined) {
				this.parentNode.parentNode.parentNode.childNodes[6].style.display = 'none';
			}
		};
	}
};