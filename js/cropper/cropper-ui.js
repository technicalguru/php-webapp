
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
	var options = image.data('upload');

	if (files && files.length) {
		file = files[0];

		if (/^image\/\w+/.test(file.type)) {
			options.uploadedImageType = file.type;
			options.uploadedImageName = file.name;
			options.scaleX            = 1;
			options.scaleY            = 1;

			if (options.uploadedImageURL) {
				URL.revokeObjectURL(options.uploadedImageURL);
			}

			var url = URL.createObjectURL(file);
			image[0].src = url;

			if (cropper) {
				cropper.destroy();
				image.data('cropper', null);
			}

			options = {
				originalImageURL:  url,
				uploadedImageType: file.type,
				uploadedImageName: file.name,
				uploadedImageURL:  url,
				scaleX:            1,
				scaleY:            1,
			};
			cropperUI.createCropper(image[0], options);
			this.value = null;
		} else {
			window.alert('Please choose an image file.');
		}
	}
});

class CropperUI {

	constructor() {
	}

	init() {
		jQuery('img.cropper-image').each(function(index) {
			var options = {
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

	createCropper(domElement, options) {
		var elem = jQuery(domElement);
		elem.data('upload', options);
		elem.cropper({
			aspectRatio: 1,
		});
	}

	getImage(domElement) {
		return jQuery(domElement).closest('.cropper').find('img.cropper-image');
	}

	getCropper(domElement) {
		return this.getImage(domElement).data('cropper');
	}

	addImage(domElement) {
		var cropper   = this.getCropper(domElement);
		cropper.destroy();
		var fileInput = jQuery(domElement).closest('.cropper').find('input[type="file"]');
		fileInput.trigger('click');
	}

	selectImage(domElement) {
		this.destroy(domElement);
		var image   = this.getImage(domElement);
		var uri     = jQuery(domElement).find('img').attr('src');
		image[0].src = uri;
		var options = {
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
		cropper.setDragMode(value);
	}

	rotate(domElement, value) {
		var cropper = this.getCropper(domElement);
		if (cropper.cropped && cropper.options.viewMode > 0) {
			cropper.clear();
		}
		cropper.rotate(value);
		if (cropper.cropped && cropper.options.viewMode > 0) {
			cropper.crop();
		}
	}

	scaleX(domElement, value) {
		var cropper = this.getCropper(domElement);
		var elem    = this.getImage(domElement);
		var options = elem.data('upload');
		options.scaleX = value*options.scaleX;
		cropper.scaleX(options.scaleX);
	}

	scaleY(domElement, value) {
		var cropper = this.getCropper(domElement);
		var elem    = this.getImage(domElement);
		var options = elem.data('upload');
		options.scaleY = value*options.scaleY;
		cropper.scaleY(options.scaleY);
	}

	reset(domElement) {
		var cropper = this.getCropper(domElement);
		cropper.reset();
		var elem    = this.getImage(domElement);
		var options = elem.data('upload');
		options.scaleX = 1;
		options.scaleY = 1;
	}

	save(domElement) {
		var cropper = this.getCropper(domElement);
		var elem    = this.getImage(domElement);
		var options = elem.data('upload');
		if (options.uploadedImageURL) {
			// TODO Upload with data options
		} else {
			// Send data options for modifications
		}
	}

	destroy(domElement) {
		var cropper = this.getCropper(domElement);
		if (cropper) {
			// TODO Ask for confirmation
			cropper.destroy();
			cropper = null;
			var elem    = this.getImage(domElement);
			var options = elem.data('upload');
			if (options.uploadedImageURL) {
				URL.revokeObjectURL(options.uploadedImageURL);
				options.uploadedImageURL = '';
			} else {
				// TODO remove from server
			}
			// TODO remove from navigation
			elem.attr('src', '');
			elem.removeData('upload');
			elem.removeData('cropper');
		}
	}

}

var cropperUI = new CropperUI();
cropperUI.init();
