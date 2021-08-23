
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
				cropperUI.destroy(this, true);
			}

			var newId = 'uploadImage-'+cropperUI.nextId();
			options = {
				originalImageId:   newId,
				originalImageURL:  url,
				uploadedImageType: file.type,
				uploadedImageName: file.name,
				uploadedImageURL:  url,
				scaleX:            1,
				scaleY:            1,
			};
			// Add image at end of navbar
			var nav = cropperUI.getNav(this);
			if (nav) {
				var addLink = nav.find('a[data-imgid="newImg"]');
				var oldLink = oldId != null ? nav.find('a[data-imgid="'+oldId+'"]') : addLink;
				var html = '<a data-imgid="'+newId+'" href="#" onclick="cropperUI.selectImage(this); return false;"><img class="img-fluid img-thumbnail" style="margin:10px; max-height: 80%;" src="'+url+'"></a>';
				oldLink.before(html);
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

	addImage(domElement) {
		var cropper   = this.getCropper(domElement);
		if (cropper) {
			this.destroy(domElement, true);
		}
		var fileInput = jQuery(domElement).closest('.cropper').find('input[type="file"]');
		fileInput.trigger('click');
	}

	selectImage(domElement) {
		this.destroy(domElement, true);
		var imgId   = jQuery(domElement).data('imgid');
		var image   = this.getImage(domElement);
		var uri     = jQuery(domElement).find('img').attr('src');
		image[0].src = uri;
		var options = {
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
		}
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
			// TODO Ask for confirmation
			var options = this.getOptions(domElement);
			if (!options.uploadedImageURL) {
				// TODO Remove from server
			}
			this.destroy(domElement, false);
			// Remove from navigation
			var nav = this.getNav(domElement);
			if (nav) {
				var link = nav.find('a[data-imgid="'+options.originalImageId+'"]');
				// select next if any
				var nextImage = link.next();
				link.remove();
				if (nextImage.data('imgid') == 'newImg') nextImage = nextImage.prev();
				if ((nextImage.length == 0) || (nextImage.data('imgid') == 'newImg')) nextImage = null;
				if (nextImage != null) this.selectImage(nextImage[0]);
				nav.find('a[data-imgid="newImg"]').show();
			}
		}
	}

	info(domElement) {
		var options = this.getOptions(domElement);
		alert(options.originalImageId);
	}

	destroy(domElement, askForChange) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			cropper.destroy();
			var elem    = this.getImage(domElement);
			var options = this.getOptions(domElement);
			console.log('Changed '+options.changed);
			options.cropper = null;
			if (options.uploadedImageURL) {
				URL.revokeObjectURL(options.uploadedImageURL);
				options.uploadedImageURL = '';
			}
			elem.attr('src', '');
			elem.removeData('upload');
		}
		return true;
	}

}

var cropperUI = new CropperUI();
cropperUI.init();
