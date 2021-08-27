
jQuery('.cropper input[type="file"]').on('change', function() {
	var files = this.files;
	var file;
	var cropper = cropperUI.getCropper(this);
	var image   = cropperUI.getImage(this);
	var options = cropperUI.getOptions(this);
	if (options && options.destroyed) {
		cropper = undefined;
		options = undefined;
	}

	if (files && files.length) {
		file = files[0];

		if (/^image\/\w+/.test(file.type)) {
			var oldId      = null;
			var replacedId = null;
			if (options) {
				oldId = options.originalImageId;
				replacedId = oldId;
				if (options.uploadedImageURL) {
					URL.revokeObjectURL(options.uploadedImageURL);
				}
				if (options.replacedImageId) {
					replacedId = options.replacedImageId;
				}
			}

			if (cropper) {
				cropperUI.destroy(this);
			}

			var url = URL.createObjectURL(file);
			image[0].src = url;

			var reader = new FileReader();
			var foo    = this;
			reader.addEventListener('load', function(event) {
				var file = event.target;
				cropperUI.getOptions(foo).file = file.result;
			});
			reader.readAsDataURL(file);

			var newId = 'uploadImage-'+cropperUI.nextId();
			options = {
				replacedImageId:   replacedId,
				originalImageId:   newId,
				originalImageURL:  url,
				uploadedImageType: file.type,
				uploadedImageName: file.name,
				uploadedImageURL:  url,
				scaleX:            1,
				scaleY:            1,
				file:              null,
			};
			// Add image at end of navbar
			var nav = cropperUI.getNav(this);
			if (nav) {
				var addLink = nav.find('a[data-imgid="newImg"]');
				var oldLink = oldId != null ? nav.find('a[data-imgid="'+oldId+'"]') : addLink;
				var html = '<a class="cropper-nav-link" data-imgid="'+newId+'" href="#" onclick="cropperUI.selectImage(this, true); return false;"><img class="img-fluid img-thumbnail" src="'+url+'"></a>';
				oldLink.before(html);
				var newLink = nav.find('a[data-imgid="'+newId+'"]');
				cropperUI.addNavigationLinks(newLink);
				if (oldId != null) oldLink.remove();
				if (nav.data('maximages') < nav.children().length) {
					addLink.hide();
				}
			}
			// Create the cropper
			cropperUI.createCropper(image[0], options);
			this.value = null;
		} else {
			window.alert('Please choose an image file.');
		}
	}
});

class CropperUI {

	constructor() {
		this.idGen = 1;
		webApp.registerI18N(new I18N({
			'de' : {
				addImageTitle: 'Bild hinzufügen',
				addImageBody: 'Du hast die Änderungen am aktuellen Bild noch nicht gespeichert. Wenn Du auf "Weiter..." klickst, gehen diese Änderungen verloren. Möchtest Du das?',
				selectImageTitle: 'Anderes Bild ändern',
				selectImageBody: 'Du hast die Änderungen am aktuellen Bild noch nicht gespeichert. Wenn Du auf "Weiter..." klickst, gehen diese Änderungen verloren. Möchtest Du das?',
				deleteImageTitle: 'Bild löschen',
				deleteImageBody:  'Wenn Du auf "Weiter..." klickst, wird das Bild unwiderruflich gelöscht. Möchtest Du das?',
				deleteFailedTitle:'Das Bild konnte nicht gelöscht werden.',
				deleteFailedText: 'Leider konnten wir das Bild nicht vom Server löschen. Bitte versuche es später noch einmal.',
				saveFailedTitle:  'Das Bild konnte nicht gespeichert werden.',
				saveFailedText:   'Leider konnten wir das Bild auf dem Server nicht speichern. Bitte versuche es später noch einmal.',
			},
			'en' : {
				addImageTitle: 'Adding a new image',
				addImageBody: 'You haven\'t saved the changes to the current image yet. You will lose all these changes when you click on "Continue...". Are you sure?',
				selectImageTitle: 'Editing another image',
				selectImageBody: 'You haven\'t saved the changes to the current image yet. You will lose all these changes when you click on "Continue...". Are you sure?',
				deleteImageTitle: 'Deleting image',
				deleteImageBody: 'This image will be deleted when you click on "Continue...". This action cannot be undone. Are you sure?',
				deleteFailedTitle:'The image could not be deleted.',
				deleteFailedText: 'We are sorry but we couldn\'t delete the image from our server. Please retry later!',
				saveFailedTitle:  'The image could not be saved.',
				saveFailedText:   'We are sorry but we couldn\'t save the image on our server. Please retry later!',
			},
		}));
	}

