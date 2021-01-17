$(document).ready(function() {
    document.querySelector('input[type=file]').addEventListener('change', readImage, false);
    
    $(document).on('click', '.image-cancel', function() {
		let miuName = $(event.target).data('miu-name');
		let picName = $(event.target).data('miu-picname');
        let id = $(this).data('id');
        $('#miu-preview-'+id).remove();
		ignoreList.push(picName);
        $('#miu-ignore-'+miuName).val(ignoreList.join(','));
    });
});

var miu_num = 1;
var ignoreList = [];
function readImage() {
    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
		var miuName = $(event.target).data('miu-name');
		// TODO
        var output = $('#preview-images-'+miuName+' .preview-image-new');

        for (let i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.match('image')) continue;
            
            var picReader = new FileReader();
            var picName   = file.name;
            picReader.addEventListener('load', function (event) {
                var picFile = event.target;
                var html =  '<div id="miu-preview-' + miu_num + '" class="preview-image">' +
                            '<div class="image-cancel" data-id="' + miu_num + '" data-miu-name="' + miuName + '" data-miu-picname="' + picName + '"><span class="badge badge-pill badge-danger"><i class="fas fa-trash-alt"></i></span></div>' +
                            '<div class="image-zone"><img id="img-' + miu_num + '" src="' + picFile.result + '"></div>' +
                            //'<div class="tools-edit-image"><a href="javascript:void(0)" data-id="' + miu_num + '" class="btn btn-light btn-edit-image">edit</a></div>' +
                            '</div>';

                $(html).insertBefore(output);
                miu_num = miu_num + 1;
            });

            picReader.readAsDataURL(file);
        }
		// Create a new input that remembers the files or upload immediately?
		$('<input id="miu-'+miu_num+'" name="'+miuName+'-'+miu_num+'[]" type="file" multiple style="display:none;">').insertBefore($('#miu-'+miuName));
		document.querySelector('#miu-'+miu_num).files = files;
        $('#miu-'+miuName).val('');
    } else {
        console.log('Browser not support');
    }
}

