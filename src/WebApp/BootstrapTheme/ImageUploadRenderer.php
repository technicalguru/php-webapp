<?php

namespace WebApp\BootstrapTheme;

use WebApp\Utils;

class ImageUploadRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::IMAGEUPLOAD);
	}

	public function render() {
		$rc = 
			'<div class="container image-upload">'.
				'<fieldset class="form-group">'.
					'<input type="file" id="iu-'.$this->component->getName().'" data-iu-name="'.$this->component->getName().'" name="iu-'.$this->component->getName().'" accept="image/*" style="display: none;" class="form-control">'.
					'<input type="hidden" id="iu-remove-'.$this->component->getName().'" name="iu-remove-'.$this->component->getName().'">'.
				'</fieldset>'.
				'<div id="preview-images-'.$this->component->getName().'" class="preview-images-zone">';
		if ($this->component->image != NULL) {
			$rc .= $this->createImagePreview($this->component->image);
		}
		$rc .= $this->createImageUpload($this->component->image == NULL);
		$rc .=  '</div>'.
			'</div>';
		return $rc;
	}

	protected function createImagePreview($image) {
		$rc = 
			'<div id="iu-preview-'.$image->id.'" class="preview-image">'.
				'<div class="image-cancel" data-id="'.$image->id.'" data-iu-name="'.$this->component->getName().'" data-iu-picname="'.$image->id.'"><span class="badge badge-pill badge-danger"><i class="fas fa-trash-alt"></i></span></div>'.
				'<div class="image-zone"><img id="img-'.$image->id.'" src="'.$image->path.'"></div>'.
			'</div>';
		return $rc;
	}

	protected function createImageUpload($show) {
		$showStyle = $show ? '' : ' style="display:none"';
		$rc = 
			'<div id="iu-new" class="preview-image preview-image-new"'.$showStyle.'>'.
				'<div class="image-zone"><img id="img-new" src="'.Utils::getImageBasePath(TRUE).'/multi-image-upload-new.png"></div>'.
				'<div class="tools-upload-image"><a href="javascript:void(0)" onclick="$(\'#iu-'.$this->component->getName().'\').click()" class="">&nbsp</a></div>'.
			'</div>';
		return $rc;
	}
}