	init() {
		jQuery('img.cropper-image').each(function(index) {
			var options = {
				originalImageId:   this.getAttribute('data-imgid'),
				originalImageURL:  this.src,
				uploadedImageType: 'image/jpeg',
				uploadedImageName: 'cropped.jpg',
				uploadedImageURL:  '',
				scaleX:            1,
				scaleY:            1,
			};
			var cropperOptions = { autoCrop: false };
			cropperUI.createCropper(this, options, cropperOptions);
		});
		jQuery('[data-toggle="tooltip"]').tooltip();
		jQuery('.cropper-nav a.cropper-nav-link').each(function(index) {
			cropperUI.addNavigationLinks(this);
		});
	}

	nextId() {
		this.idGen++;
		return this.idGen-1;
	}

	cropperChanged(event) {
		var options = cropperUI.getOptions(event.target);
		if (event.type == 'ready') {
			options.changed = options.uploadedImageURL ? true : false;
		} else {
			options.changed = true;
		}
	}

	createCropper(domElement, options, cropperOptions) {
		var elem = jQuery(domElement);
		options.destroyed = false;
		if (!cropperOptions) cropperOptions = {};
		var mainElem = elem.closest('.cropper');
		cropperOptions.aspectRatio = mainElem.data('aspect-ratio');
		options.cropper   = new Cropper(domElement, cropperOptions);
		elem.data('upload', options);
		this.registerEvents(domElement);
	}

	addNavigationLinks(domElement) {
		jQuery(domElement).mouseenter(function() {
			jQuery(this).find('.cropper-nav-link-hover').show();
		}).mouseleave(function() {
			jQuery(this).find('.cropper-nav-link-hover').hide();
		}).append(
			'<div class="cropper-nav-link-hover" style="display: none;">'+
				'<span class="fa fa-angle-left"  onClick="cropperUI.moveLeft(event, this);" title="Move Left"></span>'+
				'<span class="fa fa-angle-right" onClick="cropperUI.moveRight(event, this);" title="Move Right"></span>'+
			'</div>'
		);
	}

	registerEvents(domElement) {
		var events = [ 'crop', 'ready' ];
		events.forEach(e => domElement.addEventListener(e, this.cropperChanged, false));
	}

	getNav(domElement) {
		var nav = jQuery(domElement).closest('.cropper').find('.cropper-nav');
		if (nav.length == 0) return null;
		return nav;
	}

	getImage(domElement) {
		return jQuery(domElement).closest('.cropper').find('img.cropper-image');
	}

	getOptions(domElement) {
		return this.getImage(domElement).data('upload');
	}

	getCropper(domElement) {
		var options = this.getOptions(domElement);
		if (options && options.cropper) return options.cropper;
		return undefined;
	}

	addImage(domElement, checkChange) {
		var cropper   = this.getCropper(domElement);
		if (cropper) {
			// ask for confirmation when image changed
			if (checkChange) {
				var options = this.getOptions(domElement);
				if (options.changed) {
					var modal = new AddImageModal(domElement);
					modal.show();
					return;
				}
			}
			this.destroy(domElement);
		}
		var fileInput = jQuery(domElement).closest('.cropper').find('input[type="file"]');
		fileInput.trigger('click');
	}

	moveLeft(event, domElement) {
		var link = this.findNavLink(domElement);
		if (link.prev()) {
			link.prev().insertAfter(link);
			this.saveOrder(domElement);
		}
		event.stopPropagation();
	}

	moveRight(event, domElement) {
		var link = this.findNavLink(domElement);
		if (link.next() && (link.next().data('imgid') != 'newImg')) {
			link.next().insertBefore(link);
			this.saveOrder(domElement);
		}
		event.stopPropagation();
	}

	findNavLink(domElement) {
		var rc = jQuery(domElement);
		while ((rc.length > 0) && !rc.data('imgid')) {
			rc = rc.parent();
		}
		return rc;
	}

	selectImage(domElement, checkChange, ignoreIdChange) {
		// ask for confirmation when image changed
		var cropper = this.getCropper(domElement);
		var options = this.getOptions(domElement);
		var imgId   = jQuery(domElement).data('imgid');
		if (!cropper || ignoreIdChange || (options.originalImageId != imgId)) {
			if (checkChange) {
				if (cropper && options.changed) {
					var modal = new SelectImageModal(domElement);
					modal.show();
					return;
				}
			}
			this.destroy(domElement);
			var image   = this.getImage(domElement);
			var uri     = jQuery(domElement).find('img').attr('src');
			image[0].src = uri;
			options = {
				originalImageId:   imgId,
				originalImageURL:  uri,
				uploadedImageType: 'image/jpeg',
				uploadedImageName: 'cropped.jpg',
				uploadedImageURL:  '',
				scaleX:            1,
				scaleY:            1,
			};
			var cropperOptions = {
				autoCrop: false,
			};
			this.createCropper(image[0], options, cropperOptions);
		}
	}

