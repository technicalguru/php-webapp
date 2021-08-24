
// Methods
/*
        case 'getCroppedCanvas':
          try {
            data.option = JSON.parse(data.option);
          } catch (e) {
            console.log(e.message);
          }

          if (image.data('uploadedImageType') === 'image/jpeg') {
            if (!data.option) {
              data.option = {};
            }

            data.option.fillColor = '#fff';
          }

          break;
      }

      result = cropper[data.method](data.option, data.secondOption);

      switch (data.method) {
        case 'getCroppedCanvas':
          if (result) {
            // Bootstrap's Modal
            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

            if (!download.disabled) {
              download.download = image.data('uploadedImageName');
              download.href = result.toDataURL(image.data('uploadedImageType'));
            }
          }

          break;

        case 'destroy':
          cropper = null;

          if (image.data('uploadedImageURL')) {
            URL.revokeObjectURL(image.data('uploadedImageURL'));
            image.data('uploadedImageURL', '');
            image.attr('src') = image.data('originalImageURL');
          }

          break;
      }

      if (typeof result === 'object' && result !== cropper && input) {
        try {
          input.value = JSON.stringify(result);
        } catch (e) {
          console.log(e.message);
        }
      }
    }
  });

jQuery('.cropper .docs-toggles').on('change', function() {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var cropBoxData;
    var canvasData;
    var isCheckbox;
    var isRadio;

    if (target.tagName.toLowerCase() === 'label') {
      target = target.querySelector('input');
    }

    isCheckbox = target.type === 'checkbox';
    isRadio = target.type === 'radio';

    if (isCheckbox || isRadio) {
      if (isCheckbox) {
        options[target.name] = target.checked;
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();

        options.ready = function () {
          console.log('ready');
          cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        };
      } else {
        options[target.name] = target.value;
        options.ready = function () {
          console.log('ready');
        };
      }

      // Restart
      cropper.destroy();
      cropper = new Cropper(image, options);
    }
  }
);
*/

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
			var oldId = null;
			if (options) {
				oldId = options.originalImageId;
				if (options.uploadedImageURL) {
					URL.revokeObjectURL(options.uploadedImageURL);
				}
			}

			var url = URL.createObjectURL(file);
			image[0].src = url;

			if (cropper) {
				// TODO remember deleted image for later delete with save
				cropperUI.destroy(this);
			}

			var reader = new FileReader();
			var foo    = this;
			reader.addEventListener('load', function(event) {
				var file = event.target;
				cropperUI.getOptions(foo).file = file.result;
			});
			reader.readAsDataURL(file);

			var newId = 'uploadImage-'+cropperUI.nextId();
			options = {
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
				deleteImageBody: 'Wenn Du auf "Weiter..." klickst, wird das Bild unwiderruflich gelöscht. Möchtest Du das?',
			},
			'en' : {
				addImageTitle: 'Adding a new image',
				addImageBody: 'You haven\'t saved the changes to the current image yet. You will lose all these changes when you click on "Continue...". Are you sure?',
				selectImageTitle: 'Editing another image',
				selectImageBody: 'You haven\'t saved the changes to the current image yet. You will lose all these changes when you click on "Continue...". Are you sure?',
				deleteImageTitle: 'Deleting image',
				deleteImageBody: 'This image will be deleted when you click on "Continue...". This action cannot be undone. Are you sure?',
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
			cropperUI.createCropper(this, options);
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
		if (event.type == 'ready') {
			cropperUI.getOptions(event.target).changed = false;
		} else {
			cropperUI.getOptions(event.target).changed = true;
		}
	}

	createCropper(domElement, options) {
		var elem = jQuery(domElement);
		options.destroyed = false;
		options.cropper   = new Cropper(domElement, {
            aspectRatio: 1,
		});
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

	selectImage(domElement, checkChange) {
		// ask for confirmation when image changed
		var cropper = this.getCropper(domElement);
		var options = this.getOptions(domElement);
		var imgId   = jQuery(domElement).data('imgid');
		if (!cropper || options.originalImageId != imgId) {
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
			this.createCropper(image[0], options);
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
			options.changed = false;
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
		if (cropper) {
			var options = this.getOptions(domElement);
			if (options.uploadedImageURL) {
				// TODO Upload with data options
			} else {
				// Send data options for modifications
			}
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
			webApp.POST(document.location, data, new WebAppAjaxController());
		}

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
}

var cropperUI = new CropperUI();
cropperUI.init();
