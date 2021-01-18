<?php

namespace WebApp\BootstrapTheme;

use WebApp\Utils;

class MultiImageUploadRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::MULTIIMAGEUPLOAD);
	}

	public function render() {
		$rc = 
			'<div class="container multi-image-upload">'.
				'<fieldset class="form-group">'.
					'<input type="file" id="miu-'.$this->component->getName().'" class="miu-uploads" data-miu-name="'.$this->component->getName().'" name="miu-'.$this->component->getName().'[]" accept="image/*" style="display: none;" class="form-control" multiple>'.
					'<input type="hidden" id="miu-ignore-'.$this->component->getName().'" name="miu-ignore-'.$this->component->getName().'">'.
				'</fieldset>'.
				'<div id="preview-images-'.$this->component->getName().'" class="preview-images-zone">';
		foreach ($this->component->images AS $image) {
			$rc .= $this->createImagePreview($image);
		}
		$rc .= $this->createImageUpload();
		$rc .=  '</div>'.
			'</div>';
		return $rc;
	}

	protected function createImagePreview($image) {
		$rc = 
			'<div id="miu-preview-'.$image->id.'" class="preview-image">'.
				'<div class="image-cancel" data-id="'.$image->id.'" data-miu-name="'.$this->component->getName().'" data-miu-picname="'.$image->id.'"><span class="badge badge-pill badge-danger"><i class="fas fa-trash-alt"></i></span></div>'.
				'<div class="image-zone"><img id="img-'.$image->id.'" src="'.$image->path.'"></div>'.
			//	'<div class="tools-edit-image"><a href="javascript:void(0)" data-id="'.$image->id.'" class="btn btn-light btn-edit-image">edit</a></div>'.
			'</div>';
		return $rc;
	}

	protected function createImageUpload() {
		$rc = 
			'<div id="miu-new" class="preview-image preview-image-new">'.
				'<div class="image-zone"><img id="img-new" src="'.Utils::getImageBasePath(TRUE).'/multi-image-upload-new.png"></div>'.
				'<div class="tools-upload-image"><a href="javascript:void(0)" onclick="$(\'#miu-'.$this->component->getName().'\').click()" class="">&nbsp</a></div>'.
			'</div>';
		return $rc;
	}
}