	setDragMode(domElement, value) {
		var cropper = this.getCropper(domElement);
		if (cropper) cropper.setDragMode(value);
	}

	rotate(domElement, value) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			if (cropper.cropped && cropper.options.viewMode > 0) {
				cropper.clear();
			}
			cropper.rotate(value);
			if (cropper.cropped && cropper.options.viewMode > 0) {
				cropper.crop();
			}
		}
	}

	scaleX(domElement, value) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			var options = this.getOptions(domElement);
			options.scaleX = value*options.scaleX;
			cropper.scaleX(options.scaleX);
		}
	}

	scaleY(domElement, value) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			var options = this.getOptions(domElement);
			options.scaleY = value*options.scaleY;
			cropper.scaleY(options.scaleY);
		}
	}

	reset(domElement) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			cropper.reset();
			var options = this.getOptions(domElement);
			options.scaleX = 1;
			options.scaleY = 1;
			options.changed = options.uploadedImageURL ? true : false;
		}
	}

	saveOrder(domElement) {
		var nav  = this.getNav(domElement);
		var list = [];
		nav.children().each(function(index) {
			var link = jQuery(this);
			if ((link.data('imgid') != 'newImg') && !link.find('img').attr('src').startsWith('blob:')) {
				list.push(link.data('imgid'));
			}
		});
		// Save to server
		var data = {
			action: 'changeOrder',
			order:  list,
		}
		webApp.POST(document.location, data, new WebAppAjaxController());
	}

	save(domElement) {
		var cropper = this.getCropper(domElement);
		var options = this.getOptions(domElement);
		if (cropper && options.changed) {
			var data = {
				action:        'save',
				imageId:       options.originalImageId,
				data:          cropper.getData(),
				containerData: cropper.getContainerData(),
				imageData:     cropper.getImageData(),
				canvasData:    cropper.getCanvasData(),
				cropBoxData:   cropper.getCropBoxData(),
				order:         [],
				replacedId:    null,
				blob:          null,
			}
			if (options.replacedImageId) {
				data.replacedId = options.replacedImageId;
			}
			if (options.uploadedImageURL) {
				// Upload with data options
				data.blob = options.file;
			}
			var nav  = this.getNav(domElement);
			if (nav) {
				nav.children().each(function(index) {
					var link = jQuery(this);
					if (link.data('imgid') != 'newImg') {
						if (link.find('img').attr('src') != options.uploadedImageURL) {
							data.order.push(link.data('imgid'));
						} else {
							data.order.push('NEW');
						}
					}
				});
			}
			// Send data options for modifications
			webApp.POST(document.location, data, new SaveImageAjaxController(domElement));
		}
	}

	delete(domElement) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			// Ask for confirmation
			var modal = new DeleteImageModal(domElement);
			modal.show();
		}
	}

	info(domElement) {
		var options = this.getOptions(domElement);
		if (options.file) {
			alert(JSON.stringify(options.file));
		} else {
			alert(options.originalImageId);
		}
	}

	destroy(domElement, askForChange) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			cropper.destroy();
			var elem    = this.getImage(domElement);
			var options = this.getOptions(domElement);
			options.cropper = null;
			if (options.uploadedImageURL) {
				URL.revokeObjectURL(options.uploadedImageURL);
				options.uploadedImageURL = '';
			}
			elem.attr('src', '');
			elem.removeData('upload');
		}
	}

}

class ChangeConfirmModal extends WebAppModal {

	constructor(id, domElement, title, body) {
		super(id);
		this.domElement = domElement;
		this.setTitle(title);
		this.setBody(body);
		this.addButton(webApp.i18n('continue'), 'btn-danger', '');
		this.setCloseLabel(webApp.i18n('cancel'));
		jQuery('#'+this.id+' .btn-danger').on('click', jQuery.proxy(this.yesClicked, this));
		jQuery('#'+this.id+' .close-button').on('click', jQuery.proxy(this.noClicked, this));
	}

	yesClicked() {
		this.end();
	}

	noClicked() {
		this.end();
	}
}

