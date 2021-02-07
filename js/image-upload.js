$(document).ready(function() {
    let inputs = document.querySelectorAll('.iu-image-input');
	for (let i = 0; i < inputs.length; i++) {
		inputs[i].addEventListener('change', readSingleImage, false);
	}

    $(document).on('click', '.image-upload .image-cancel', function() {
		let iuName  = $(this).data('iu-name');
		let picName = $(this).data('iu-picname');
        let id      = $(this).data('id');
        let output  = $('#iu-preview-'+id);
		let addImage = $('#iu-new-'+iuName);
		addImage.show();
		output.remove();
		$('#iu-'+iuName).val('');
		$('#iu-remove-'+iuName).val('1');
    });
});

function readSingleImage() {
    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
		var iuName = $(event.target).data('iu-name');
        var output = $('#preview-images-'+iuName+' .preview-image-new');

		if (files.length > 0) {
            var file = files[0];
            if (file.type.match('image')) {
            
				var picReader = new FileReader();
				var picName   = file.name;
				var addImage = $('#iu-new-'+iuName);
				picReader.addEventListener('load', function (event) {
					var picFile = event.target;
					var html =  '<div id="iu-preview-new" class="preview-image">' +
								'<div class="image-cancel" data-id="new" data-iu-name="' + iuName + '" data-iu-picname="' + picName + '"><span class="badge badge-pill badge-danger"><i class="fas fa-trash-alt"></i></span></div>' +
								'<div class="image-zone"><img id="img-new-'+iuName+'" src="' + picFile.result + '"></div>' +
								'</div>';

					$(html).insertBefore(output);
					addImage.hide();
					$('#iu-remove-'+iuName).val('0');
				});

				picReader.readAsDataURL(file);
			}
        }
    } else {
        console.log('Browser not support');
    }
}

