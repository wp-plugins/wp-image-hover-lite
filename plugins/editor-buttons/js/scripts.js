(function() {
	var url;

	function get(id) {
		return document.getElementById(id);
	}

	function clone(obj) {
		var i, len, copy, attr;

		if (null == obj || "object" != typeof obj)
			return obj;

		// Handle Array
		if ('length' in obj) {
			copy = [];

			for (i = 0, len = obj.length; i < len; ++i) {
				copy[i] = clone(obj[i]);
			}

			return copy;
		}

		// Handle Object
		copy = {};
		for (attr in obj) {
			if (obj.hasOwnProperty(attr))
				copy[attr] = clone(obj[attr]);
		}

		return copy;
	}

	function getVal(id) {
		var elm = get(id);

		if (elm.nodeName == "SELECT")
			return elm.options[elm.selectedIndex].value;

		if (elm.type == "checkbox")
			return elm.checked;

		return elm.value;
	}

	function setVal(id, value, name) {
		if (typeof(value) != 'undefined' && value != null) {
			var elm = get(id);

			if (elm.nodeName == "SELECT")
				selectByValue(document.forms[0], id, value);
			else if (elm.type == "checkbox") {
				if (typeof(value) == 'string') {
					value = value.toLowerCase();
					value = (!name && value === 'true') || (name && value === name.toLowerCase());
				}
				elm.checked = !!value;
			} else
				elm.value = value;
		}
	}

	window.ImageHover = {
		init : function() {
			var html, editor, self = this;

			self.editor = editor = tinyMCEPopup.editor;

		},

		insert : function() {
			var editor = tinyMCEPopup.editor;

			this.formToData();
			tinyMCEPopup.restoreSelection();
			editor.selection.setNode(editor.plugins.wpimagehover.dataToImg(this.data));
			tinyMCEPopup.close();
		},

		formToData : function(field) {
			console.log(field);
			if (field == "width" || field == "height")
				this.changeSize(field);

			if (field == 'source') {
				setVal('source', this.editor.plugins.wpimagehover.dataToHtml(this.data));
				this.panel = 'source';
			} else {
				if (this.panel == 'source') {
					this.data = clone(this.editor.plugins.wpimagehover.htmlToData(getVal('source')));
					this.dataToForm();
					this.panel = '';
				}
			}
		},

		beforeResize : function() {
            this.width = parseInt(getVal('width') || (this.data.type == 'audio' ? "300" : "320"), 10);
            this.height = parseInt(getVal('height') || (this.data.type == 'audio' ? "32" : "240"), 10);
		},

		changeSize : function(type) {
			var width, height, scale, size;

			if (get('constrain').checked) {
                width = parseInt(getVal('width') || (this.data.type == 'audio' ? "300" : "320"), 10);
                height = parseInt(getVal('height') || (this.data.type == 'audio' ? "32" : "240"), 10);

				if (type == 'width') {
					this.height = Math.round((width / this.width) * height);
					setVal('height', this.height);
				} else {
					this.width = Math.round((height / this.height) * width);
					setVal('width', this.width);
				}
			}
		},

		setDefaultDialogSettings : function(editor) {
			var defaultDialogSettings = editor.getParam("media_dialog_defaults", {});
			tinymce.each(defaultDialogSettings, function(v, k) {
				setVal(k, v);
			});
		}
	};

	tinyMCEPopup.requireLangPack();
	tinyMCEPopup.onInit.add(function() {
		ImageHover.init();
	});
})();