class AddImageModal extends ChangeConfirmModal {

	constructor(domElement) {
		super('confirmChangeModal', domElement, webApp.i18n('addImageTitle'), webApp.i18n('addImageBody'));
	}

	yesClicked() {
		this.end();
		cropperUI.addImage(this.domElement, false);
	}
}

class SelectImageModal extends ChangeConfirmModal {

	constructor(domElement) {
		super('confirmSelectModal', domElement, webApp.i18n('selectImageTitle'), webApp.i18n('selectImageBody'));
	}

	yesClicked() {
		this.end();
		cropperUI.selectImage(this.domElement, false);
	}
}

class DeleteImageModal extends ChangeConfirmModal {

	constructor(domElement) {
		super('confirmDeleteModal', domElement, webApp.i18n('deleteImageTitle'), webApp.i18n('deleteImageBody'));
	}

	yesClicked() {
		this.end();

		var options = cropperUI.getOptions(this.domElement);
		if (!options.uploadedImageURL) {
			// Remove from server
			var data = {
				action:  'delete',
				imageId: options.originalImageId,
			}
			webApp.POST(document.location, data, new DeleteImageAjaxController(this.domElement));
		} else {
			var handler = new DeleteImageAjaxController(this.domElement);
			handler.deleteImage();
		}
	}

}

class SaveImageAjaxController extends WebAppDefaultAjaxController {

	constructor(domElement) {
		super();
		this.domElement = domElement;
	}

	done(ajaxParams, data, textStatus, jqXHR) {
		super.done(ajaxParams, data, textStatus, jqXHR);
		if (data.success) {
			var options = cropperUI.getOptions(this.domElement);
			// Change nav and editor URL (replace/reset?), set changed to FALSE
			var nav = cropperUI.getNav(this.domElement);
			if (nav) {
				var link = nav.find('a[data-imgid="'+options.originalImageId+'"]');
				var d = new Date();
				link.find('img').attr('src', data.data.path+'?'+d.getTime());
				link.data('imgid', data.data.id);
				link.attr('data-imgid', data.data.id);
				options.changed = false;
				// Select image
				cropperUI.selectImage(link[0], false, true);
			} else {
				// No nav to help here
				options = {
					replacedImageId:   null,
					originalImageId:   data.data.id,
					originalImageURL:  data.data.path,
					uploadedImageType: 'image/jpeg',
					uploadedImageName: 'upload.jpeg',
					uploadedImageURL:  null,
					scaleX:            1,
					scaleY:            1,
					file:              null,
				};
				cropperUI.destroy(this.domElement);
				var image = cropperUI.getImage(this.domElement);
				cropperUI.createCropper(image[0], options);
			}
		} else {
			this.showError();
		}
	}

	fail(ajaxParams, jqXHR, textStatus, errorThrown) {
		super.fail(ajaxParams, jqXHR, textStatus, errorThrown);
		this.showError();
	}

	showError() {
		// Show error message
		webApp.error(webApp.i18n('saveFailedTitle'), webApp.i18n('saveFailedText'));
	}
}

class DeleteImageAjaxController extends WebAppDefaultAjaxController {

	constructor(domElement) {
		super();
		this.domElement = domElement;
	}

	done(ajaxParams, data, textStatus, jqXHR) {
		super.done(ajaxParams, data, textStatus, jqXHR);
		if (data.success) {
			this.deleteImage();
		} else {
			this.showError();
		}
	}

	fail(ajaxParams, jqXHR, textStatus, errorThrown) {
		super.fail(ajaxParams, jqXHR, textStatus, errorThrown);
		this.showError();
	}

	deleteImage() {
		var options = cropperUI.getOptions(this.domElement);
		cropperUI.destroy(this.domElement);
		// Remove from navigation
		var nav = cropperUI.getNav(this.domElement);
		if (nav) {
			var link = nav.find('a[data-imgid="'+options.originalImageId+'"]');
			// select next if any
			var nextImage = link.next();
			link.remove();
			if (nextImage.data('imgid') == 'newImg') nextImage = nextImage.prev();
			if ((nextImage.length == 0) || (nextImage.data('imgid') == 'newImg')) nextImage = null;
			if (nextImage != null) cropperUI.selectImage(nextImage[0]);
			nav.find('a[data-imgid="newImg"]').show();
		}
	}

	showError() {
		// Show error message
		webApp.error(webApp.i18n('deleteFailedTitle'), webApp.i18n('deleteFailedText'));
	}
}

var cropperUI = new CropperUI();
cropperUI.init();
